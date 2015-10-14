<?php

class LocationManagerController extends Controller
{
    public $layout='//layouts/admin';
	public function actionIndex()
	{
        if(Yii::app()->user->id)
        {
            if(Yii::app()->db->getSchema()->getTable('locationmanager'))
                $this->redirect("/locationmanager/manager");
            else $this->redirect('/');
        }
        else $this->redirect('/');

	}

    public function actionManager()
    {
        if(Yii::app()->user->id && Yii::app()->user->superuser == 1)
        {
            $model=LocationManager::model()->findAll();
            $this->render("/locationmanager/manager",array('message'=>'','model'=>$model));
        }
        else
            $this->redirect('/');
    }

    public function actionDelete($id=null)
    {
        if(Yii::app()->user->id)
        {
            $message='';
            if(!is_null($_GET['id']) && $_GET['id']>0)
            {
                $model=LocationManager::model()->findByPk($_GET['id']);
                if($model) $model->delete();
            }
            else
                $message='Wrong link';

            $model=LocationManager::model()->findAll();
            $this->redirect("/locationmanager/manager",array('message'=>$message,'model'=>$model));
        }
        else
            $this->redirect('/');

    }

    public function actionInsert()
    {
        if(Yii::app()->user->id)
        {
            $massages='';
            if(Yii::app()->request->isPostRequest)
            {
                if(isset($_POST['LocationManager']['locationname']) && !empty($_POST['LocationManager']['locationname']))
                {
                    $model=new LocationManager();
                    $model->attributes=$_POST['LocationManager'];
                    if(!$model->save())
                    {
                        die(var_dump($model->getErrors()));
                    }
                }
                else
                {
                    $massages='Empty field';
                }
                $model=LocationManager::model()->findAll();
                $this->redirect("/locationmanager/manager",array('message'=>$massages,'model'=>$model));

            }
            else
                $this->redirect("/locationmanager/manager");


        }
        else
            $this->redirect('/');
    }
    public function actionUpdate()
    {
        if(Yii::app()->user->id)
        {
            if(Yii::app()->request->isPostRequest)
            {
                foreach($_POST['LocationManager'] as $locations)
                {
                    if(!empty($locations['id']) && $locations['id']>0)
                    {
                        $local=LocationManager::model()->findByPk($locations['id']);
                        $locations['locationname']=trim($locations['locationname']);
                        if($local && !empty($locations['locationname']))
                        {
                            $local->locationname=$locations['locationname'];
                            $local->save();
                        }
                    }
                }
            }
            $this->redirect("/locationmanager/manager");
        }
        else
            $this->redirect('/');
    }
}
