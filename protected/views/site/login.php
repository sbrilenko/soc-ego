<div class="filter"></div>
<div class="bg"></div>
    <div class="form login-form <?php if(!empty($error)) { ?>witherror<?php } ?>" >
        <div class="maybe-logo-place"></div>

        <div class="form-padding">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            ));
            ?>
            <?php if(!empty($error)) { ?><div class="errorMessage"><?php echo $error;?> </div><?php } ?>
            <div class="row" style="margin-top: 0;">
                <?php echo $form->textField($model,'email',array("autocomplete"=>"off","placeholder"=>"Email","style"=>"padding: 16px 5px 16px 56px;width: 268px;box-shadow:0 1px 1px rgba(0, 0, 0, 0.05);")); ?>
            </div>
            <div class="clear"></div>
            <div class="row">
                <?php echo $form->passwordField($model,'password',array("autocomplete"=>"off","placeholder"=>"Password","style"=>"padding: 16px 5px 16px 56px;width: 268px;box-shadow:0 1px 1px rgba(0, 0, 0, 0.05);")); ?>
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
                <a href="/forgotpass" class="forgotpass">Forgot Password?</a>
            </div>
            <div class="clear"></div>
            <?php $this->endWidget(); ?>
        </div>
    </div>


<!--<div class="cd-form">-->
<!--    <div class="form">-->
<!--        <div class="maybe-logo-place"></div>-->
<!--        <form>-->
<!--            <input class="email" type="text" name="cd-email" placeholder="Email" required>-->
<!--            <input class="password" type="text" name="cd-password" placeholder="Password" required>-->
<!--            <button class="login">SIGN IN</button>-->
<!--            <div class="other">-->
<!--                <a href="#" class="forgot">Forgot password?</a>-->
<!--            </div>-->
<!--        </form>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="filter"></div>-->
<!--<div class="bg"></div>-->

