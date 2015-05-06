<?php
/* @var $this FriendshipController */
/* @var $model Friendship */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'friendship-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'inviter_id'); ?>
		<?php echo $form->textField($model,'inviter_id'); ?>
		<?php echo $form->error($model,'inviter_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'friend_id'); ?>
		<?php echo $form->textField($model,'friend_id'); ?>
		<?php echo $form->error($model,'friend_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'acknowledgetime'); ?>
		<?php echo $form->textField($model,'acknowledgetime'); ?>
		<?php echo $form->error($model,'acknowledgetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requesttime'); ?>
		<?php echo $form->textField($model,'requesttime'); ?>
		<?php echo $form->error($model,'requesttime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updatetime'); ?>
		<?php echo $form->textField($model,'updatetime'); ?>
		<?php echo $form->error($model,'updatetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textField($model,'message',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->