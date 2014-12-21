<?php

class UsergroupController extends Controller {
    public $layout='//layouts/admin';
	public function beforeAction($event) {
		return parent::beforeAction($event);
	}

	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('index','view'),
					'users'=>array('*'),
					),
				array('allow',
					'actions'=>array(
						'getOptions', 'create','update', 'browse', 'join', 'leave', 'write'),
					'users'=>array('@'),
					),
				array('allow',
					'actions'=>array('admin','delete'),
					'users'=>array('admin'),
					),
				array('deny',
					'users'=>array('*'),
					),
				);
	}

	public function actionWrite() {
		$message = new UsergroupMessage;

		if(isset($_POST['UsergroupMessage'])) {
			$message->attributes = $_POST['UsergroupMessage'];
			$message->author_id = Yii::app()->user->id;
			$message->save();
		}

		$this->redirect(array('//usergroup/groups/view',
					'id' => $message->group_id));

	}

	public function actionJoin($id,$user_id) {
        if(Yii::app()->user->id)
        {
            if($id !== null) {
                $p = Usergroup::model()->findByPk($id);

                $participants = empty($p->participants)?array():explode(",",$p->participants);
                if(in_array($user_id, $participants)) {
//                    Yum::setFlash(Yum::t('You are already participating in this group'));
                } else {
                    if(count($participants)>0)
                    {
                        $p->participants =$p->participants.",".$user_id;
                    }
                    else
                    {
                        $p->participants=$user_id;
                    }

                    if($p->save(array('participants'))) {
//                        Yum::setFlash(Yum::t('You have joined this group'));
//                        Yum::log(Yum::t('User {username} joined group id {id}', array(
//                                        '{username}' => YumUser::model()->findByPk($user_id)->username,
//                                        '{id}' => $id)));

                    }
                }
//                $this->redirect(array('//usergroup/groups/view', 'id' => $id));
            }
//            else throw new CHttpException(404);
        }
	}

	public function actionLeave($id = null) {
        if(Yii::app()->user->id)
        {
            if($id !== null) {
                $p = Usergroup::model()->findByPk($id);

                $participants = $p->participants;
                if(!in_array(Yii::app()->user->id, $participants)) {
//                    Yum::setFlash(Yum::t('You are not participating in this group'));
                } else {
//                    $participants = $p->participants;
                    foreach($participants as $key => $participant)
                        if($participant == Yii::app()->user->id)
                            unset($participants[$key]);
//                    $p->participants = $participants;

                    if($p->save(array('participants'))) {
//                        Yum::setFlash(Yum::t('You have left this group'));
//                        Yum::log(Yum::t('User {username} left group id {id}', array(
//                            '{username}' => Yii::app()->user->data()->username,
//                            '{id}' => $id)));

                    }
                }
                $this->redirect(array('//usergroup/groups/index'));
            } else throw new CHttpException(404);
        }
        else $this->redirect("index");

	}

	public function actionView($id) {
		$model = $this->loadModel($id);

		$this->render('view',array(
					'model' => $model,
					));
	}

	public function loadModel($id = false)
	{
		if($this->_model === null)
		{
			if(is_numeric($id))
				$this->_model = Usergroup::model()->findByPk($id);
			else if(is_string($id))
				$this->_model = Usergroup::model()->find('title = :title', array(
							':title' => $id));
			if($this->_model === null)
				throw new CHttpException(404,'The requested Usergroup does not exist.');
		}
		return $this->_model;
	}

	public function actionCreate() {
        if(Yii::app()->user->id)
        {
            //		$model = new YumUsergroup;
            //
            //		$this->performAjaxValidation($model, 'usergroup-form');
            //
            //		if(isset($_POST['YumUsergroup'])) {
            //			$model->attributes = $_POST['YumUsergroup'];
            //			$model->owner_id = Yii::app()->user->id;
            //			$model->participants = array($model->owner_id);
            //			if($model->save())
            //				$this->redirect(array('view','id'=>$model->id));
            //		}
            //		$this->render('create',array( 'model'=>$model));
            if(Yii::app()->request->isPostRequest)
            {
                if(Yii::app()->request->isPostRequest && isset($_POST['Usergroup']))
                {
                    $group=new Usergroup();
                    $old_image=$group->image;
                    $group->attributes=$_POST['Usergroup'];
                    if(isset($_FILES['Usergroup']) && !empty($_FILES['Usergroup']['name']['image']))
                    {
                        $file_ret=Files::model()->create($_FILES['Usergroup'],'image',$title='test',Usergroup::model()->tableName(),null);
                        if(!is_array($file_ret))
                        {
                            $group->image=$file_ret;
                        }
                        else $group->image=$old_image;

                        /*participants*/
                        $group->time_create=strtotime(date("Y-m-d H:i:s"));
                        $group->user_create=Yii::app()->user->id;
                        if($group->save())
                        {
                            if(count($_POST['Usergroup']['participants'])>0)
                            {
                                foreach($_POST['Usergroup']['participants'] as $index=>$part)
                                {
                                    if($part=="1")
                                    {
                                        $new_particial=new Participants();
                                        $new_particial->user_id=$index;
                                        $new_particial->group_id=$group->id;
                                        $new_particial->time=strtotime(date("Y-m-d H:i:s"));
                                        $new_particial->save();
                                    }
                                }
                            }
                            $this->redirect('index');
                        }
                        else
                        {
                            $this->redirect('create');
                        }
                    }
                    else
                        $this->render('create',array("messages"=>"Fields with * are required."));
                }
                else
                    $this->render('create',array("messages"=>"Fields with * are required."));
            }
            else
            {
                $model = new Usergroup;
                $this->render('create',array( 'model'=>$model));
            }
        }
    }

	public function actionUpdate($id = false)
	{
        if(Yii::app()->user->id)
        {
            if(Yii::app()->request->isPostRequest)
            {
                if(Yii::app()->request->isPostRequest && isset($_POST['Usergroup']))
                {
                    $group=Usergroup::model()->findByPk($id);
                    $old_image=$group->image;
                    $group->attributes=$_POST['Usergroup'];
                    if(isset($_FILES['Usergroup']) && !empty($_FILES['Usergroup']['name']['image']))
                    {
                        $file_ret=Files::model()->create($_FILES['Usergroup'],'image',$title='test',Usergroup::model()->tableName(),null);
                        if(is_array($file_ret))
                        {
                            $this->render('update',array('model'=>$group,'message'=>$file_ret[0]));
                            exit();
                        }
                    }
                    else $group->image=$old_image;
                    $group->time_create=strtotime(date("Y-m-d H:i:s"));
                    $group->user_create=Yii::app()->user->id;
                    if($group->save())
                    {
                        $all_part=Participants::model()->findAllByAttributes(array("group_id"=>$group->id));
                        if($all_part)
                        {
                            foreach($all_part as $index=>$val)
                            {
                                $val->status=0;
                                $val->save();
                            }
                        }
                        if(count($_POST['Usergroup']['participants'])>0)
                        {
                            foreach($_POST['Usergroup']['participants'] as $index=>$part)
                            {
                                if($part=="1")
                                {
                                    $isset=Participants::model()->findByAttributes(array("user_id"=>$index,"group_id"=>$group->id));
                                    if($isset)
                                    {
                                        $isset->status=1;
                                        $isset->time=strtotime(date("Y-m-d H:i:s"));
                                        if($isset->save())
                                        {
                                            $this->redirect('index');
                                        }
                                        else{
                                            $this->render('update',array('model'=>$group,'message'=>"Not saved"));
                                            exit();
                                        }
                                    }
                                    else
                                    {
                                        $new_particial=new Participants();
                                        $new_particial->user_id=$index;
                                        $new_particial->group_id=$group->id;
                                        $new_particial->status=1;
                                        $new_particial->time=strtotime(date("Y-m-d H:i:s"));
                                        if($new_particial->save())
                                        {

                                        }
                                        else{

                                        }
                                    }

                                }
                            }
                        }
                    }
                    else
                    {
                        $this->redirect('update',array("model"=>$group));
                    }

                }
                else
                    $this->render('update',array("model"=>Usergroup::model()->findByPk($id),"messages"=>"Fields with * are required."));
            }
            else
            {
                $model =Usergroup::model()->findByPk($_GET['id']);
                $this->render('update',array('model'=>$model));
            }
        }
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel()->delete();

			if(!isset($_GET['ajax']))
			{
				if(isset($_POST['returnUrl']))
					$this->redirect($_POST['returnUrl']);
				else
					$this->redirect(array('admin'));
			}
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

	public function actionIndex($owner_id = null)
	{
        $model=Usergroup::model()->findAll();
        $model=new Usergroup('search');
        $model->unsetAttributes();
//
        if(isset($_GET['Usergroup']))
            $model->attributes = $_GET['Usergroup'];
        $this->render('admin',array(
            'model'=>$model,
        ));
	}

	public function actionBrowse()
	{
		$model=new Usergroup('search');
		$model->unsetAttributes();

		if(isset($_GET['Usergroup']))
			$model->attributes = $_GET['Usergroup'];

		$this->render('browse',array(
					'model'=>$model,
					));
	}

	public function actionAdmin()
	{
        $model=Usergroup::model()->findAll();
		$model=new Usergroup('search');
		$model->unsetAttributes();
//
		if(isset($_GET['Usergroup']))
			$model->attributes = $_GET['Usergroup'];
		$this->render('admin',array(
					'model'=>$model,
					));
	}

}
