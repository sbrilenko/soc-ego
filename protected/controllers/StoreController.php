<?php
class StoreController extends Controller
{
    public $layout='//layouts/admin';
    public function actionIndex()
	{
        if(Yii::app()->user->id)
        {
            if(Yii::app()->db->getSchema()->getTable('store'))
                $this->render('index');
            else
                $this->redirect('/store/index');
        }
        else
		$this->redirect('/');
	}
    /*create*/
    public function actionCreate()
    {
        if(Yii::app()->user->id)
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
                            $this->redirect('/store/index');
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
                $this->redirect('/store/index');
            }
            else
                $this->render('/store/create');

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
                    $local=Store::model()->findByPk($_POST['Store']['id']);
                    if($local)
                    {
                        if(isset($_FILES['Store']) && !empty($_FILES['Store']['name']['image']))
                        {
                            $file_ret=Files::model()->create($_FILES['Store'],'image',$title='test',Store::model()->tableName(),$local->image);
                            if(is_array($file_ret))
                            {
                                $this->render('/store/update',array("store_item"=>$local,'message'=>$file_ret[0]));
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
                                    $this->redirect('/store/index');
                                    exit();
                                }
                                else
                                {
                                    $this->render('/store/index',array('message'=>'Store model not saved! Please ask your specialist'));
                                    exit();
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
                            $this->render('/store/index',array('message'=>'please put the image'));
                            exit();
                        }
                        $local->attributes=$_POST['Store'];
                        $local->time=strtotime(date("Y-m-d H:i:s"));
                        $local->user=Yii::app()->user->id;
                        $local->save();
                    }
                    else
                    {
                        $this->redirect('/store/index');
                        exit();
                    }
                }
                else
                if(!empty($id) && $id>0)
                {
                    $local=Store::model()->findByPk($id);
                    if($local)
                    {
                        $this->render('/store/update',array('store_item'=>$local));
                        exit();
                    }
                    else
                    {
                        $this->redirect('/store/index');
                        exit();
                    }
                }
            else
            {
                $this->redirect('/store/index');
                exit();
            }
        }
        else
        {
            $this->redirect('/');
            exit();
        }
    }
    /*delete*/
    public function actionDelete($id=null)
    {
        if(Yii::app()->user->id)
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
            $this->redirect('/store/index',array('message'=>$message,'model'=>$model));
        }
        else
            $this->redirect('/');

    }

}