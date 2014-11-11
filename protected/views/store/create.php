<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'store-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
));
?>
<fieldset class="badge-add-form">
    <legend>Add store item</legend>
<?php $store_item=new Store(); ?>
<div class="row">
    <div class="span6">
        <div>
        <?php echo $form->labelEx($store_item, 'title');
        echo $form->textField($store_item, 'title',array('class'=>'width-80'));
        echo $form->error($store_item, 'title'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($store_item, 'price');
        echo $form->textField($store_item, 'price',array('class'=>'width-80'));
        echo $form->error($store_item, 'price'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($store_item, 'image');
        echo $form->fileField($store_item, 'image');
        echo $form->error($store_item, 'image'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($store_item, 'description');
        echo $form->textArea($store_item, 'description',array('class'=>'width-80 textarea-min-height'));
        echo $form->error($store_item, 'description'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($store_item, 'stock');
        echo $form->dropDownList($store_item, 'stock',array("0"=>"In stock","1"=>"No in stock"));
        echo $form->error($store_item, 'stock'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($store_item, 'count');
        echo $form->textField($store_item, 'count');
        echo $form->error($store_item, 'count'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($store_item, 'hide');
        echo $form->dropDownList($store_item, 'hide',array("1"=>"Hide","0"=>"Show"));
        echo $form->error($store_item, 'hide'); ?>
        </div>
    </div>

</div>

</fieldset>
<div class="button-center">
<?php echo CHtml::submitButton($store_item->isNewRecord
    ? 'Create'
    : 'Save'); ?>
</div>
<?php $this->endWidget(); ?>

