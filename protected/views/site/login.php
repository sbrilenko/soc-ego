<div class="form login-form" >
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    ));
    ?>
    <div class="maybe-logo-place"></div>
    <div class="form-padding">
        <div class="row" style="margin-top: 0;">
            <div class="login-icon"></div>
            <?php echo $form->textField($model,'email',array("placeholder"=>"Email","style"=>"padding: 16px 5px 16px 56px;width: 268px;box-shadow:0 1px 1px rgba(0, 0, 0, 0.05);")); ?>
        </div>
        <div class="clear"></div>
        <div class="row">
            <div class="password-icon"></div>
            <?php echo $form->passwordField($model,'password',array("placeholder"=>"Password","style"=>"padding: 16px 5px 16px 56px;width: 268px;box-shadow:0 1px 1px rgba(0, 0, 0, 0.05);")); ?>
        </div>
        <div class="clear"></div>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Login',array('class'=>"login-submit")); ?>
        </div>
        <div class="clear"></div>
            <div class="row rememberMe" style="float:left;">
                <?php echo $form->checkBox($model,'rememberme'); ?>
                <?php echo $form->label($model,'rememberme'); ?>
            </div>
        <div class="row" style="float:right;">
            <a href="#" class="forgotpass">Forgot Password?</a>
        </div>
        <div class="clear"></div>
<!--        --><?php //echo $form->error($model,'email'); ?>
<!--        --><?php //echo $form->error($model,'password'); ?>
        <?php echo $form->error($model,'error'); ?>
        <?php $this->endWidget(); ?>

    </div>
</div><!-- form -->