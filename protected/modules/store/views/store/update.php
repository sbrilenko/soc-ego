<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'badges-form',
    'action'=>Yum::module('store')->updateUrl,
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
));
?>
<div class="row">
    <div class="span6">
        <div>
        <?php
            echo $form->hiddenField($store_item, 'id');
        ?>
        <?php echo $form->labelEx($store_item, 'title');
        echo $form->textField($store_item, 'title');
        echo $form->error($store_item, 'title'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($store_item, 'price');
        echo $form->textField($store_item, 'price');
        echo $form->error($store_item, 'price'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($store_item, 'image');
        echo $form->fileField($store_item, 'image');
        echo $form->error($store_item, 'image');
        if($store_item->image>0)
        {
            $image=Files::model()->findByPk($store_item->image);
            if($image)
            {
                if(file_exists(Yii::app()->basePath."/../files/".$image->image))
                {
                    echo "<div><img src='/files/".$image->image."'/></div>";
                }
            }
            else
            {
                echo "Image not found";
            }
        }
        ?>
        </div>
        <div>
        <?php echo $form->labelEx($store_item, 'description');
        echo $form->textArea($store_item, 'description');
        echo $form->error($store_item, 'description'); ?>
        </div>

        <div>
        <?php echo $form->labelEx($store_item, 'stock');
        echo $form->dropDownList($store_item, 'stock',array("0"=>"In stock","1"=>"No in stock"));
        echo $form->error($store_item, 'stock'); ?>
        </div>

        <div>
        <?php
        echo $form->labelEx($store_item, 'count');
        echo $form->textField($store_item, 'count');
        echo $form->error($store_item, 'count'); ?>
        </div>

        <div>
        <?php echo $form->labelEx($store_item, 'hide');
        echo $form->dropDownList($store_item, 'hide',array("1"=>"Hide","0"=>"Show"));
        echo $form->error($store_item, 'hide'); ?>
        </div>
    </div>
    <?php echo CHtml::submitButton($store_item->isNewRecord
        ? Yum::t('Create')
        : Yum::t('Save')); ?>

</div>


<?php $this->endWidget(); ?>

