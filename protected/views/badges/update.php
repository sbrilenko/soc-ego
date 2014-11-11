<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'badges-form',
    'action'=>"/badges/update",
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
));
?>
<fieldset class="badge-add-form">
    <legend>Update badge</legend>
<div class="row">
    <div class="span6">
        <div>
        <?php
            echo $form->hiddenField($badges, 'id');
        ?>
        <?php echo $form->labelEx($badges, 'title');
        echo $form->textField($badges, 'title',array('class'=>'width-80'));
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
        echo $form->error($badges, 'image');
        if($badges->image>0)
        {
            $image=Files::model()->findByPk($badges->image);
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
        <?php echo $form->labelEx($badges, 'description');
        echo $form->textArea($badges, 'description',array('class'=>'width-80 textarea-min-height'));
        echo $form->error($badges, 'description'); ?>
        </div>
    </div>

</div>
</fieldset>
<div class="button-center">
    <?php echo CHtml::submitButton($badges->isNewRecord
        ? 'Create'
        : 'Save'); ?>
</div>
<?php $this->endWidget(); ?>

