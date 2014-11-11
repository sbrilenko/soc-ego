<?php

class CommentsController extends Controller
{
    public function actionIndex()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            $messages="";
            if($this->ifTableExist())
            {
                $this->render('index');
            }
            else $this->redirect(Yum::module('comments')->installUrl,array('message'=>$messages));
        }
        else $this->redirect('/');

    }
    private function ifTableExist()
    {
        return Yii::app()->db->getSchema()->getTable('comments')?true:false;
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
                        if (isset($_POST['installComments']) && $_POST['installComments']==1) {
                            $sql = "CREATE TABLE IF NOT EXISTS `comments` (
                              `id` int unsigned NOT NULL auto_increment,
                              `parent` int(11) default 0,
                              `create_user_id` int(11) NOT NULL,
                              `commented_user_id` int(11) NOT NULL,
                              `text` text default '',
                              `image` int(11) default NULL,
                              `time` int(11) NOT NULL,
                              PRIMARY KEY  (`id`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                            $db->createCommand($sql)->execute();

                            $this->redirect('index');
                        }
                        else $this->render(Yum::module('comments')->installrenderUrl);
                    }
                    else
                    {
                        if($this->ifTableExist())
                            $this->render(Yum::module('comments')->installrenderUrl,array('message'=>'Badge manager table is already installed. Please remove it manually to continue'));
                        else
                            $this->render(Yum::module('comments')->installrenderUrl,array('message'=>''));
                    }
                }
                else throw new CException('Yii User management module is not in Debug Mode');

            }
            else
                $this->render(Yum::module('comments')->installUrl,array('message'=>'Table "comments" not instaled'));

        }
        else
            $this->render('/');
    }

}