<?php

class GamificationManagerController extends Controller
{
	public function actionIndex()
	{
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            $massages="";
            if(Yii::app()->db->getSchema()->getTable('gamificationmanager'))
            {
                if(Yii::app()->request->isPostRequest)
                {
                    $level_array=array("Trainee","Junior","Junior_Middle","Middle","Middle_Senior","Senior","Senior_Lead","Lead","Tech_Officer");
                    $level_seniority_array=array("Low","Normal","High");
                    for($i=0;$i<count($level_array);$i++)
                    {
                        if(isset($_POST[$level_array[$i]]))
                        {
                            for($j=0;$j<count($level_seniority_array);$j++)
                            {

                                $model=GamificationManager::model()->findByAttributes(array("level"=>$level_array[$i],'seniority'=>$level_seniority_array[$j]));
                                if($model)
                                {
                                    $model->start_month=$_POST[$level_array[$i]][$level_seniority_array[$j]];
                                }
                                else
                                {
                                    $model=new GamificationManager();
                                    $model->level=$level_array[$i];
                                    $model->seniority=$level_seniority_array[$j];
                                    $model->start_month=$_POST[$level_array[$i]][$level_seniority_array[$j]];
                                }
                                $model->time=strtotime(date("Y-m-d H:i:s"));
                                $model->user=Yii::app()->user->id;
                                $model->save();

                            }
                        }
                    }
                }
                $model=GamificationManager::model()->findAll();
                $this->render(Yum::module('gamificationmanager')->renderindexUrl,array('message'=>$massages,'model'=>$model));
            }
            else $this->redirect(Yum::module('gamificationmanager')->installUrl,array('message'=>$massages));
        }
        else $this->redirect('/');

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
                if(Yii::app()->db->getSchema()->getTable('gamificationmanager'))
                    $this->render(Yum::module('gamificationmanager')->installUrl,array('message'=>'gamification manager table is already installed. Please remove it manually to continue'));
//                    throw new CHttpException(403,'gamification manager table is already installed. Please remove it manually to continue');
               if (isset($_POST['installGamificationmanager']) && $_POST['installGamificationmanager']==1) {
                   $sql = "CREATE TABLE IF NOT EXISTS `gamificationmanager` (
                  `id` int unsigned NOT NULL auto_increment,
                  `level` varchar(512) NOT NULL,
                  `seniority` varchar(512) NOT NULL,
                  `start_month` decimal(6,2) NOT NULL,
                  `time` int(11) NOT NULL,
                  `user` int(11) NOT NULL,
                  PRIMARY KEY  (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                    $db->createCommand($sql)->execute();
                    $this->redirect(Yum::module('gamificationmanager')->indexUrl);

                }
              else
                $this->render(Yum::module('gamificationmanager')->installrenderUrl,array('message'=>''));

            }
            else
            {
                if(Yii::app()->db->getSchema()->getTable('gamificationmanager'))
                    $this->render(Yum::module('gamificationmanager')->installrenderUrl,array('message'=>'gamification manager table is already installed. Please remove it manually to continue'));
                else
                    $this->render(Yum::module('gamificationmanager')->installrenderUrl,array('message'=>''));
            }
	}
    else throw new CException('Yii User management module is not in Debug Mode');
        }
        else $this->redirect("/");
}
}
