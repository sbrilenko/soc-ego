<?php
/* @var $this UserController */
/* @var $model User */
/* @var $profile Profile */
/* @var $form CActiveForm */
?>

<?php
if(isset($message)) { ?>
  <div style="color:red">
 <?php echo $message; ?>
 </div>
<?php } ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')

)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('value'=>'','size'=>60,'maxlength'=>64,'style'=>'float:left')); ?>
        <div class="passgenerator ui-state-default" style="float:left;margin: 4px 7px;cursor:pointer;" title="Pass generator">
            <span class="ui-icon ui-icon-key"></span>
        </div>
        <div class="showpass ui-state-default" style="float:left;margin: 4px 7px 4px 0;cursor:pointer;" title="Show Password">
            <span class="ui-icon ui-icon-locked"></span>
        </div>
        <div class="clear"></div>
		<?php echo $form->error($model,'password'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'confirm_password'); ?>
        <?php echo $form->passwordField($model,'confirm_password',array('value'=>'','size'=>60,'maxlength'=>64)); ?>
        <?php echo $form->error($model,'confirm_password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>64)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model, 'status',array("0"=>"No active","1"=>"Active")); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'superuser'); ?>
		<?php echo $form->dropDownList($model, 'superuser',array(0=>"No",1=>"Yes")); ?>
		<?php echo $form->error($model,'superuser'); ?>
	</div>

	<div class="row">
        <?php
        echo $form->labelEx($model, 'day_count');
        if($model->day_count==0) $day_count_value='';
        else $day_count_value=date("m/d/Y",$model->day_count);
        echo $form->textField($model, 'day_count',array('value'=>$day_count_value,'readonly'=>'readonly','data-provide'=>'datepicker','class'=>'day-count'));
        echo $form->error($model, 'day_count'); ?>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
        <script type="text/javascript">
            $(document).ready(function()
            {
                $(".day-count").datepicker({
                    format: "dd MM yyyy",
                    autoclose: true,
                    todayBtn: true,
                    changeYear: true,
                    yearRange: "-100:+0",
                    pickerPosition: "bottom-left"
                });
                $('.was-flag').change(function()
                {
                    $(this).val()==1?$(".work-count").val('01/07/2014'):$(".work-count").val('');
                })
                $(".bday").datepicker({
                    format: "dd MM yyyy",
                    autoclose: true,
                    todayBtn: true,
                    changeYear: true,
                    yearRange: "-100:+0",
                    pickerPosition: "bottom-left"
                });
                $(".work-count").datepicker({
                    format: "dd MM yyyy",
                    autoclose: true,
                    todayBtn: true,
                    changeYear: true,
                    yearRange: "-100:+0",
                    pickerPosition: "bottom-left"
                });
            })
        </script>
	</div>

	<div class="row">
		<?php
        // echo $form->labelEx($model,'was_flag'); ?>
		<?php // echo $form->dropDownList($model, 'was_flag',array("0"=>"No","1"=>"Yes"),array("class"=>"was-flag"));  ?>
		<?php // echo $form->error($model,'was_flag'); ?>
	</div>

	<div class="row">
        <?php
        // echo $form->labelEx($model, 'work_count');
        // if($model->work_count==0) $day_work_count='';
        // else $day_work_count=date("m/d/Y",$model->work_count);
        // echo $form->textField($model, 'work_count',array('value'=>$day_work_count,'readonly'=>'readonly','class'=>'work-count'));
        // echo $form->error($model, 'work_count'); ?>
	</div>

	<div class="row">
		<?php
        echo $form->labelEx($model,'job_type'); ?>
        <?php echo $form->dropDownList($model, 'job_type',JobType::model()->allJobType()); ?>
<!--		--><?php //echo $form->dropDownList($model, 'job_type',array('Developer'=>'Developer',
//            'PM'=>'PM',
//            'Designer'=>'Designer',
//            'QA'=>'QA',
//            'Sales manager'=>'Sales manager',
//            'HR'=>'HR',
//            'V.I.P.'=>'V.I.P.'
//        )); ?>
		<?php echo $form->error($model,'job_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'job_title'); ?>
        <?php echo $form->dropDownList($model,'job_title',JobTitle::model()->jobTitleByTypeId($model->job_type));?>
		<?php echo $form->error($model,'job_title'); ?>
	</div>

	<div class="row">
		<?php
        $level_array=array("Trainee","Junior","Junior_Middle","Middle","Middle_Senior","Senior","Senior_Lead","Lead","Tech_Officer");
        $level_seniority_array=array("Low","Normal","High");
        $all_gamif=GamificationManager::model()->findAll();
        if($all_gamif)
        {
            foreach($all_gamif as $gam)
            {
                if(in_array($gam->level,$level_array) && in_array($gam->seniority,$level_seniority_array))
                {
                    $start_month[]=$gam->start_month;
                }
            }
        }
        if(empty($start_month)) $start_month[]="Gamification manager module is not installed, please ask to your programmer";
        echo $form->labelEx($model,'level'); ?>
		<?php echo $form->dropDownList($model, 'level',$level_seniority_array);  ?>
		<?php echo $form->error($model,'level'); ?>
	</div>

	<div class="row">
		<?php
        echo $form->labelEx($model,'start_month'); ?>
		<?php echo $form->dropDownList($model,'start_month',$start_month,array("options"=>array($model->start_month=>array("selected"=>true)))); ?>
		<?php echo $form->error($model,'start_month'); ?>
	</div>

    <div class="row">
        <?php
        $company_array=array();
        $companys=Company::model()->findAll();
        if($companys)
        {
            foreach($companys as $comp)
            {
                $company_array[$comp->id]=$comp->title;
            }
        }
        echo $form->labelEx($model,'company_id'); ?>
        <?php echo $form->dropDownList($model,'company_id',$company_array); ?>
        <?php echo $form->error($model,'start_month'); ?>
    </div>

    <!-- profile -->
    <?php
    if($model->isNewRecord)
    {
        $profile= new Profile();
    }
    else
    {
        $profile= Profile::model()->findByAttributes(array("user_id"=>$model->id));
    }
    ?>
    <div class="row">
        <?php echo $form->labelEx($profile,'firstname'); ?>
        <?php echo $form->textField($profile,'firstname'); ?>
        <?php echo $form->error($profile,'firstname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($profile,'lastname'); ?>
        <?php echo $form->textField($profile,'lastname'); ?>
        <?php echo $form->error($profile,'lastname'); ?>
    </div>

    <div class="row">
        <?php // echo $form->labelEx($profile,'street'); ?>
        <?php // echo $form->textField($profile,'street'); ?>
        <?php // echo $form->error($profile,'street'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($profile,'phone'); ?>
        <?php echo $form->textField($profile,'phone'); ?>
        <?php echo $form->error($profile,'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($profile,'sex'); ?>
        <?php echo $form->dropDownList($profile,'sex',array("1"=>"Male","0"=>"Female")); ?>
        <?php echo $form->error($profile,'sex'); ?>
    </div>

    <div class="row">
        <?php
        $user_locations=array();
        $locations=LocationManager::model()->findAll();
        if($locations)
        {
            foreach($locations as $loc)
            {
                $user_locations[$loc->id]=$loc->locationname;
            }
        }
        echo $form->labelEx($profile,'user_location'); ?>
        <?php echo $form->dropDownList($profile,'user_location',$user_locations,array("options"=>array($profile->user_location=>array('selected'=>true)))); ?>
        <?php echo $form->error($profile,'user_location'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($profile, 'avatar');
        echo $form->fileField($profile, 'avatar');
        echo $form->error($profile, 'avatar');
        if($profile->avatar>0)
        {
            $image=Files::model()->findByPk($profile->avatar);
            if($image)
            {
                if(file_exists(Yii::app()->basePath."/../files/".$image->image))
                {
                    echo "<div><img src='/files/".$image->image."'/></div>";
                }
                else
                {
                    echo Yii::app()->basePath."/../files/".$image->image;
                }
            }
            else
            {
                echo "Image not found";
            }
        }
        ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($profile, 'about');
        $this->widget('application.extensions.cleditor.ECLEditor', array(
            'model'=>$profile,
            'attribute'=>'about', //Model attribute name. Nome do atributo do modelo.
            'options'=>array(
                'width'=>'600',
                'height'=>250,
                'useCSS'=>true,
            ),
            'value'=>$profile->about, //If you want pass a value for the widget. I think you will. Se você precisar passar um valor para o gadget. Eu acho irá.
        ));
        //echo $form->textArea($profile, 'about');
        echo $form->error($profile, 'about');
    ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($profile,'bday'); ?>
        <?php
        if($profile->bday==0) $bday='';
        else $bday=date("m/d/Y",$profile->bday);
        echo $form->textField($profile, 'bday',array('value'=>$bday,'readonly'=>'readonly','class'=>'bday'));
        ?>
        <?php echo $form->error($profile,'bday'); ?>
    </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $(document).ready(function()
    {
        function generatePassword() {
            var length = 8,
                charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                retVal = "";
            for (var i = 0, n = charset.length; i < length; ++i) {
                retVal += charset.charAt(Math.floor(Math.random() * n));
            }
            return retVal;
        }
        $(document).on('click','.passgenerator',function()
        {
            var var_pass=generatePassword();
            $('#user-form input[name*=password]').val(var_pass);
            $('#user-form input[name*=confirm_password]').val(var_pass)

        }).on('click','.showpass',function()
        {
            if($('#user-form input[name*=password]').attr('type')=="text")
            {
                var clon=$('#user-form input[name*=password]').clone();
                var clon_con=$('#user-form input[name*=confirm_password]').clone();
                clon.attr('type','password')
                $('#user-form #User_password').replaceWith(clon)
                clon_con.attr('type','password')
                $('#user-form #User_confirm_password').replaceWith(clon_con)
                $(this).attr('title','Show Password');
                $('>span',this).removeClass('ui-icon ui-icon-unlocked').addClass('ui-icon ui-icon-locked');
            }
            else
            {
                var clon=$('#user-form input[name*=password]').clone();
                var clon_con=$('#user-form input[name*=confirm_password]').clone();
                clon.attr('type','text')
                $('#user-form #User_password').replaceWith(clon)
                clon_con.attr('type','text')
                $('#user-form #User_confirm_password').replaceWith(clon_con)
//                $('#user-form input[name*=password]').attr('type','text');
//                $('#user-form input[name*=confirm_password]').attr('type','text');
                $(this).attr('title','Hide Password');
                $('>span',this).removeClass('ui-icon ui-icon-locked').addClass('ui-icon ui-icon-unlocked');
            }


        }).on("change","select[name*=job_type]",function()
        {
            var th=$(this);
            if(!th.hasClass('disabled'))
            {
                th.addClass('disabled');
                var job_title=$("select[name*=job_title]");
                var fd =$('#user-form').serializeArray();
                $.ajax({
                    url: "/jobtitle/getByParId",
                    type: "POST",
                    data: fd,
                    dataType: "json",
                    success: function (data, textStatus) {
                        th.removeClass('disabled');
                        if(typeof data.jobtitles!=='undefined')
                        {
                            job_title.empty();
                            for(jobtit in data.jobtitles)
                            {
                                $("select[name*=job_title]").append($("<option value='"+jobtit+"'>"+data.jobtitles[jobtit]+"</option>"));
                            }
                        }
                    }
                })
            }
            return false
        })
    })
</script>