
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        'action'=>"/locationmanager/insert",
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
    ));
    ?>
<fieldset class="new-location">
    <legend>Insert new location</legend>
<div class="row">
    <div class="span6">
        <?php
        $locationmanager=new LocationManager();
        echo $form->textField($locationmanager, 'locationname');
        echo CHtml::submitButton("Add",array('title'=>'Add new location'));

        ?>
    </div>
</div>
    </fieldset>
    <?php $this->endWidget(); ?>
