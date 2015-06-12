<?php

class SiteController extends Controller
{
    public $message="";
    public function actions()
	{
		return array(
            'index' => array(
                'class' => 'SiteController',
                'view' => 'index'
            ),
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
                'view'=>'message'
			),
		);
	}
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
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $model=new User();
        $user_id=Yii::app()->user->id;
        if(!isset($user_id) && isset($_POST['User']))
        {
            if(isset($_POST['User']))
            {
                $model->attributes=$_POST['User'];
                if($model->login())
                {
                    $this->redirect('/');
                }
                else
                {
                    $this->render("login",array("model"=>$model,'error'=>"Wrong Email / Password"));
                }
            }
            else
                $this->render("login",array("model"=>$model,'error'=>''));
        }
        elseif(isset(Yii::app()->user->id)) {
            $model = User::model()->findByPk(Yii::app()->user->id);
            $this->render('index',array("model"=>$model,
                                        'avatar'=>Profile::model()->getLittleAvatar($user_id),
                                        'name'=>Profile::model()->getName($user_id),
                                        'location'=>LocationManager::model()->getLocation($user_id),
                                        'birthday'=>$this->renderPartial('birthday',array('img'=>Profile::model()->birthdayImg($user_id),
                                                                                          'date'=>Profile::model()->birthdayDate($user_id),
                                                                                          'name'=>Profile::model()->birthdayName($user_id)),true),
                                        'rank'=>$this->renderPartial('rank',array('img_class'=>Profile::model()->rankImgClass($user_id),
                                                                                  'title'=>Profile::model()->jobTitle($user_id),
                                                                                  'type'=>Profile::model()->jobType($user_id)),true),

                                        'store'=>$this->renderPartial('store',array('stores'=>Store::model()->getCountAllVisibleItem()),true),
                                        'company'=>$this->renderPartial('company',array('img'=>Profile::model()->companyImg($user_id)),true),
            ));            
        }

        else $this->render("login",array("model"=>$model,'error'=>''));

    }

    /*CommentsCommentsAdd*/
    public function actionCommentsCommentsAdd()
    {
        if(Yii::app()->request->isAjaxRequest && isset($_POST) && !empty($_POST))
        {
            if(!empty($_POST['Comments']['text']))
            {
                $new_comment=new Comments();
                $new_comment->attributes=$_POST['Comments'];
                $new_comment->image=NULL;
                $text_explode=explode(" ",$new_comment->text);
                if(count($text_explode)>0)
                {
                    $text_new="";
                    for($i=0;$i<count($text_explode);$i++)
                    {
                        if(strpos($text_explode[$i],"www.")===0 || strpos($text_explode[$i],"http://")===0 || strpos($text_explode[$i],"https://")===0)
                        {
                            if(strpos($text_explode[$i],"www.")===0) $text_explode[$i]="<a href='{$text_explode[$i]}' target='_blank'>".substr($text_explode[$i], 4, strlen($text_explode[$i]))."</a>";
                            elseif(strpos($text_explode[$i],"http://")===0) $text_explode[$i]="<a href='{$text_explode[$i]}' target='_blank'>".substr($text_explode[$i], 7, strlen($text_explode[$i]))."</a>";
                            elseif(strpos($text_explode[$i],"https://")===0) $text_explode[$i]="<a href='{$text_explode[$i]}' target='_blank'>".substr($text_explode[$i], 8, strlen($text_explode[$i]))."</a>";
                            if($i==0)$text_new .= $text_explode[$i];
                            else $text_new .=" ".$text_explode[$i];
                        }
                        else {
                            if($i==0)$text_new .= $text_explode[$i];
                            else $text_new .=" ".$text_explode[$i];
                        }
                    }
                    $new_comment->text=$text_new;
                }
                $new_comment->commented_user_id=Yii::app()->user->id; //
                $new_comment->time=strtotime(date("Y-m-d H:i:s"));
                if($new_comment->save())
                {
                    $html="<table style='width: 95%;'>";
                    $html.="<tr>";
                    $html.='<td class="padding-zero wall-avatar-td"></td>';
                    $html.="<td class='padding-zero'>";
                    $html.='<div class="message-buble">
                        <div class="message-buble-triangle-back"></div>
                        <div class="comment-owner">'.htmlspecialchars(Profile::model()->findByAttributes(array("user_id"=>$new_comment->create_user_id))->firstname." ".Profile::model()->findByAttributes(array("user_id"=>$new_comment->create_user_id))->lastname).'</div>
                    <div class="comment">'.htmlspecialchars($new_comment->text).'</div>
                    </div>';
                    $html.="</td>";
                    $html.="</tr>";

                    $html.="</table>";
                    echo json_encode(array("error"=>false,"message"=>"Saved","html"=>$html));
                    exit();
                }
                else
                {
                    echo json_encode(array("error"=>true,"message"=>"Not saved","html"=>""));
                    exit();
                }
            }
            else
            {
                echo json_encode(array("error"=>true,"message"=>"Comment cannot be empty","html"=>""));
                exit();
            }
        }
        else
        {
            echo json_encode(array("error"=>true,"message"=>"Not a post request","html"=>""));
            exit();
        }
    }
    /*comment add*/
    public function actionCommentsAdd()
    {
        $text_flag=false;
        $image_flag=false;
        $img_id=null;
        $message='';
//        if(Yii::app()->request->isAjaxRequest)
        if(isset($_POST) && !empty($_POST))
        {
            if(isset($_POST) && !empty($_POST))
            {
                $new_comment=new Comments();
                $new_comment->attributes=$_POST['Comments'];
                $text_explode=explode(" ",$new_comment->text);
                if(count($text_explode)>0)
                {
                    $text_new="";
                    for($i=0;$i<count($text_explode);$i++)
                    {
                        if(strpos($text_explode[$i],"www.")===0 || strpos($text_explode[$i],"http://")===0 || strpos($text_explode[$i],"https://")===0)
                        {
                            if(strpos($text_explode[$i],"www.")===0) $text_explode[$i]="<a href='{$text_explode[$i]}' target='_blank'>".substr($text_explode[$i], 4, strlen($text_explode[$i]))."</a>";
                            elseif(strpos($text_explode[$i],"http://")===0) $text_explode[$i]="<a href='{$text_explode[$i]}' target='_blank'>".substr($text_explode[$i], 7, strlen($text_explode[$i]))."</a>";
                            elseif(strpos($text_explode[$i],"https://")===0) $text_explode[$i]="<a href='{$text_explode[$i]}' target='_blank'>".substr($text_explode[$i], 8, strlen($text_explode[$i]))."</a>";
                            if($i==0)$text_new .= $text_explode[$i];
                            else $text_new .=" ".$text_explode[$i];
                        }
                        else {
                            if($i==0)$text_new .= $text_explode[$i];
                            else $text_new .=" ".$text_explode[$i];
                        }
                    }
                    $new_comment->text=$text_new;
                }
            }
            else{
                echo json_encode(array("error"=>true,"message"=>"Empty data"));
                exit();
            }

            if(isset($_FILES['Comments']) && !empty($_FILES['Comments']['tmp_name']))
            {
                $add_file=Files::model()->create($_FILES['Comments'],'image','test',Comments::model()->tableName(),null);

                if(is_array($add_file))
                {
                    echo json_encode(array("error"=>false,"message"=>$add_file[0],"html"=>""));
                    exit();
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
                        $create_user_id=Profile::model()->findByAttributes(array('user_id'=>$comm->create_user_id));
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
//                        echo json_encode(array("image"=>$image_url,"text"=>$comm->text,"user"=>$create_user_id->firstname." ".$create_user_id->lastname,"message"=>$message));
                        echo json_encode(array("error"=>false,"message"=>"","html"=>$this->renderPartial("message",array("index"=>1,"com"=>$comm),true)));
                        exit();
                    }
                }
                else
                {
                    echo json_encode(array("error"=>true,"message"=>"Not saved"));
                    exit();
                }
            }
            else
            {
                echo json_encode(array("error"=>true,"message"=>"image or comment is empty"));
                exit();
            }
        }
        else
        {
            echo json_encode(array("error"=>true,"message"=>"Some error, try again"));
            exit();
        }

    }

    public function actionMessages()
    {
        if(isset(Yii::app()->user->id))
            $this->render('messages',array("friends"=>Message::model()->messageStructure(Message::model()->getAllFriendsMessages(Yii::app()->user->id))));
        else $this->redirect('/');
    }

    public function actionAdmin()
    {
        $this->layout="//layouts/column3";
        if(isset(Yii::app()->user->id))
        {
            if(User::model()->isAdmin(Yii::app()->user->id))
                $this->render('admin');
        }
        else $this->redirect('/');

    }
    public function actionLogin()
    {
        if(!isset(Yii::app()->user->id) || isset($_POST['User']))
        {
            $model=new User();
            if(isset($_POST['User']))
            {
                $model->attributes=$_POST['User'];
                if($model->login())
                {
                    $model=User::model()->findByAttributes(array('email'=>trim(strtolower($model->email))));
//                    $this->render('index',array("model"=>new User(),
//                        'avatar'=>Profile::model()->getLittleAvatar($model->id),
//                        'name'=>Profile::model()->getName($model->id),
//                        'location'=>LocationManager::model()->getLocation($model->id),
//                        'birthday'=>$this->renderPartial('birthday',array('img'=>Profile::model()->birthdayImg($model->id),
//                                'date'=>Profile::model()->birthdayDate($model->id),
//                                'name'=>Profile::model()->birthdayName($model->id)),true),
//                        'rank'=>$this->renderPartial('rank',array('img_class'=>Profile::model()->rankImgClass($model->id),
//                                'title'=>Profile::model()->jobTitle($model->id),
//                                'type'=>Profile::model()->jobType($model->id)),true),
//
//                        'store'=>$this->renderPartial('store',array('stores'=>Store::model()->getCountAllVisibleItem()),true),
//                        'company'=>$this->renderPartial('company',array('img'=>Profile::model()->companyImg($model->id)),true),
//                    ));
//                    $this->redirect('/');
                }
                else
                    $this->renderPartial('login',array("model"=>$model));
            }
            else
                $this->renderPartial('login',array("model"=>$model));
        }
        else
            $this->renderPartial("login",array("model"=>new User()));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect("/");
    }
    /*forgotpass*/
    public function actionForgotPass()
    {
        if(isset(Yii::app()->user->id))
        {
            $this->redirect("/");
        }
        else
        {
            $model=new User();
            if(isset($_POST['User']))
            {
                $model->attributes=$_POST['User'];
                if(empty($model->email))
                {
                    $this->render('forgotpass',array("model"=>new User(),"error"=>'Email cannot be empty','message'=>''));
                }
                /*search user*/
                $seruser=User::model()->findByAttributes(array('email'=>$model->email));
                if($seruser)
                {
                    $subject = 'GiraFFe Network change password';
                    $headers = 'From: GiraFFe Network'. "\r\n";
                    $headers .= 'MIME-Version: 1.0'."\r\n";
                    $headers .= 'Content-Type: text/html; charset=utf-8'."\r\n";

                    $newpass=$seruser->genpass();
                    $seruser->password=$newpass;
                    if($seruser->save())
                    {
                        $body="A very special welcome to you, Name! You joined giraffe.ego-cms.com.";
                        $body.="<br /><br />";
                        $body.="Your password is ".$newpass;
                        $body.="<br />";
                        $body.="Please, keep it secret and safe!";
                        $body.="<br /><br />";
                        $body.="We hope you enjoy your time at GiraFFe Network! If you have any problems, questions, opinions, comments, suggestions, please feel free to contact us any time.";
                        $body.="<br /><br />";
                        $body.="Best Regards,";
                        $body.="<br />";
                        $body.="GiraFFe Network Support Team";
                        $body.="<br />";
                        if(mail($seruser->email,$subject,$body,$headers,"-fsupport@giraffe.ego-cms.com"))
                            $this->render('forgotpass',array("model"=>new User(),"error"=>'','message'=>'Message was sent'));
                        else $this->render('forgotpass',array("model"=>new User(),"error"=>'','message'=>'Message was not sent'));
                    }
                    else
                    $this->render('forgotpass',array("model"=>new User(),"error"=>'','message'=>'Password don\'t save'));
                }
                else
                {
                    $this->render('forgotpass',array("model"=>new User(),"error"=>'User with this email not found','message'=>''));
                }
            }
            else
            {
                $this->render('forgotpass',array("model"=>new User(),"error"=>'','message'=>''));
            }
        }
    }
    /*all user by company*/
    public function actionAllUserByCompany()
    {
        if(isset($_POST['Usergroup']['company']))
        {
            $html=$this->renderPartial("user-by-company",array("group"=>Usergroup::model()->findByPk($_POST['Usergroup']['id']),"model"=>User::model()->getAllUsersByCompany($_POST['Usergroup']['company'])),true);
            if(isset($_POST['Usergroup']) && !empty($_POST['Usergroup']) && isset($_POST['Usergroup']['company']) && !empty($_POST['Usergroup']['company']))
                echo json_encode(array("error"=>false,"message"=>"","html"=>$html));
            else echo json_encode(array("error"=>true,"message"=>"","html"=>$html));
        }
        else
        {
            $this->redirect("/");
        }
    }

    /*getAllFriends*/
    public function actionGetAllFriends()
    {
        $ret_items=array();
        $models=Friendship::model()->findAllBySql("select * from friendship where (inviter_id=:inviter_id OR friend_id=:friend_id) AND status=1 ORDER BY updatetime", array(':inviter_id'=>Yii::app()->user->id,':friend_id'=>Yii::app()->user->id));
        if($models)
        {
            foreach($models as $val)
            {
                if($val->inviter_id==Yii::app()->user->id)
                {
                    $dsdd=Profile::model()->getName($val->friend_id);
                    $user_friends=Profile::model()->findByAttributes(array("user_id"=>$val->friend_id));
                    $icon="/img/default-user.png";
                    if($user_friends->avatar)
                    {
                        $file_company=Files::model()->findByPk($user_friends->avatar);
                        if($file_company)
                        {
                            if(file_exists(Yii::app()->basePath."/../files/".$file_company->image))
                            {
                                $icon="/files/".$file_company->image;
                            }
                            else
                            {
                                $icon="/img/default-user.png";
                            }
                        }
                        else
                        {
                            $icon="/img/default-user.png";
                        }
                    }
                    $ret_items[]=array('value'=>$dsdd,'label'=>$dsdd,'id'=>$val->friend_id,'icon'=>$icon,'position'=>Profile::model()->jobType($val->friend_id));
                }
                else
                {
                    $dsdd=Profile::model()->getName($val->inviter_id);
                    $user_friends=Profile::model()->findByAttributes(array("user_id"=>$val->inviter_id));
                    $icon="/img/default-user.png";
                    if($user_friends->avatar)
                    {
                        $file_company=Files::model()->findByPk($user_friends->avatar);
                        if($file_company)
                        {
                            if(file_exists(Yii::app()->basePath."/../files/".$file_company->image))
                            {
                                $icon="/files/".$file_company->image;
                            }
                            else
                            {
                                $icon="/img/default-user.png";
                            }
                        }
                        else
                        {
                            $icon="/img/default-user.png";
                        }
                    }
                    $ret_items[]=array('value'=>$dsdd,'label'=>$dsdd,'id'=>$val->inviter_id,'icon'=>$icon,'position'=>Profile::model()->jobType($val->inviter_id));
                }
            }
        }
        echo json_encode(array('error'=>false,'data'=>$ret_items));
    }

    /*like*/
    public function actionLike()
    {
        if(isset($_POST) && !empty($_POST['Comments']))
        {
            $like_search=Likes::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'comments_id'=>$_POST['Comments']['id']));
            if($like_search)
            {
                if($like_search->like==0)
                {
                    $like_search->like=1;
                }
                else $like_search->like=0;
                $like_search->save();
            }
            else
            {
                $like=new Likes();
                $like->comments_id=$_POST['Comments']['id'];
                $like->user_id=Yii::app()->user->id;
                $like->like=1;
                $like->save();
            }
        }
        echo json_encode(array('error'=>false,'message'=>count(Likes::model()->findByAttributes(array('like'=>1,'user_id'=>Yii::app()->user->id,'comments_id'=>$_POST['Comments']['id'])))));
    }

    /*sendQuickMessage*/
    public function actionSendQuickMessage()
    {
        if(Yii::app()->request->isPostRequest)
        {
            $from_user=trim($_POST['from_user']);
            $to_user=trim($_POST['to_user']);
            $text=trim($_POST['text']);
            if(empty($from_user) || !User::model()->findByPk($from_user))
            {
                echo json_encode(array('error'=>true,'message'=>'User that send do not exists'));
                exit();
            }
            elseif(empty($to_user) || !User::model()->findByPk($to_user))
            {
                echo json_encode(array('error'=>true,'message'=>'Please choose the user'));
                exit();
            }
            elseif(empty($text))
            {
                echo json_encode(array('error'=>true,'message'=>'Message cannot be empty'));
                exit();
            }
            $message=new Message();
            $message->timestamp=strtotime(date('Y-m-d H:i:s'));
            $message->from_user_id=$from_user;
            $message->to_user_id=$to_user;
            $message->message=$text;
            $message->message_read=0;
            $message->answered=0;
            $message->draft=0;
            if($message->save())
            {
                echo json_encode(array('error'=>false,'message'=>'Saved'));
            }
            else
            {
                echo json_encode(array('error'=>true,'message'=>print_r($message->getErrors(),true)));
            }
        }
        else
        {
            echo json_encode(array('error'=>true,'message'=>'No data'));
        }
    }

    /*message history*/
    public function actiongetMessagesHistory()
    {
        if(Yii::app()->request->isPostRequest)
        {
            /*check the post data*/
            $message=new Message();
            $message->attributes=$_POST['Message'];
            if($message)
            {
                if($message->from_user_id!==Yii::app()->user->id && $message->to_user_id!==Yii::app()->user->id)
                {
                    echo json_encode(array('error'=>true,'message'=>'This is no history'));
                    exit();
                }
                else
                {
                    $from_id=$message->from_user_id;
                    $to_id=$message->to_user_id;
                    $from_icon="/img/default-user.png";
                    $to_icon="/img/default-user.png";
                    $from_icon_model=Profile::model()->findByAttributes(array("user_id"=>$message->from_user_id));
                    $from_position=Profile::model()->jobType($message->from_user_id);
                    $to_icon_model=Profile::model()->findByAttributes(array("user_id"=>$message->to_user_id));
                    $to_position=Profile::model()->jobType($message->to_user_id);
                    $from_name=Profile::model()->getName($message->from_user_id);
                    $to_name=Profile::model()->getName($message->to_user_id);
                    if($from_icon_model->avatar)
                    {
                        $user_image=Files::model()->findByPk($from_icon_model->avatar);
                        if($user_image)
                        {
                            if(file_exists(Yii::app()->basePath."/../files/".$user_image->image))
                            {
                                $from_icon="/files/".$user_image->image;
                            }
                        }
                    }
                    if($to_icon_model->avatar)
                    {
                        $user_image=Files::model()->findByPk($to_icon_model->avatar);
                        if($user_image)
                        {
                            if(file_exists(Yii::app()->basePath."/../files/".$user_image->image))
                            {
                                $to_icon="/files/".$user_image->image;
                            }
                        }
                    }
                    $ret_messages=array();
                    if(Yii::app()->user->id==$message->from_user_id)
                    {
                        $messages=Message::model()->getAllMessagesSendingToMe($message->from_user_id,$message->to_user_id);
                    }
                    else
                    {
                        $messages=Message::model()->getAllMessagesSendingToMe($message->to_user_id,$message->from_user_id);
                    }

                    foreach($messages as $mess)
                    {
                        $ret_messages[]=array('from_id'=>$mess->from_user_id,'to_id'=>$mess->to_user_id,'message'=>$mess->message,'read_status'=>$mess->message_read,'date'=>date('H:i',$mess->timestamp));
                    }

                    //dialogmessages
                    echo json_encode(array('error'=>false,
                                           'message'=>'',
                                           'from_id'=>$from_id,
                                           'to_id'=>$to_id,
                                           'html'=>$this->renderPartial('dialogmessages',array(
                                           'from_id'=>$from_id,
                                           'to_id'=>$to_id,
                                           'from_name'=>$from_name,
                                           'to_name'=>$to_name,
                                           'from_position'=>$from_position,
                                           'to_position'=>$to_position,
                                           'from_icon'=>$from_icon,
                                           'to_icon'=>$to_icon,
                                           'current_user_id'=>Yii::app()->user->id,
                                           'messages'=>$ret_messages),true)
                    ));
                    exit();
                }
            }
            else{
                echo json_encode(array('error'=>true,'message'=>'History not found'));
                exit();
            }

        }
        else echo json_encode(array('error'=>true,'message'=>'No data'));
    }

    /*create file for message*/
    public function actionMessageCreateFile()
    {
        $image_id=null;
        $real_name="";
        if(isset($_FILES['Message']) && !empty($_FILES['Message']['name']['pict']))
        {
            if(isset($_POST['Message']['image'])) $image_id=$_POST['Message']['image'];
            $file_ret=Files::model()->create($_FILES['Message'],'pict','test',Message::model()->tableName(),$image_id);
            if(is_array($file_ret))
            {
                echo json_encode(array('error'=>true,'message'=>$file_ret[0],'id'=>null,'name'=>$real_name));
                exit();
            }
            else
            {
                if($file_ret) $real_name=Files::model()->findByPk($file_ret)->real_name;
                echo json_encode(array('error'=>false,'message'=>$file_ret[0],'id'=>$file_ret,'name'=>$real_name));
                exit();
            }
        }
        else
        {
            echo json_encode(array('error'=>true,'message'=>'File not found','id'=>null,'name'=>$real_name));
        }
    }
    /*message remove file*/
    public function actionMessageRemoveFile()
    {
        $image_id=null;
        if(isset($_POST['Message']) && !empty($_POST['Message']['image']))
        {
            $file_rem=Files::model()->findByPk($_POST['Message']['image']);
            if($file_rem)
            {
                Files::model()->delete($file_rem->id);
                echo json_encode(array('error'=>false,'message'=>'File removed'));
                exit();
            }
            else
            {
                echo json_encode(array('error'=>false,'message'=>'File not removed'));
                exit();
            }
        }
        else
        {
            echo json_encode(array('error'=>true,'message'=>'File not found'.print_r($_POST['Message']['id'])));
        }
    }

    /*new layout*/
    public function actionNew()
    {
        $this->render('new');
    }

    /*faq*/
    public function actionFaq()
    {
        $user_id=Yii::app()->user->id;
        if(isset($user_id))
        {
            $jobtype=JobType::model()->findAll();
            $jobtitle=JobTitle::model()->findAll();
            $this->render('faq',array('jobtype'=>$jobtype,'jobtitle'=>$jobtitle));
        }
        else $this->redirect('/');

    }
    /*groups*/
    public function actionGroups()
    {
        $user_id=Yii::app()->user->id;
        if(isset($user_id))
        {
            $this->render('groups');
        }
        else $this->redirect('/');
    }
}