<div class="form">
<p class="note">
<?php echo 'Fields with <span class="required">*</span> are required.';?>
</p>
<?php if(isset($message) && !empty($message)) {?>
    <div style="color: red"><?php echo $message;?></div>
<?php } ?>

<?php //foreach($errors as $error_key => $error_messages): ?>
<?php //foreach($error_messages as $error_message): ?>
<!--<div style="color: red">--><?php //echo 'Field: ' . $error_key . ". Error: " . $error_message;?><!--</div>-->
<?php //endforeach; ?>
<?php //endforeach; ?>
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
<?php echo $form->hiddenField($model,'id'); ?>
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
    $users_pm=User::model()->findAllByAttributes(array("job_type"=>"PM"));
    $users_pm_array=array();
    if($users_pm)
    {
        foreach($users_pm as $user)
        {
            $user_profile=Profile::model()->findByAttributes(array("user_id"=>$user->id));
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
    <?php echo $form->labelEx($model,'company'); ?>
    <?php
    $users_company=Company::model()->findAll();
    $users_comapny_array=array();
    if($users_company)
    {
        foreach($users_company as $company)
        {
            $users_comapny_array[$company->id]=$company->title;
        }
    }
    echo $form->dropDownList($model, 'company',$users_comapny_array);
    if(count($users_comapny_array)==0)
    {
        echo "<a href='/company/create'>Add user</a>";
    }
    ?>
    <?php echo $form->error($model,'company'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'participants'); ?>
    <?php
    if(is_null($model->company))
    {
        if(Company::model()->findByAttributes(array(),array("order"=>"id ASC")))
            $model->company=Company::model()->findByAttributes(array(),array("order"=>"id ASC"))->id;
    }
    $users=User::model()->findAllByAttributes(array("status"=>1,"company_id"=>$model->company));
    $users_array=array();
    echo "<table class='participants-table'>";
    if($users)
    {
        foreach($users as $user)
        {
            if($user->job_type!=="PM")
            {
                echo "<tr>";
                $user_profile=Profile::model()->findByAttributes(array("user_id"=>$user->id));
                if(Participants::model()->findAllByAttributes(array("status"=>1,"group_id"=>$model->id,"user_id"=>$user->id)))
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
    }
    else echo "<tr><td>No users</td></tr>";
    echo "</table>";
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
    <?php  echo $form->dropDownList($model, 'completed',array("0"=>"Finished","1"=>"Active","2"=>"Paused")); ?>
    <?php echo $form->error($model,'completed'); ?>
</div>
</fieldset>
<?php
//echo CHtml::Button(::t('Cancel'), array(
//			'submit' => array('groups/index')));
echo "<div class='button-center'>";
echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
echo "</div>";
$this->endWidget(); ?>
</div> <!-- form -->
<script>
    $(document).ready(function()
    {
        $(document).on("change","select[name*=company]",function()
        {
            var arr=$(this).parents("form").serializeArray();
            $.ajax(
                {
                    url:"/AllUserByCompany",
                    type:"POST",
                    data:arr,
                    success:function(data, textStatus)
                    {
                        console.log(data)
                        data= $.parseJSON(data);
                        console.log(data)
                        if(data.error)
                        {
                            alert(data.message)
                        }
                        else
                        {
                            if(data.html!=="")
                            {
                                $('.participants-table').replaceWith(data.html)
                            }
                        }

                    }
                }
            )

        })
    })
</script>
