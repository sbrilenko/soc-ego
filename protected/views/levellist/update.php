<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'badges-form',
    'action'=>'/levellist/update',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
));
?>
<fieldset class="badge-add-form">
    <legend>Add new level</legend>
<div class="row">
    <div class="span6">
        <div>
        <?php
            echo $form->hiddenField($levellist, 'id');
        ?>
        <?php echo $form->labelEx($levellist, 'position');
        echo $form->textField($levellist, 'position',array("class"=>"width-80"));
        echo $form->error($levellist, 'position'); ?>
        </div>

        <div>
        <?php echo $form->labelEx($levellist, 'description');
        echo $form->textArea($levellist, 'description',array('class'=>'width-80 textarea-min-height'));
        echo $form->error($levellist, 'description'); ?>
        </div>
        <div>
            <?php echo $form->labelEx($levellist, 'priority');
            echo $form->textField($levellist, 'priority');
            echo $form->error($levellist, 'priority'); ?>
        </div>
    </div>

</div>
</fieldset>
<div class="button-center">
<?php echo CHtml::submitButton($levellist->isNewRecord
    ? 'Create'
    : 'Save'); ?>
</div>
<?php $this->endWidget(); ?>

