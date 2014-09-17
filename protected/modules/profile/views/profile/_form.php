<?php
if(Yum::module()->rtepath != false)
	Yii::app()->clientScript-> registerScriptFile(Yum::module()->rtepath);
if(Yum::module()->rteadapter != false)
	Yii::app()->clientScript-> registerScriptFile(Yum::module()->rteadapter);

if($profile)
{
    $locations_array=array();
    $locations=LocationManager::model()->findAllByAttributes(array());
    if($locations)
        foreach($locations as $loc)
            $locations_array[$loc->id]=$loc->locationname;

    foreach(YumProfile::getProfileFields() as $field) {
        echo CHtml::openTag('div',array());
        if($field=="user_location")
        {
            echo $form->labelEx($profile, 'user location');
            echo $form->dropDownList($profile, $field,$locations_array);
            echo $form->error($profile,$field);
        }
        elseif($field=="avatar")
        {
            echo $form->labelEx($profile, 'avatar');
            echo $form->fileField($profile, $field);
            echo $form->error($profile,$field);
            if(!is_null($profile->avatar) && $profile->avatar>0)
            {
                $avatar=Files::model()->findByPk($profile->avatar);
                if($avatar && file_exists(Yii::app()->basePath."/../files/".$avatar->image))
                {
                    echo "<div><img src='/files/".$avatar->image."'/></div>";
                }
                else
                    echo "<div><img src='/default.png'/></div>";
            }
            else echo "<div><img src='/default.png'/></div>";
        }
        else
        {
            echo $form->labelEx($profile, $field);
            if($field=="sex")
                echo $form->dropDownList($profile, $field ,array("0"=>"Female","1"=>"Male"),array('options' => array('1'=>array('selected'=>true))));
            else echo $form->textField($profile, $field);
            echo $form->error($profile,$field);
        }
        echo CHtml::closeTag('div');
    }
}

?>
