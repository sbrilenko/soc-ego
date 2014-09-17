<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'addcomments-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'action'=>'',
    'htmlOptions' => array('enctype' => 'multipart/form-data')
));
?>
<div class="row">
    <div class="span6">

        <?php
            if(isset($message) and !empty($message))
            {
                echo $message,"<br />";
            }
            else
            {
                $comment_m=new Comments();
                echo "<div class='new-comment'>";
                echo $form->hiddenField($comment_m,'commented_user_id',array("value"=>"")); //
                echo $form->hiddenField($comment_m,'create_user_id',array("value"=>"")); //who comment
                echo $form->textArea($comment_m,'text',array("placeholder"=>'text'));
                echo "<div>";
                    echo "<div class='float-left new-comment-file-b'>";
                        echo "<div>",$form->fileField($comment_m,'image'),"</div>";
                    echo "</div>";
                echo "</div>";
                echo CHtml::submitButton(Yum::t('Post'),array('class'=>'float-left'));
                echo "</div>";
            }
        ?>
</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(function()
    {
        $('form#addcomments-form').submit(function()
        {
            //$(this).serializeArray()
            var fd = new FormData(document.getElementById("addcomments-form"));
//          fd.append("label", "WEBUPLOAD");
//          console.log(fd)
            $.ajax({
                url: "/commentsadd",
                type: "POST",
                data: fd,
                enctype: 'multipart/form-data',
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType
                success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                    data=$.parseJSON(data);
                    var html="<li>";

                    if(data.image!="")
                    {
                       html+="<div class='text-center'><img src='"+data.image+"' /></div>";
                    }
                    if(data.text!="")
                    {
                        html+="<div>"+data.text+"</div>";
                    }
                    html+="</li>";
                    if(html!="")
                    {
                        $(html).insertBefore($('.wall li:first'))
                        $(".new-comment textarea").val("")
                        $(".new-comment input[type=file]").replaceWith('<input name="Comments[image]" id="Comments_image" type="file">')
                    }
                }
            })
            return false
        })
    })
</script>
<?php $this->endWidget(); ?>

