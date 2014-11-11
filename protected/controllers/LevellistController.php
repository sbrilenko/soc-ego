<?php

class LevellistController extends Controller
{
    public $layout='//layouts/admin';
    private function ifTableExist()
    {
        return Yii::app()->db->getSchema()->getTable('levellist')?true:false;
    }
    public function actionIndex()
    {
        if(Yii::app()->user->id)
        {
            if($this->ifTableExist())
            {
                $this->render('/levellist/index');
            }
            else $this->redirect('/levellist/index');
        }
        else $this->redirect('/');
    }

    /*create*/
    public function actionCreate()
    {
        if(Yii::app()->user->id)
        {
            if(Yii::app()->request->isPostRequest && isset($_POST['Levellist']))
            {
                $Levellist=new Levellist();
                $Levellist->attributes=$_POST['Levellist'];
                $Levellist->timecreated=strtotime(date('Y-m-d H:i:s'));
                $Levellist->user_id=Yii::app()->user->id;
                $Levellist->save();
                $this->redirect('/levellist/index');
            }
            else
                $this->render('/levellist/create');

        }
        else $this->redirect('/');

    }
    /*update*/
    public function actionUpdate($id=null)
    {
        if(Yii::app()->user->id)
        {
            if(Yii::app()->request->isPostRequest)
            {
                $local=Levellist::model()->findByPk($_POST['Levellist']['id']);
                if($local)
                {
                    $local->attributes=$_POST['Levellist'];
                    $local->save();
                }
                $this->redirect('/levellist/index');
            }
            else
                if(!empty($id) && $id>0)
                {
                    $local=Levellist::model()->findByPk($id);
                    if($local) $this->render('/levellist/update',array('levellist'=>$local));
                    else $this->redirect('/levellist/index');
                }
                else
                    $this->redirect('/levellist/index');
        }
        else
            $this->redirect('/');
    }
    /*delete*/
    public function actionDelete($id=null)
    {
        if(Yii::app()->user->id)
        {
            $message='';
            if(!is_null($id) && $id>0)
            {
                $model=Levellist::model()->findByPk($id);
                if($model) $model->delete();
            }
            else
                $message='Wrong link';

            $model=Levellist::model()->findAll();
            $this->redirect('/levellist/index',array('message'=>$message,'model'=>$model));
        }
        else
            $this->redirect('/');

    }
}