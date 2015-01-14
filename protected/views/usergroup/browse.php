<?php
$this->breadcrumbs=array(
	'Groups',
	'Browse');

?>
<h1> <?php echo 'Browse user groups'; ?> </h1>

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

<div class="search-form">
        <div class="row">
                <?php echo $form->label($model,'title'); ?>
                <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        </div>
        <div class="row buttons">
                <?php echo CHtml::submitButton('app', 'Search'); ?>
        </div>

<?php $this->endWidget(); ?>

</div>

<?php
 $this->widget('zii.widgets.CListView', array(
	'id'=>'usergroup-grid',
	'dataProvider'=>$model->search(),
	'itemView' => '_view',
	)); 
?>
