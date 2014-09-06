<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'badges-form',
    'action'=>Yum::module('levellist')->updateUrl,
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
));
?>
<div class="row">
    <div class="span6">
        <div>
        <?php
            echo $form->hiddenField($levellist, 'id');
        ?>
        <?php echo $form->labelEx($levellist, 'position');
        echo $form->textField($levellist, 'position');
        echo $form->error($levellist, 'position'); ?>
        </div>

        <div>
        <?php echo $form->labelEx($levellist, 'description');
        echo $form->textArea($levellist, 'description');
        echo $form->error($levellist, 'description'); ?>
        </div>
        <div>
            <?php echo $form->labelEx($levellist, 'priority');
            echo $form->textField($levellist, 'priority');
            echo $form->error($levellist, 'priority'); ?>
        </div>
    </div>
    <?php echo CHtml::submitButton($levellist->isNewRecord
        ? Yum::t('Create')
        : Yum::t('Save')); ?>

</div>


<?php $this->endWidget(); ?>

