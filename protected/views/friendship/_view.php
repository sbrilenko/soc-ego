<?php
/* @var $this FriendshipController */
/* @var $data Friendship */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inviter_id')); ?>:</b>
	<?php echo CHtml::encode($data->inviter_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('friend_id')); ?>:</b>
	<?php echo CHtml::encode($data->friend_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acknowledgetime')); ?>:</b>
	<?php echo CHtml::encode($data->acknowledgetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requesttime')); ?>:</b>
	<?php echo CHtml::encode($data->requesttime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updatetime')); ?>:</b>
	<?php echo CHtml::encode($data->updatetime); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	*/ ?>

</div>