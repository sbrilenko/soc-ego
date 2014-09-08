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
