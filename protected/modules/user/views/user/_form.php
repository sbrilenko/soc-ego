<?php
$form = $this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
));
?>

<?php
// If errors occured, display errors for all involved models
$models = array($user, $passwordform);
if(isset($profile) && $profile !== false)
	$models[] = $profile;
	$hasErrors = false;
	foreach($models as $m)
if($m->hasErrors())
	$hasErrors = true;
	if($hasErrors) {
		echo '<div class="alert alert-error">';
		echo CHtml::errorSummary($models);
		echo '</div>';
	}
	?>

<?php echo Yum::requiredFieldNote(); ?>
<div class="row">
<div class="span6">

<?php echo $form->labelEx($user, 'username');
echo $form->textField($user, 'username');
echo $form->error($user, 'username'); ?>

<?php echo $form->labelEx($user,'status');
echo $form->dropDownList($user,'status',YumUser::itemAlias('UserStatus'));
echo $form->error($user,'status'); ?>


<?php echo $form->labelEx($user, 'superuser');
echo $form->dropDownList($user, 'superuser',YumUser::itemAlias('AdminStatus'));
echo $form->error($user, 'superuser'); ?>


<p> Leave password <em> empty </em> to
<?php echo $user->isNewRecord
? 'generate a random Password'
: 'keep it <em> unchanged </em>'; ?> </p>
<?php $this->renderPartial('/user/passwordfields', array(
			'form'=>$passwordform)); ?>

<?php if(Yum::hasModule('role')) {
	Yii::import('role.models.*');
?>

<label> <?php echo Yum::t('User belongs to these roles'); ?> </label>

<?php $this->widget('user.components.select2.ESelect2', array(
				'model' => $user,
				'attribute' => 'roles',
				'htmlOptions' => array(
					'multiple' => 'multiple',
					'style' => 'width:220px;'),
				'data' => CHtml::listData(YumRole::model()->findAll(), 'id', 'title'),
				)); ?>
<?php } ?>

    <?php
    echo $form->labelEx($user, 'day_count');
    if($user->day_count==0) $day_count_value='';
    else $day_count_value=date("m/d/Y",$user->day_count);
    echo $form->textField($user, 'day_count',array('value'=>$day_count_value,'readonly'=>'readonly','data-provide'=>'datepicker','class'=>'day-count'));
    echo $form->error($user, 'day_count'); ?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
    <script type="text/javascript">
        $(document).ready(function()
        {
            $(".day-count").datepicker({
                format: "dd MM yyyy",
                autoclose: true,
                todayBtn: true,
                pickerPosition: "bottom-left"
            });
            $('.was-flag').change(function()
            {
                if($(this).val()==1) {
                    $(".work-count").datepicker('option',{disabled: false});
                    $(".work-count").datepicker({
                        format: "dd MM yyyy",
                        autoclose: true,
                        todayBtn: true,
                        pickerPosition: "bottom-left"
                    });
                }
                else $(".work-count").val('').datepicker( "option", { disabled: true } );
            })
        })
    </script>
    <?php echo $form->labelEx($user, 'was_flag');
    echo $form->dropDownList($user, 'was_flag',YumUser::itemAlias('AlreadyWork'),array('class'=>'was-flag'));
    echo $form->error($user, 'was_flag'); ?>

    <?php
    echo $form->labelEx($user, 'work_count');
    if($user->work_count==0) $day_work_count='';
    else $day_work_count=date("m/d/Y",$user->work_count);
    echo $form->textField($user, 'work_count',array('value'=>$day_work_count,'readonly'=>'readonly','class'=>'work-count'));
    echo $form->error($user, 'work_count'); ?>

    <?php echo $form->labelEx($user, 'job_type');
    echo $form->dropDownList($user, 'job_type',YumUser::itemAlias('JobType'),array('class'=>'job-type'));
    echo $form->error($user, 'job_type'); ?>

    <?php echo $form->labelEx($user, 'job_title');
    echo $form->dropDownList($user, 'job_title',YumUser::itemAlias('JobTitle'),array('class'=>'job-title'));
    echo $form->error($user, 'job_title'); ?>

    <?php echo $form->labelEx($user, 'level');
    echo $form->dropDownList($user, 'level',YumUser::itemAlias('Level'),array('class'=>'level'));
    echo $form->error($user, 'level'); ?>

    <?php echo $form->labelEx($user, 'start_month');
    echo $form->dropDownList($user, 'start_month',YumUser::itemAlias('StartMonth'),array('class'=>'level'));
    echo $form->error($user, 'start_month'); ?>
</div>

<div class="span6">
<?php
if(Yum::hasModule('profile'))
$this->renderPartial(Yum::module('profile')->profileFormView, array(
  'form' => $form,
  'profile' => $profile))
?>
</div>



<?php echo CHtml::submitButton($user->isNewRecord
			? Yum::t('Create')
			: Yum::t('Save')); ?>

</div>


<?php $this->endWidget(); ?>

