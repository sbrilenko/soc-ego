<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'badges-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
));
?>
<?php $badges=new Badges(); ?>
<div class="row">
    <div class="span6">
        <div>
        <?php echo $form->labelEx($badges, 'title');
        echo $form->textField($badges, 'title');
        echo $form->error($badges, 'title'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($badges, 'cost');
        echo $form->textField($badges, 'cost');
        echo $form->error($badges, 'cost'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($badges, 'image');
        echo $form->fileField($badges, 'image');
        echo $form->error($badges, 'image'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($badges, 'description');
        echo $form->textArea($badges, 'description');
        echo $form->error($badges, 'description'); ?>
        </div>
    </div>
    <?php echo CHtml::submitButton($badges->isNewRecord
        ? Yum::t('Create')
        : Yum::t('Save')); ?>

</div>


<?php $this->endWidget(); ?>

