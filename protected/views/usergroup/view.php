<?php
//Yum::register('css/yum.css');

$this->breadcrumbs=array(
    'Usergroups'=>array('index'),
    $model->title,
);
 ?>

<h3> <?php echo $model->title;  ?> </h3>

<p><h5>Description:</h5><div style="margin-left: 40px;"><?php echo $model->description; ?></div></p>

<p><h5>Status:</h5>
	<div style="margin-left: 40px;"><?php if($model->completed == 0) {
			echo '<b>Finished</b>';
		} else if($model->completed == 1) {
			echo '<b>Active</b>';
		} else if($model->completed == 2) {
			echo '<b>Paused</b>';
		} else {
			echo '<b>Unknown</b>';
		};
	?></div>
</p>

<?php if(isset($model->image) && $model->image>0) { ?>
<div class="row">
    <?php
    $image_model=Files::model()->findByPk($model->image);
    if($image_model)
    {
        if(file_exists(Yii::app()->basePath."/../files/".$image_model->image))
        {
            echo "<p><h5>Image:</h5><div style='margin-left: 40px;'><img src='/files/".$image_model->image."'/></div></p>";
        }
    }
    ?>
</div>
<?php } ?>



<?php



//if($model->owner)
//	printf('%s: %s',
//			Yum::t('user_create'),
//			CHtml::link($model->user_create->username, array(
//					'//profile/profile/view', 'id' => $model->pm)));

printf('<h4> %s </h4>', 'Participants');

$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$model->getParticipantDataProvider(),
    'itemView'=>'_participant',
));

?>

 <div style="clear: both;"> </div> 
<div style="display:none;">
<?php
printf('<h3> %s </h3>', 'Messages');

$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$model->getMessageDataProvider(),
    'itemView'=>'_message', 
)); 

?>

<?php echo CHtml::link('Write a message', '', array(
			'onClick' => "$('#usergroup_message').toggle(500)")); ?>

<div style="display:none;" id="usergroup_message">
<h3> <?php echo 'Write a message'; ?> </h3>
<?php $this->renderPartial('_message_form', array('group_id' => $model->id)); ?>
</div>
</div>

<div style="clear: both;"> </div>



