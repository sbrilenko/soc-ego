<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'activationKey'); ?>
		<?php echo $form->textField($model,'activationKey',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'createtime'); ?>
		<?php echo $form->textField($model,'createtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lastvisit'); ?>
		<?php echo $form->textField($model,'lastvisit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lastaction'); ?>
		<?php echo $form->textField($model,'lastaction'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'failedloginattempts'); ?>
		<?php echo $form->textField($model,'failedloginattempts'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'superuser'); ?>
		<?php echo $form->textField($model,'superuser'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'avatar'); ?>
		<?php //echo $form->textField($model,'avatar',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'notifyType'); ?>
		<?php //echo $form->textField($model,'notifyType',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'day_count'); ?>
		<?php echo $form->textField($model,'day_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'points'); ?>
		<?php echo $form->textField($model,'points',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'was_flag'); ?>
		<?php echo $form->textField($model,'was_flag'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'work_count'); ?>
		<?php echo $form->textField($model,'work_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'job_type'); ?>
		<?php echo $form->textField($model,'job_type',array('size'=>60,'maxlength'=>512)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'job_title'); ?>
		<?php echo $form->textField($model,'job_title',array('size'=>60,'maxlength'=>512)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'level'); ?>
		<?php echo $form->textField($model,'level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_month'); ?>
		<?php echo $form->textField($model,'start_month',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->