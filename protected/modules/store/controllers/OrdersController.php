<?php
class OrdersController extends Controller
{
    public function actionIndex()
	{
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            if(Yii::app()->db->getSchema()->getTable('orders_from_store'))
                $this->render('orders');
        }
        else
		$this->redirect('/');
	}

    /*approved or not*/
    public function actionOrders()
    {
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


}