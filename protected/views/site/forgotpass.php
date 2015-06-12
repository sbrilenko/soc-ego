<div class="filter"></div>
<div class="bg"></div>
    <div class="form forgotpass-form <?php if(!empty($error)) { ?>witherror<?php } ?> <?php if(!empty($message)) { ?>withmessage<?php } ?>">
        <div class="forgotpass-title">Please enter your Email</div>
        <div class="form-padding">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'forgotpass-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            ));
            ?>
            <?php if(!empty($error)) { ?><div class="errorMessage"><?php echo $error;?> </div><?php } ?>
            <?php if(!empty($message)) { ?><div class="message"><?php echo $message;?> </div><?php } ?>
            <div class="row" style="margin-top: 0;">
                <?php echo $form->emailField($model,'email',array("autofocus"=>true,"autocomplete"=>"off","placeholder"=>"Email","style"=>"padding: 16px 5px 16px 56px;width: 268px;box-shadow:0 1px 1px rgba(0, 0, 0, 0.05);")); ?>
            </div>
            <div class="clear"></div>
            <div class="row buttons">
                <?php echo CHtml::submitButton('Send',array('class'=>"login-submit")); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
        <div class="back-par">
            <a href="/" class="go-to-signin">Back to Sign In</a>
        </div>
    </div>

