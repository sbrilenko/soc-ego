<div class="form">
<p class="note">
<?php echo Yum::t('Fields with <span class="required">*</span> are required.');?>
</p>
<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'usergroup-form',
    'enableAjaxValidation'=>false,
//    'enableClientValidation'=>true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); 
	echo $form->errorSummary($model);
?>
<fieldset class="badge-add-form">
    <legend>Add new group</legend>
<div class="row">
<?php echo $form->labelEx($model,'title'); ?>
<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255,'class'=>'width-80')); ?>
<?php echo $form->error($model,'title'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'image'); ?>
    <?php echo $form->fileField($model,'image'); ?>
    <?php echo $form->error($model,'image'); ?>
</div>

<?php if(isset($model->image) && $model->image>0) { ?>
<div class="row">
    <?php
    $image_model=Files::model()->findByPk($model->image);
    if($image_model)
    {
        if(file_exists(Yii::app()->basePath."/../files/".$image_model->image))
        {
            echo "<div><img src='/files/".$image_model->image."'/></div>";
        }
    }
    ?>
</div>
<?php } ?>

<div class="row">
    <?php echo $form->labelEx($model,'pm'); ?>
    <?php
    $users_pm=YumUser::model()->findAllByAttributes(array("job_type"=>"PM"));
    $users_pm_array=array();
    if($users_pm)
    {
        foreach($users_pm as $user)
        {
            $user_profile=YumProfile::model()->findByAttributes(array("user_id"=>$user->id));
            $users_pm_array[$user->id]=$user_profile->firstname." ".$user_profile->lastname;
        }
    }
    echo $form->dropDownList($model, 'pm',$users_pm_array);
    if(count($users_pm)==0)
    {
        echo "<a href='/user/user/create'>Add user</a>";
    }
    ?>
    <?php echo $form->error($model,'pm'); ?>

</div>

<div class="row">
    <?php echo $form->labelEx($model,'participants'); ?>
    <?php
    $users=YumUser::model()->findAll();
    $users_array=array();
    if(!empty($model->participants))
    $participants_explode=explode(",",$model->participants);
    if($users)
    {
        echo "<table>";
        foreach($users as $user)
        {
            if($user->job_type!=="PM")
            {
                echo "<tr>";
                $user_profile=YumProfile::model()->findByAttributes(array("user_id"=>$user->id));
                if(!empty($model->participants) && in_array($user->id,$participants_explode))
                {
                    echo "<td>",$form->checkBox($model,'participants['.$user->id.']',  array('checked'=>'checked')),"</td>";
                    echo "<td>",$form->labelEx($model,$user_profile->firstname." ".$user_profile->lastname),"</td>";
                }
                else
                {
                    echo "<td>",$form->checkBox($model,'participants['.$user->id.']'),"</td>";
                    echo "<td>",$form->labelEx($model,$user_profile->firstname." ".$user_profile->lastname),"</td>";
                }
                echo "</tr>";
            }
        }
        echo "</table>";
    }
    ?>
    <?php echo $form->error($model,'participants'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'description'); ?>
<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50,'class'=>'width-80 textarea-min-height')); ?>
<?php echo $form->error($model,'description'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'completed'); ?>
    <?php  echo $form->dropDownList($model, 'completed',array("0"=>"No","1"=>"Yes")); ?>
    <?php echo $form->error($model,'completed'); ?>
</div>
</fieldset>
<?php
//echo CHtml::Button(Yum::t('Cancel'), array(
//			'submit' => array('groups/index')));
echo "<div class='button-center'>";
echo CHtml::submitButton($model->isNewRecord ? Yum::t('Create') : Yum::t('Save'));
echo "</div>";
$this->endWidget(); ?>
</div> <!-- form -->
