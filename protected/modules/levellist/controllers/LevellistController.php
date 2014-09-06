<?php

class LevellistController extends Controller
{
    private function ifTableExist()
    {
        return Yii::app()->db->getSchema()->getTable('levellist')?true:false;
    }
    public function actionIndex()
    {
        if(Yii::app()->user->isAdmin())
        {
            if($this->ifTableExist())
            {
                $this->layout = Yum::module('admin')->adminLayout;
                $this->render('index');
            }
            else $this->redirect(Yum::module('levellist')->installUrl);
        }
        else $this->redirect('/');
    }

    /*install*/
    public function actionInstall()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            if(!$this->ifTableExist())
            {
                if ($db = Yii::app()->db) {
                    $sql = 'set FOREIGN_KEY_CHECKS = 0;';
                    $db->createCommand($sql)->execute();
                    $transaction = $db->beginTransaction();
                    if(Yii::app()->request->isPostRequest)
                    {
                        if (isset($_POST['installLevellist']) && $_POST['installLevellist']==1) {
                            $sql = "CREATE TABLE IF NOT EXISTS `levellist` (
                              `id` int unsigned NOT NULL auto_increment,
                              `position` varchar(512) NOT NULL,
                              `description` text NOT NULL,
                              `priority` int(5) NOT NULL,
                              `timecreated` int(11) NOT NULL,
                              `user_id` int(11) NOT NULL,
                              PRIMARY KEY  (`id`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                            $db->createCommand($sql)->execute();

                            $this->redirect('index');
                        }
                        else $this->render(Yum::module('levellist')->installrenderUrl);
                    }
                    else
                    {
                        if($this->ifTableExist())
                            $this->render(Yum::module('levellist')->installrenderUrl,array('message'=>'Badge manager table is already installed. Please remove it manually to continue'));
                        else
                            $this->render(Yum::module('levellist')->installrenderUrl,array('message'=>''));
                    }
                }
                else throw new CException('Yii User management module is not in Debug Mode');

            }
            else
                $this->render(Yum::module('levellist')->installUrl,array('message'=>'Table "files" not instaled'));

        }
        else
            $this->render('/');
    }
    /*create*/
    public function actionCreate()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            if(Yii::app()->request->isPostRequest && isset($_POST['Levellist']))
            {
                $Levellist=new Levellist();
                $Levellist->attributes=$_POST['Levellist'];
                $Levellist->timecreated=strtotime(date('Y-m-d H:i:s'));
                $Levellist->user_id=Yii::app()->user->id;
                $Levellist->save();
                $this->redirect('index');
            }
            else
                $this->render('create');

        }
        else $this->redirect('/');

    }
    /*update*/
    public function actionUpdate()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            if(Yii::app()->request->isPostRequest)
            {
                $local=Levellist::model()->findByPk($_POST['Levellist']['id']);
                if($local)
                {
                    $local->attributes=$_POST['Levellist'];
                    $local->save();
                }
                $this->redirect('index');
            }
            else
                if(!empty($_GET['id']) && $_GET['id']>0)
                {
                    $local=Levellist::model()->findByPk($_GET['id']);
                    if($local) $this->render('update',array('levellist'=>$local));
                    else $this->redirect('index');
                }
                else
                    $this->redirect('index');
        }
        else
            $this->redirect('/');
    }
    /*delete*/
    public function actionDelete($id=null)
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            $message='';
            if(!is_null($_GET['id']) && $_GET['id']>0)
            {
                $model=Levellist::model()->findByPk($_GET['id']);
                if($model) $model->delete();
            }
            else
                $message='Wrong link';

            $model=Levellist::model()->findAll();
            $this->redirect('/levellist/levellist/index',array('message'=>$message,'model'=>$model));
        }
        else
            $this->redirect('/');

    }
}