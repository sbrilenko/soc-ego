<?php
class BadgesController extends Controller
{
    public $layout='//layouts/admin';
    /*badgeusermanager*/
    public function actionbadgeusermanager()
    {
        if(Yii::app()->user->id)
        {
            if(Yii::app()->request->isPostRequest && isset($_POST['BadgeUser']))
            {
                if(isset($_POST['badgeusersubmit1'])) // add
                {
                    $fid_user=BadgeUser::model()->findByAttributes(array('user_id'=>$_POST['BadgeUser']['user_id'],'badge_id'=>$_POST['BadgeUser']['badge_id']));
                    if($fid_user)
                    {
                        $fid_user->count_active=$fid_user->count_active+1;
                        $fid_user->count_all=$fid_user->count_all+1;
                        $user_points_add=User::model()->findByPk($_POST['BadgeUser']['user_id']);
                        if($user_points_add)
                        {
                            /*find badge cost*/
                            $badge_cost=Badges::model()->findByPk($_POST['BadgeUser']['badge_id']);
                            if($badge_cost)
                            {
                                $user_points_add->points=(float)($user_points_add->points+$badge_cost->cost);
                                if($user_points_add->save())
                                {
                                    $fid_user->save();
                                }
                                else die(var_dump($user_points_add->getErrors()));
                            }
                        }
                    }
                    else
                    {
                        $fid_user=new BadgeUser();
                        $fid_user->user_id=$_POST['BadgeUser']['user_id'];
                        $fid_user->badge_id=$_POST['BadgeUser']['badge_id'];
                        $fid_user->count_active=1;
                        $fid_user->count_all=1;
                        $user_points_add=User::model()->findByPk($_POST['BadgeUser']['user_id']);
                        if($user_points_add)
                        {
                            /*find badge cost*/
                            $badge_cost=Badges::model()->findByPk($_POST['BadgeUser']['badge_id']);
                            if($badge_cost)
                            {
                                $user_points_add->points=(float)($user_points_add->points+$badge_cost->cost);
                                if($user_points_add->save())
                                {
                                    $fid_user->save();
                                }
                                else die(var_dump($user_points_add->getErrors()));
                            }
                        }


                    }
                }
                elseif(isset($_POST['badgeusersubmit2'])) //remove
                {
                    $fid_user=BadgeUser::model()->findByAttributes(array('user_id'=>$_POST['BadgeUser']['user_id'],'badge_id'=>$_POST['BadgeUser']['badge_id']));
                    if($fid_user && $fid_user->count_active>0)
                    {
                        $fid_user->count_active=$fid_user->count_active-1;
                        $fid_user->save();
                    }
                }
                $this->redirect('index');
            }
            else $this->redirect('index');
        }
        else $this->redirect('/');
    }
	public function actionIndex()
	{
        if(Yii::app()->user->id)
        {
            if(Yii::app()->db->getSchema()->getTable('badges') && Yii::app()->db->getSchema()->getTable('badge_user'))
                $this->render('index');
            else
                $this->redirect("/badges/index");
        }
        else
		$this->redirect('/');
	}
    /*create*/
    public function actionCreate()
    {
        if(Yii::app()->user->id)
        {
            if(Yii::app()->request->isPostRequest && isset($_POST['Badges']))
            {
                $badge=new Badges();
                $badge->attributes=$_POST['Badges'];
                if(isset($_FILES['Badges']) && !empty($_FILES['Badges']['name']['image']))
                {
                    $file_ret=Files::model()->create($_FILES['Badges'],'image',$title='test',Badges::model()->tableName());
                    if(is_array($file_ret))
                    {
                        $this->render('create',array('message'=>$file_ret[0]));
                    }
                    else
                    {
                        $badge->image=$file_ret;
                        if($badge->save())
                        {
                            $this->redirect('index');
                        }
                        else
                        {
                            $this->render('create',array('message'=>'badges model not saved! Please ask your specialist'));
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
        if(Yii::app()->user->id)
        {
            if(Yii::app()->request->isPostRequest)
            {
                $local=Badges::model()->findByPk($_POST['Badges']['id']);
                if($local)
                {
                    if(isset($_FILES['Badges']) && !empty($_FILES['Badges']['name']['image']))
                    {
                        $file_ret=Files::model()->create($_FILES['Badges'],'image',$title='test',Badges::model()->tableName(),$local->image);
                        if(is_array($file_ret))
                        {
                            $this->render('update'.$_POST['Badges']['id'],array('message'=>$file_ret[0]));
                            exit();
                        }
                        else
                        {
                            $local->attributes=$_POST['Badges'];
                            $local->image=$file_ret;
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
                        $local->attributes=$_POST['Badges'];
                        $local->image=$image;
                        $local->save();
                        $this->render('index',array('message'=>'please put the image'));
                    }
                    $local->attributes=$_POST['Badges'];
                    $local->save();
                }
                $this->redirect('index');
            }
            else
                if(!empty($_GET['id']) && $_GET['id']>0)
                {
                    $local=Badges::model()->findByPk($_GET['id']);
                    if($local) $this->render('update',array('badges'=>$local));
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
        if(Yii::app()->user->id)
        {
            $message='';
            if(!is_null($_GET['id']) && $_GET['id']>0)
            {
                $model=Badges::model()->findByPk($_GET['id']);
                if($model)
                {
                    //find all users who have this badges and deleted
                    $badges_users=BadgeUser::model()->findAllByAttributes(array('badge_id'=>$model->id));
                    if($badges_users)
                    {
                        foreach($badges_users as $bage_user)
                        {
                            $bage_user->delete();
                        }
                    }
                    Files::model()->delete($model->image);
                    //and delete files
                    $model->delete();
                }
            }
            else
                $message='Wrong link';
            $model=Badges::model()->findAll();
            $this->redirect('/badges/index',array('message'=>$message,'model'=>$model));
        }
        else
            $this->redirect('/');

    }

}