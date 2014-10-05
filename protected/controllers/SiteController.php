<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
    public $pageTitle="";
    public $title="";
    public $defaultAction = 'index';
    public $loginForm = null;

    /*socket*/
    public function actionsocket()
    {
        $socket = stream_socket_server("tcp://0.0.0.0:8000", $errno, $errstr);

        if (!$socket) {
            die("$errstr ($errno)\n");
        }

        $connects = array();
        while (true) {
            //формируем массив прослушиваемых сокетов:
            $read = $connects;
            $read []= $socket;
            $write = $except = null;

            if (!stream_select($read, $write, $except, null)) {//ожидаем сокеты доступные для чтения (без таймаута)
                break;
            }

            if (in_array($socket, $read)) {//есть новое соединение
                //принимаем новое соединение и производим рукопожатие:
                if (($connect = stream_socket_accept($socket, -1)) && $info = $this->handshake($connect)) {
                    $connects[] = $connect;//добавляем его в список необходимых для обработки
                    $this->onOpen($connect, $info);//вызываем пользовательский сценарий
                }
                unset($read[ array_search($socket, $read) ]);
            }

            foreach($read as $connect) {//обрабатываем все соединения
                $data = fread($connect, 100000);

                if (!$data) { //соединение было закрыто
                    fclose($connect);
                    unset($connects[ array_search($connect, $connects) ]);
                    $this->onClose($connect);//вызываем пользовательский сценарий
                    continue;
                }

                $this->onMessage($connect, $data);//вызываем пользовательский сценарий
            }
        }

        fclose($server);
    }

    public function handshake($connect) {
        $info = array();

        $line = fgets($connect);
        $header = explode(' ', $line);
        $info['method'] = $header[0];
        $info['uri'] = $header[1];

        //считываем заголовки из соединения
        while ($line = rtrim(fgets($connect))) {
            if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
                $info[$matches[1]] = $matches[2];
            } else {
                break;
            }
        }

        $address = explode(':', stream_socket_get_name($connect, true)); //получаем адрес клиента
        $info['ip'] = $address[0];
        $info['port'] = $address[1];

        if (empty($info['Sec-WebSocket-Key'])) {
            return false;
        }

        //отправляем заголовок согласно протоколу вебсокета
        $SecWebSocketAccept = base64_encode(pack('H*', sha1($info['Sec-WebSocket-Key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "Sec-WebSocket-Accept:$SecWebSocketAccept\r\n\r\n";
        fwrite($connect, $upgrade);

        return $info;
    }
    public function encode($payload, $type = 'text', $masked = false)
    {
        $frameHead = array();
        $payloadLength = strlen($payload);

        switch ($type) {
            case 'text':
                // first byte indicates FIN, Text-Frame (10000001):
                $frameHead[0] = 129;
                break;

            case 'close':
                // first byte indicates FIN, Close Frame(10001000):
                $frameHead[0] = 136;
                break;

            case 'ping':
                // first byte indicates FIN, Ping frame (10001001):
                $frameHead[0] = 137;
                break;

            case 'pong':
                // first byte indicates FIN, Pong frame (10001010):
                $frameHead[0] = 138;
                break;
        }

        // set mask and payload length (using 1, 3 or 9 bytes)
        if ($payloadLength > 65535) {
            $payloadLengthBin = str_split(sprintf('%064b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 255 : 127;
            for ($i = 0; $i < 8; $i++) {
                $frameHead[$i + 2] = bindec($payloadLengthBin[$i]);
            }
            // most significant bit MUST be 0
            if ($frameHead[2] > 127) {
                return array('type' => '', 'payload' => '', 'error' => 'frame too large (1004)');
            }
        } elseif ($payloadLength > 125) {
            $payloadLengthBin = str_split(sprintf('%016b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 254 : 126;
            $frameHead[2] = bindec($payloadLengthBin[0]);
            $frameHead[3] = bindec($payloadLengthBin[1]);
        } else {
            $frameHead[1] = ($masked === true) ? $payloadLength + 128 : $payloadLength;
        }

        // convert frame-head to string:
        foreach (array_keys($frameHead) as $i) {
            $frameHead[$i] = chr($frameHead[$i]);
        }
        if ($masked === true) {
            // generate a random mask:
            $mask = array();
            for ($i = 0; $i < 4; $i++) {
                $mask[$i] = chr(rand(0, 255));
            }

            $frameHead = array_merge($frameHead, $mask);
        }
        $frame = implode('', $frameHead);

        // append payload to frame:
        for ($i = 0; $i < $payloadLength; $i++) {
            $frame .= ($masked === true) ? $payload[$i] ^ $mask[$i % 4] : $payload[$i];
        }

        return $frame;
    }
//пользовательские сценарии:
    public function decode($data)
    {
        $unmaskedPayload = '';
        $decodedData = array();

        // estimate frame type:
        $firstByteBinary = sprintf('%08b', ord($data[0]));
        $secondByteBinary = sprintf('%08b', ord($data[1]));
        $opcode = bindec(substr($firstByteBinary, 4, 4));
        $isMasked = ($secondByteBinary[0] == '1') ? true : false;
        $payloadLength = ord($data[1]) & 127;

        // unmasked frame is received:
        if (!$isMasked) {
            return array('type' => '', 'payload' => '', 'error' => 'protocol error (1002)');
        }

        switch ($opcode) {
            // text frame:
            case 1:
                $decodedData['type'] = 'text';
                break;

            case 2:
                $decodedData['type'] = 'binary';
                break;

            // connection close frame:
            case 8:
                $decodedData['type'] = 'close';
                break;

            // ping frame:
            case 9:
                $decodedData['type'] = 'ping';
                break;

            // pong frame:
            case 10:
                $decodedData['type'] = 'pong';
                break;

            default:
                return array('type' => '', 'payload' => '', 'error' => 'unknown opcode (1003)');
        }

        if ($payloadLength === 126) {
            $mask = substr($data, 4, 4);
            $payloadOffset = 8;
            $dataLength = bindec(sprintf('%08b', ord($data[2])) . sprintf('%08b', ord($data[3]))) + $payloadOffset;
        } elseif ($payloadLength === 127) {
            $mask = substr($data, 10, 4);
            $payloadOffset = 14;
            $tmp = '';
            for ($i = 0; $i < 8; $i++) {
                $tmp .= sprintf('%08b', ord($data[$i + 2]));
            }
            $dataLength = bindec($tmp) + $payloadOffset;
            unset($tmp);
        } else {
            $mask = substr($data, 2, 4);
            $payloadOffset = 6;
            $dataLength = $payloadLength + $payloadOffset;
        }

        /**
         * We have to check for large frames here. socket_recv cuts at 1024 bytes
         * so if websocket-frame is > 1024 bytes we have to wait until whole
         * data is transferd.
         */
        if (strlen($data) < $dataLength) {
            return false;
        }

        if ($isMasked) {
            for ($i = $payloadOffset; $i < $dataLength; $i++) {
                $j = $i - $payloadOffset;
                if (isset($data[$i])) {
                    $unmaskedPayload .= $data[$i] ^ $mask[$j % 4];
                }
            }
            $decodedData['payload'] = $unmaskedPayload;
        } else {
            $payloadOffset = $payloadOffset - 4;
            $decodedData['payload'] = substr($data, $payloadOffset);
        }

        return $decodedData;
    }

    public function onOpen($connect, $info) {
        echo "open\n";
        fwrite($connect, $this->encode('Привет'));
    }

public function onClose($connect) {
        echo "close\n";
    }

public function onMessage($connect, $data) {
        echo $this->decode($data)['payload'] . "\n";
    }
    public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
    /*
     * friends
     * */
    public function actionFriends()
    {
        if(Yum::hasModule('profile'))
            Yii::import('profile.models.*');
        if(Yum::hasModule('files'))
            Yii::import('files.models.*');
        if(Yum::hasModule('usergroup'))
            Yii::import('usergroup.models.*');
        if(Yum::hasModule('badgemanager'))
            Yii::import('badgemanager.models.*');
        if(Yum::hasModule('friendship'))
            Yii::import('friendship.models.*');
        if(Yum::hasModule('comments'))
            Yii::import('comments.models.*');
        $this->render('friends');
    }

    /*
     * user
     * */
    public function actionUser($id=null)
    {
        var_dump($_GET);
        echo $id;
        if(Yum::hasModule('profile'))
            Yii::import('profile.models.*');
        if(Yum::hasModule('files'))
            Yii::import('files.models.*');
        if(Yum::hasModule('usergroup'))
            Yii::import('usergroup.models.*');
        if(Yum::hasModule('badgemanager'))
            Yii::import('badgemanager.models.*');
        if(Yum::hasModule('friendship'))
            Yii::import('friendship.models.*');
        if(Yum::hasModule('comments'))
            Yii::import('comments.models.*');
        $this->render('user',array('id'=>$id));
    }

    public function actionLevelsmessages()
    {
//        $this->layout = Yum::module('admin')->adminLayout;
        $this->render('levelsmessages');
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        if(Yum::hasModule('profile'))
            Yii::import('profile.models.*');
        if(Yum::hasModule('files'))
            Yii::import('files.models.*');
        if(Yum::hasModule('usergroup'))
            Yii::import('usergroup.models.*');
        if(Yum::hasModule('badgemanager'))
            Yii::import('badgemanager.models.*');
        if(Yum::hasModule('friendship'))
            Yii::import('friendship.models.*');
        if(Yum::hasModule('comments'))
            Yii::import('comments.models.*');
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
    }
    public function actionCommentsadd()
    {
        $text_flag=false;
        $image_flag=false;
        $img_id=null;
        $message='';
        if(Yum::hasModule('profile'))
            Yii::import('profile.models.*');
        if(Yum::hasModule('files'))
            Yii::import('files.models.*');
        if(Yum::hasModule('comments'))
            Yii::import('comments.models.*');
        if(Yii::app()->request->isPostRequest)
        {
            $new_comment=new Comments();
            $new_comment->attributes=$_POST['Comments'];
            if(isset($_FILES['Comments']) && !empty($_FILES['Comments']['tmp_name']))
            {
                $add_file=Files::model()->create($_FILES['Comments'],'image','test','comments',null);

                if(is_array($add_file))
                {
                    $message=$add_file[0];
                }
                else
                {
                    $img_id=$add_file;
                    $new_comment->image=$img_id;
                    if(empty($new_comment->commented_user_id))
                        $new_comment->commented_user_id=Yii::app()->user->id;
                    $new_comment->create_user_id=Yii::app()->user->id;
                    $new_comment->time=strtotime(date("Y-m-d H:i:s"));
                    $image_flag=true;
                }
            }
            if(isset($_POST['Comments']) && !empty($_POST['Comments']['text']))
            {

                $new_comment->image=$img_id;
                $new_comment->parent=0;
                if(empty($new_comment->commented_user_id))
                    $new_comment->commented_user_id=Yii::app()->user->id;
                $new_comment->create_user_id=Yii::app()->user->id;
                $new_comment->time=strtotime(date("Y-m-d H:i:s"));
                $text_flag=true;
            }
            if($text_flag || $image_flag)
            {
                if($new_comment->save())
                {
                    $comm=Comments::model()->findByPk($new_comment->id);
                    if($comm)
                    {
                        $create_user_id=YumProfile::model()->findByAttributes(array('user_id'=>$comm->create_user_id));
                        $image_url="";
                        if(!is_null($comm->image) && !empty($comm->image))
                        {
                            $image=Files::model()->findByPk($comm->image);
                            if($image)
                            {
                                if(file_exists(Yii::app()->basePath."/../files/".$image->image))
                                {
                                    $image_url='/files/'.$image->image;
                                }
                            }
                        }
                        echo json_encode(array("image"=>$image_url,"text"=>$comm->text,"user"=>$create_user_id->firstname." ".$create_user_id->lastname,"message"=>$message));
                        exit();
                    }
                }
                else
                {
                    echo json_encode(array("message"=>"Not saved"));
                    exit();
                }
            }
            else
            {
                echo json_encode(array("message"=>"image or comment is empty"));
                exit();
            }
        }
        echo json_encode(array("message"=>"Some error, try again"));
        exit();

    }
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
    /**
     * Settings
     */
    public function actionSettings()
    {
        $this->render('settings');
    }
	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        $this->redirect('/user/auth');
        if(Yum::hasModule('role'))
            Yii::import('role.models.*');
        $model = new YumUser('search');

        if(isset($_GET['YumUser']))
            $model->attributes = $_GET['YumUser'];

        if(Yum::hasModule('profile')) {
            Yii::import('profile.models.*');
            $profile = new YumProfile;
            if(isset($_GET['YumProfile'])) {
                $profile->attributes = $_GET['YumProfile'];
                $model->profile = $profile;
            }
        }
        $this->render('application.modules.user.views.user.login', array(
            'model'=>$model,
            'profile'=>isset($profile) ? $profile : false,
        ));

        // If the user is already logged in send them to the return Url


//		$model=new LoginForm;
//
//		// if it is ajax validation request
//		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
//		{
//			echo CActiveForm::validate($model);
//			Yii::app()->end();
//		}
//
//		// collect user input data
//		if(isset($_POST['LoginForm']))
//		{
//			$model->attributes=$_POST['LoginForm'];
//			// validate user input and redirect to the previous page if valid
//			if($model->validate() && $model->login())
//				$this->redirect(Yii::app()->user->returnUrl);
//		}
//		// display the login form
//		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    /**
     * admin
     */
    public function actionAdmin()
    {
        if(Yum::hasModule('admin'))
        {
            if(Yii::app()->user->isAdmin()) // if admin
            {
                $this->layout = Yum::module('admin')->adminLayout;
//                $this->render('application.modules.admin.views.default.index');
                $this->renderPartial('application.modules.admin.views.default.index');
            }
        }
        else $this->redirect('/');
    }
}