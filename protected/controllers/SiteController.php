<?php

class SiteController extends Controller
{
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
//    public function beforeAction($e){
//        if(!isset(Yii::app()->user->id) && Yii::app()->controller->getAction()->getId() == 'admin')
//        $this->redirect("/contact");
//    }
    /**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        if(!isset(Yii::app()->user->id) && isset($_POST['User']))
        {
            $model=new User();
            if(isset($_POST['User']))
            {
                $model->attributes=$_POST['User'];
                $model->rememberme=$_POST['User']['rememberme'];
                if($model->login())
                {
                    $this->render("index",array("model"=>new User()));
                }
                else
                {
                    $model->addError("error","Incorrect email or password");
                    $this->render("login",array("model"=>$model));
                }
            }
            else
                $this->render("login",array("model"=>$model));
        }
        elseif(isset(Yii::app()->user->id))
        {
            $this->render("index",array("model"=>new User()));
        }
        else
        {
            $this->render("login",array("model"=>new User()));
        }
    }
    /*comment add*/
    public function actionCommentsadd()
    {
        $text_flag=false;
        $image_flag=false;
        $img_id=null;
        $message='';
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


    public function actionAdmin()
    {
        $this->layout="//layouts/column3";
        $this->render('admin');
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
                    $this->render('index',array("model"=>$model));
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
}