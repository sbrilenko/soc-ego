<?php
/* @var $this FriendshipController */
/* @var $model Friendship */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inviter_id'); ?>
		<?php echo $form->textField($model,'inviter_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'friend_id'); ?>
		<?php echo $form->textField($model,'friend_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acknowledgetime'); ?>
		<?php echo $form->textField($model,'acknowledgetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requesttime'); ?>
		<?php echo $form->textField($model,'requesttime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updatetime'); ?>
		<?php echo $form->textField($model,'updatetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'message'); ?>
		<?php echo $form->textField($model,'message',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->