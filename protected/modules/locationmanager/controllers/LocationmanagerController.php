<?php

class LocationManagerController extends Controller
{
	public function actionIndex()
	{
        if(Yii::app()->user->isAdmin())
        {
            if(Yii::app()->db->getSchema()->getTable('locationmanager'))
                $this->redirect(Yum::module('locationmanager')->managerUrl);
            else $this->redirect(Yum::module('locationmanager')->installUrl);
        }
        else $this->redirect('/');

	}

    public function actionManager()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            $model=LocationManager::model()->findAll();
            $this->render(Yum::module('locationmanager')->rendermanagerUrl,array('message'=>'','model'=>$model));
        }
        else
            $this->redirect('/');
    }

    public function actionDelete($id=null)
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
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
            $this->redirect(Yum::module('locationmanager')->managerUrl,array('message'=>$message,'model'=>$model));
        }
        else
            $this->redirect('/');

    }

    public function actionInsert()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            $massages='';
            if(Yii::app()->request->isPostRequest)
            {
                if(isset($_POST['LocationManager']['locationname']) && !empty($_POST['LocationManager']['locationname']))
                {
                    $model=new LocationManager();
                    $model->attributes=$_POST['LocationManager'];
                    $model->save();

                }
                else $massages='Empty field';
                $model=LocationManager::model()->findAll();
                $this->redirect(Yum::module('locationmanager')->managerUrl,array('message'=>$massages,'model'=>$model));

            }
            else
                $this->redirect(Yum::module('locationmanager')->managerUrl);


        }
        else
            $this->redirect('/');
    }
    public function actionUpdate()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
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
            $this->redirect(Yum::module('locationmanager')->managerUrl);


        }
        else
            $this->redirect('/');
    }
	public function actionInstall()
	{
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
        if ($db = Yii::app()->db) {
            $sql = 'set FOREIGN_KEY_CHECKS = 0;';
            $db->createCommand($sql)->execute();

            $transaction = $db->beginTransaction();
            if(Yii::app()->request->isPostRequest)
            {
                if(Yii::app()->db->getSchema()->getTable('locationmanager'))
                    $this->render(Yum::module('locationmanager')->installrenderUrl,array('message'=>'Location manager table is already installed. Please remove it manually to continue'));
//                    throw new CHttpException(403,'Location manager table is already installed. Please remove it manually to continue');
                if (isset($_POST['installLocationmanager']) && $_POST['installLocationmanager']==1) {
                   $sql = "CREATE TABLE IF NOT EXISTS `" . $_POST['locationManagerTable']. "` (
                  `id` int unsigned NOT NULL auto_increment,
                  `locationname` varchar(512) NOT NULL,
                  PRIMARY KEY  (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                    $db->createCommand($sql)->execute();
                    $this->redirect(Yum::module('locationmanager')->managerUrl);

                }
              else $this->render(Yum::module('locationmanager')->installrenderUrl);
            }
            else
            {
                if(Yii::app()->db->getSchema()->getTable('locationmanager'))
                    $this->render(Yum::module('locationmanager')->installrenderUrl,array('message'=>'Location manager table is already installed. Please remove it manually to continue'));
                else
                    $this->render(Yum::module('locationmanager')->installrenderUrl,array('message'=>''));
            }
	}
    else throw new CException('Yii User management module is not in Debug Mode');
        }
        else $this->redirect("/");
}
}
