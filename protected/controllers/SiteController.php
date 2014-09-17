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
                    $image_flag=true;
                }
            }
            if(isset($_POST['Comments']) && !empty($_POST['Comments']['text']))
            {
                $new_comment=new Comments();
                $new_comment->attributes=$_POST['Comments'];
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