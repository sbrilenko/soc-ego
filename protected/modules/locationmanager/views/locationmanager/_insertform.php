
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        'action'=>Yum::module('locationmanager')->insertUrl,
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
    ));
    ?>
<div class="row">
    <div class="span6">
        <?php
        $locationmanager=new LocationManager();
        echo $form->textField($locationmanager, 'locationname');
        echo CHtml::submitButton(Yum::t('Insert new location'));

        ?>
    </div>
</div>
    <?php $this->endWidget(); ?>
