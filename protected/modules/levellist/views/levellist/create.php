<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'badges-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
));
?>
<?php $Levellist=new Levellist(); ?>
<div class="row">
    <div class="span6">
        <div>
        <?php echo $form->labelEx($Levellist, 'position');
        echo $form->textField($Levellist, 'position');
        echo $form->error($Levellist, 'position'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($Levellist, 'description');
        echo $form->textArea($Levellist, 'description');
        echo $form->error($Levellist, 'description'); ?>
        </div>
        <div>
            <?php echo $form->labelEx($Levellist, 'priority');
            echo $form->textField($Levellist, 'priority');
            echo $form->error($Levellist, 'priority'); ?>
        </div>
    </div>
    <?php echo CHtml::submitButton($Levellist->isNewRecord
        ? Yum::t('Create')
        : Yum::t('Save')); ?>

</div>


<?php $this->endWidget(); ?>

