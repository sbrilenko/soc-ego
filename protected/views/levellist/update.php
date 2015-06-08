<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'levellist-form',
    'action'=>'/levellist/update',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
));
?>
<fieldset class="badge-add-form">
    <legend>Update level</legend>
    <?php if($levellist) { ?>
            <div class="row">
                <div class="span6">
                    <?php
                        echo $form->hiddenField($levellist, 'id');
                    ?>
                    <div><?php echo htmlspecialchars($levellist->job_title);?></div>
                    <div>
                    <?php echo $form->labelEx($levellist, 'description');
                    $this->widget('application.extensions.cleditor.ECLEditor', array(
                        'model'=>$levellist,
                        'attribute'=>'description',
                        'options'=>array(
                            'width'=>'600',
                            'height'=>250,
                            'useCSS'=>true,
                            'class'=>'width-80 textarea-min-height'
                        ),
                        'value'=>$levellist->description,
                    ));
                    echo $form->error($levellist, 'description'); ?>
                    </div>
                </div>

            </div>
    <?php }?>
</fieldset>
<div class="button-center">
<?php echo CHtml::submitButton('Save'); ?>
</div>
<?php $this->endWidget(); ?>

