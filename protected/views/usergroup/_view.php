<div class="view">

<h3> <?php echo CHtml::encode($data->title); ?> </h3> 
	<b><?php echo CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
<?php if(isset($data->owner))
	echo CHtml::encode($data->owner->username); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode(substr($data->description, 0, 200)) . '... '; ?>

	<br />
	<b><?php echo 'Participant count'; ?> : </b>
	<?php echo count($data->participants); ?>

	<br />
	<b><?php echo 'Message count'; ?> : </b>
	<?php echo $data->messagesCount; ?>

	<br />
	<br />

	<?php echo CHtml::link('View Details', array(
					'//usergroup/view', 'id' => $data->id)); ?>
	<?php 
	if(is_array($data->participants) &&
			in_array(Yii::app()->user->id, $data->participants))
	echo CHtml::link('Leave group', array(
				'//usergroup/leave', 'id' => $data->id));
	else
	echo CHtml::link('Join group', array(
				'//usergroup/join', 'id' => $data->id)); ?>

	</div>
