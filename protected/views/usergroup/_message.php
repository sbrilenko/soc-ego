<h3> <?php echo $data->title; ?> </h3>

<p> <?php echo $data->message; ?> </p>

<?php echo CHtml::link('Answer', '', array(
			'onClick' => "$('#usergroup_answer_".$data->id."').toggle(500)")); ?>

<div style="display:none;" id="usergroup_answer_<?php echo $data->id; ?>">
<h3> <?php echo 'Answer to this message'; ?> </h3>
<?php
$this->renderPartial('_message_form', array(
			'title' => 'Re: ' . ' ' . $data->title,
			'group_id' => $data->group_id));
?>

</div>

<hr />
