<?php

class GamificationManagerController extends Controller
{
    public $layout='//layouts/admin';
	public function actionIndex()
	{
        if(Yii::app()->user->id)
        {
            $messages="";
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
                $this->render("/gamificationmanager/index",array('message'=>$messages,'model'=>$model));
            }
            else $this->redirect("/");
        }
        else $this->redirect('/');

	}
    /*delete*/
    public function actionDelete($id=null)
    {
        if(Yii::app()->user->id)
        {
            if(!is_null($id) && $id>0)
            {
                $model=GamificationfactorsPositions::model()->findByPk($id);
                if($model)
                {
                    $gamificationfactors=Gamificationfactors::model()->findAllByAttributes(array("gamificationfactors_positions_id"=>$model->id));
                    if($gamificationfactors)
                    {
                        foreach($gamificationfactors as $factor)
                        {
                            $factor->delete();
                        }
                    }
                    $model->delete();
                }
            }
            $this->redirect('/gamificationmanager/index');
        }
        else
            $this->redirect('/');
    }
    /*update */
    public function actionUpdate()
    {
        $messages="";

        if(Yii::app()->user->id)
        {
            if(Yii::app()->request->isPostRequest)
            {
                $gamifi_positions=GamificationfactorsPositions::model()->findAll();
                if($gamifi_positions)
                {
                    if(isset($_POST['yt1'])) unset($_POST['yt1']);
                    foreach($_POST as $val)
                    {
                        if(isset($val['id']) && $val['id']>0 && isset($val['position']) && !empty($val['position']))
                        {
                            $posrecord=GamificationfactorsPositions::model()->findByPk($val['id']);
                            if($posrecord)
                            {
                                $posrecord->position=$val['position'];
                                $posrecord->base_salary=$val['base_salary'];
                                $posrecord->time=strtotime(date("Y-m-d H:i:s"));
                                $posrecord->user=Yii::app()->user->id;
                                $posrecord->save();
                            }
                        }
                    }

                    $gamifi_positions=GamificationfactorsPositions::model()->findAll();

                    if($gamifi_positions)
                    {
                        foreach($gamifi_positions as $posit)
                        {
                            $posit->position=str_replace(" ","_",$posit->position);
                            if(isset($_POST[$posit->position]) && array_key_exists($posit->position, $_POST))
                            {
                                //update
                                $post=$_POST[$posit->position];

                                if(isset($post['id']) && $post['id']>0)
                                {
                                    $posrecord=GamificationfactorsPositions::model()->findByPk($post['id']);
                                    if($posrecord)
                                    {
                                        /*update position*/
//                                        $posrecord->position=trim($post['position']);
//                                        $posrecord->base_salary=trim($post['base_salary']);
//                                        $posrecord->time=strtotime(date("Y-m-d H:i:s"));
//                                        $posrecord->user=Yii::app()->user->id;
//                                        $posrecord->save();

                                        $array_pre_var=array('trainer_low','trainer_normal','trainer_high',
                                            'junior_low','junior_normal','junior_high',
                                            'junior_middle_low','junior_middle_normal','junior_middle_high',
                                            'middle_low','middle_normal','middle_high',
                                            'middle_senior_low','middle_senior_normal','middle_senior_high',
                                            'senior_low','senior_normal','senior_high',
                                            'senior_lead_low','senior_lead_normal','senior_lead_high',
                                            'lead_low','lead_normal','lead_high',
                                            'tech_officer_low','tech_officer_normal','tech_officer_high');
                                        /*update or save the factors for this position*/
                                        for($i=0;$i<count($array_pre_var);$i++)
                                        {
                                            if(isset($post[$array_pre_var[$i]."_id"]))
                                            {
                                                $gamiffactors_for_this_pos=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$posrecord->id,"gamificationmanager_id"=>$post[$array_pre_var[$i]."_id"]));
                                                $new_gam_fact_trainer_low=$gamiffactors_for_this_pos?$gamiffactors_for_this_pos:new Gamificationfactors();

                                                $new_gam_fact_trainer_low->gamificationfactors_positions_id=$posrecord->id;
                                                $new_gam_fact_trainer_low->gamificationmanager_id=$post[$array_pre_var[$i]."_id"];
                                                $new_gam_fact_trainer_low->seniority_factor=isset($post[$array_pre_var[$i]."_seniority_factor"]) && !empty($post[$array_pre_var[$i].'_seniority_factor'])?$post[$array_pre_var[$i].'_seniority_factor']:0;
                                                $new_gam_fact_trainer_low->experience_factor=isset($post[$array_pre_var[$i]."_experience_factor"]) && !empty($post[$array_pre_var[$i]."_experience_factor"])?$post[$array_pre_var[$i]."_experience_factor"]:0;
                                                $new_gam_fact_trainer_low->time=strtotime(date("Y-m-d H:i:s"));
                                                $new_gam_fact_trainer_low->user=Yii::app()->user->id;
                                                $new_gam_fact_trainer_low->save();

                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }
                }
            }
            $this->redirect('/gamificationmanager/index');
        }
    }
    /*addposition*/
    public function actionAddposition()
    {
        $messages="";
        if(Yii::app()->user->id)
        {
            if(Yii::app()->request->isPostRequest && !empty($_POST['new_position']))
            {
                $new_position=trim($_POST['new_position']);
                /*match check*/
                $find_position=GamificationfactorsPositions::model()->findAllByattributes(array("position"=>$new_position));
                if($find_position)
                {
                    $messages="Position is already exists";
                }
                else
                {
                    $GamificationfactorsPositions=new GamificationfactorsPositions();
                    $GamificationfactorsPositions->position=$new_position;
                    $GamificationfactorsPositions->base_salary=0;
                    $GamificationfactorsPositions->time=strtotime(date("Y-m-d H:i:s"));
                    $GamificationfactorsPositions->user=Yii::app()->user->id;
                    $GamificationfactorsPositions->save();
                }
            }
            else
            {
                $model=GamificationManager::model()->findAll();
                $this->redirect("/gamificationmanager/index#tabs-add-new-position",array('message'=>"All field is required",'model'=>$model));
            }
        }
        $model=GamificationManager::model()->findAll();
        $this->redirect('/gamificationmanager/index',array('message'=>$messages,'model'=>$model));

    }

}
