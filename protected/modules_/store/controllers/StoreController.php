<?php
class StoreController extends Controller
{
    public function actionIndex()
	{
        if(Yum::module()->enableBootstrap)
            Yum::register('css/bootstrap.min.css');
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            if(Yii::app()->db->getSchema()->getTable('store'))
                $this->render('index');
            else
                $this->redirect(Yum::module('store')->installUrl);
        }
        else
		$this->redirect('/');
	}
    /*create*/
    public function actionCreate()
    {
        if(Yum::module()->enableBootstrap)
            Yum::register('css/bootstrap.min.css');
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            if(Yii::app()->request->isPostRequest && isset($_POST['Store']))
            {
                $store=new Store();
                $store->attributes=$_POST['Store'];
                if(isset($_FILES['Store']) && !empty($_FILES['Store']['name']['image']))
                {
                    $file_ret=Files::model()->create($_FILES['Store'],'image',$title='test',Store::model()->tableName());
                    if(is_array($file_ret))
                    {
                        $this->render('create',array('message'=>$file_ret[0]));
                    }
                    else
                    {
                        $store->image=$file_ret;
                        $store->time=strtotime(date("Y-m-d H:i:s"));
                        $store->user=Yii::app()->user->id;
                        if($store->save())
                        {
                            $this->redirect('index');
                        }
                        else
                        {
                            $this->render('create',array('message'=>'Store model not saved! Please ask your specialist'));
                        }
                    }
                }
                else
                {
                    $this->render('create',array('message'=>'please put the image'));
                }
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
        if(Yum::module()->enableBootstrap)
            Yum::register('css/bootstrap.min.css');
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
                if(Yii::app()->request->isPostRequest)
                {
                    $local=Store::model()->findByPk($_POST['Store']['id']);
                    if($local)
                    {
                        if(isset($_FILES['Store']) && !empty($_FILES['Store']['name']['image']))
                        {
                            $file_ret=Files::model()->create($_FILES['Store'],'image',$title='test',Store::model()->tableName(),$local->image);
                            if(is_array($file_ret))
                            {
                                $this->render('update'.$_POST['Store']['id'],array('message'=>$file_ret[0]));
                                exit();
                            }
                            else
                            {
                                $local->attributes=$_POST['Store'];
                                $local->image=$file_ret;
                                $local->time=strtotime(date("Y-m-d H:i:s"));
                                $local->user=Yii::app()->user->id;
                                if($local->save())
                                {
                                    $this->redirect('index');
                                }
                                else
                                {
                                    $this->render('index',array('message'=>'Store model not saved! Please ask your specialist'));
                                }
                            }
                        }
                        else
                        {
                            $image=$local->image;
                            $local->attributes=$_POST['Store'];
                            $local->image=$image;
                            $local->time=strtotime(date("Y-m-d H:i:s"));
                            $local->user=Yii::app()->user->id;
                            $local->save();
                            $this->render('index',array('message'=>'please put the image'));
                        }
                        $local->attributes=$_POST['Store'];
                        $local->time=strtotime(date("Y-m-d H:i:s"));
                        $local->user=Yii::app()->user->id;
                        $local->save();
                    }
                    $this->redirect('index');
                }
                else
                if(!empty($_GET['id']) && $_GET['id']>0)
                {
                    $local=Store::model()->findByPk($_GET['id']);
                    if($local) $this->render('update',array('store_item'=>$local));
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
                $model=Store::model()->findByPk($_GET['id']);
                if($model)
                {
                    Files::model()->delete($model->image);
                    //and delete files
                    $model->delete();
                }
            }
            else
                $message='Wrong link';
            $model=Store::model()->findAll();
            $this->redirect('/store/store/index',array('message'=>$message,'model'=>$model));
        }
        else
            $this->redirect('/');

    }
    /*install*/
    public function actionInstall()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            if(!Yii::app()->db->getSchema()->getTable('store'))
            {
            if ($db = Yii::app()->db) {
                $sql = 'set FOREIGN_KEY_CHECKS = 0;';
                $db->createCommand($sql)->execute();
                $transaction = $db->beginTransaction();
                if(Yii::app()->request->isPostRequest)
                {
                    if (isset($_POST['installStore']) && $_POST['installStore']==1) {
                        $sql = "CREATE TABLE IF NOT EXISTS `store` (
                              `id` int unsigned NOT NULL auto_increment,
                              `title` varchar(512) NOT NULL,
                              `description` text NOT NULL,
                              `image` int(11) NOT NULL,
                              `price` decimal (10,2) NOT NULL,
                              `time` int(11) NOT NULL,
                              `user` int(11) NOT NULL,
                              `hide` int(2) NOT NULL,
                              `stock` int(2) NOT NULL,
                              `count` int(11) NOT NULL,
                              PRIMARY KEY  (`id`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                        $db->createCommand($sql)->execute();

                        $sql = "CREATE TABLE IF NOT EXISTS `orders_from_store` (
                              `id` int unsigned NOT NULL auto_increment,
                              `user_id` int(11) NOT NULL,
                              `store_item_id` int(11) NOT NULL,
                              `approved` int(2) NOT NULL,
                              `time` int(11) NOT NULL,
                              `user` int(11) NOT NULL,
                              PRIMARY KEY  (`id`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
                        $db->createCommand($sql)->execute();


                        $this->redirect('index');
                    }
                    else $this->render(Yum::module('store')->installrenderUrl);
                }
                else
                {
                    if(Yii::app()->db->getSchema()->getTable('store'))
                        $this->render(Yum::module('store')->installrenderUrl,array('message'=>'Store table is already installed. Please remove it manually to continue'));
                    else
                        $this->render(Yum::module('store')->installrenderUrl,array('message'=>''));
                }
            }
            else throw new CException('Yii User management module is not in Debug Mode');

            }
            else
            {
                $this->render(Yum::module('store')->installUrl,array('message'=>'Table store not instaled, remove them'));
            }
        }
        else
            $this->render('/');
    }

}