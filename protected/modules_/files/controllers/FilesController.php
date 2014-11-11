<?php

class FilesController extends Controller
{

    private function ifTableExist()
    {
        return Yii::app()->db->getSchema()->getTable('files')?true:false;
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
            else $this->redirect(Yum::module('files')->installUrl);
        }
        else $this->redirect('/');
    }

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
                        if (isset($_POST['installFiles']) && $_POST['installFiles']==1) {
                            $sql = "CREATE TABLE IF NOT EXISTS `files` (
                              `id` int unsigned NOT NULL auto_increment,
                              `title` varchar(512) NOT NULL,
                              `image` varchar(512) NOT NULL,
                              `table` varchar(512) NOT NULL,
                              `timecreated` int(11) NOT NULL,
                              `user_id` int(11) NOT NULL,
                              PRIMARY KEY  (`id`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                            $db->createCommand($sql)->execute();

                            $this->redirect('index');
                        }
                        else $this->render(Yum::module('files')->installrenderUrl);
                    }
                    else
                    {
                        if($this->ifTableExist())
                            $this->render(Yum::module('files')->installrenderUrl,array('message'=>'Badge manager table is already installed. Please remove it manually to continue'));
                        else
                            $this->render(Yum::module('files')->installrenderUrl,array('message'=>''));
                    }
                }
                else throw new CException('Yii User management module is not in Debug Mode');

            }
            else
                $this->render(Yum::module('files')->installUrl,array('message'=>'Table "files" not instaled'));

        }
        else
            $this->render('/');
    }

}