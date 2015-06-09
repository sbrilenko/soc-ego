<?php
class JobtitleController extends Controller
{
	public function actionGetByParId()
	{
        $ret=json_encode(array('jobtitles'=>array()));
        if(Yii::app()->request->isPostRequest)
        {
            if(isset(Yii::app()->user->id))
            {
                $retarray=array();
                $user=new User();
                $user->attributes=$_POST['User'];
                $jobtitleByTitle=JobTitle::model()->jobTitleByTypeIdArray($user->job_type);
                if($jobtitleByTitle)
                {
                    foreach($jobtitleByTitle as $title)
                    {
                        $retarray[$title->id]=$title->job_title;
                    }
                }
                $ret=json_encode(array('jobtitles'=>$retarray));
            }
        }
        echo $ret;
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}