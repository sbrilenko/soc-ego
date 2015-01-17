<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/nanoscroller.css" rel="stylesheet">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.nanoscroller.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mousewheel.js"></script>
<script>
    $(document).ready(function()
    {
        function initScrollPanes()
        {
            $(function()
            {
                $(".nano").nanoScroller({ scroll: 'bottom',flash: true  });
            });
        }
        setTimeout(initScrollPanes, 100);
    })
</script>
<div class="main">
<div class="messages-title">Messages</div>

    <table style="padding: 0;margin: 0;">
        <tr>
            <td class="message-block">
                <div class="message-block-title">Messages</div>
                <div class="group-scroll nano" style="height: 640px;">
                    <table class="group-wall-content nano-content" style="margin: 0;">
                        <?php
                        if(count($friends)>0)
                        {
                            foreach($friends as $index => $friend)
                            {
                            ?>
                                <tr>
                                    <td class="padding-zero tdone left-pad white-space-nowrap <?php if($friend['count']>0) echo 'not-read-message-st'?>" style="position: relative;">
                                        <a href="#" class="get-message">
                                            <div style="padding:16px 0;">
                                            <div style="display: none;">
                                                <?php $mess=Message::model()->findByPk($friend['message_id']);?>
                                                <?php $form=$this->beginWidget('CActiveForm', array(
                                                    'id'=>'users-form-reg-form',
                                                    'enableAjaxValidation'=>true,
                                                    'clientOptions'=>array(
                                                        'validateOnSubmit'=>true,
                                                    ),
                                                )); ?>
                                                <?php echo $form->hiddenField($mess,'id');?>
                                                <?php echo $form->hiddenField($mess,'from_user_id');?>
                                                <?php echo $form->hiddenField($mess,'to_user_id');?>
                                                <?php $this->endWidget(); ?>
                                            </div>
                                            <img class='f-l' style='padding: 0;width:36px;height:36px;border-radius: 36px;' src='<?php echo $friend['icon'];?>'/>
                                            <div class='f-l'>
                                                <div class="message-block-user-name"><?php echo htmlspecialchars($friend['full_name']);?><span class="message-new-message" <?php if($friend['count']>0) echo "style='display:inline;'"?>><?php if($friend['count']>0) echo $friend['count'];?></span></div>
                                                <div class="message-block-user-position"><?php echo htmlspecialchars($friend['job_type']);?></div>
                                            </div>
                                            <div class="f-r message-block-user-time"><?php echo htmlspecialchars($friend['time']);?></div>
                                            <div class="clear"></div>
                                            <div class="message-block-user-message"><?php echo htmlspecialchars($friend['message']);?></div>

                                        </div>
                                        <div class="active-dialog"></div>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </td>
            <td style="padding: 0;width:2%;"></td>
            <td class='messages-dialog-block' style="overflow:hidden;width:45%;position:relative;padding: 0;border:1px solid #eaeaea;vertical-align: top;border-radius: 6px;height:640px;background: #fff;">
                <div class="message-block-title">Dialogs</div>
                <div class="before-wall-content not-active">
                    <div class="wall-content nano" style='height: 582px;'>
                        <div class='dialog-messages wall nano-content' style='height: 582px;'>

                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function()
                    {
                        $(document).on('click','.get-message',function()
                        {
                            $('.message-block .active-dialog').hide()
                            $('.messages-dialog-block').find('.not-active').removeClass('not-active')
                            $('#newmessage-form >table').show();
                            $('.active-dialog',this).show();
                            $(this).parent('td').removeClass('.not-read-message-st');

                            var th=$(this);
                            var form=th.find('form').serializeArray();
                            console.log(form)
                            $.ajax({
                                url: "getMessagesHistory",
                                type: "POST",
                                data: form,
                                //dataType: "json",
                                success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                                    console.log(data)
                                    data=$.parseJSON(data);
                                    if(data.error)
                                    {

                                    }
                                    else
                                    {
                                        $('.dialog-messages').empty().append(data.html)
                                        setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                                    }
                                }
                            })
                            return false;
                        })
                        $(document).on('submit','form#newmessage-form',function()
                        {
//                                var fd =$(this).serializeArray();
                            var th=$(this);
                            var formElement = document.getElementById("newmessage-form");
                            var fd = new FormData(formElement);
                            console.log(fd)
                            $.ajax({
                                url: "CommentsAdd",
                                type: "POST",
                                data: fd,
                                enctype: 'multipart/form-data',
                                processData: false,  // tell jQuery not to process the data
                                contentType: false,   // tell jQuery not to set contentType
                                success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                                    console.log(data)
                                    data=$.parseJSON(data);
                                    if(data.error)
                                    {

                                    }
                                    else
                                    {
                                        $(".wall").append(data.html)
                                        th.find("input[name*=text]").val("");
                                        setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                                    }
                                }
                            })
                            return false
                        })
                    })
                </script>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id'=>'newmessage-form',
                    'enableAjaxValidation'=>true,
                    'enableClientValidation'=>true,
                    'htmlOptions' => array('class'=>'not-active','enctype' => 'multipart/form-data',"style"=>"position:absolute;bottom:0;width:100%;height: 58px;")
                ));
                ?>
                <table style="display:none;padding:9px;background-color:#e8e8e8;height: 40px;">

                    <?php
                    if(isset($message) and !empty($message))
                    {
                        echo $message,"<br />";
                    }
                    else
                    {
                        $comment_m=new Comments();
                        echo "<tr class='new-comment'>";
                        echo $form->hiddenField($comment_m,'commented_user_id',array("value"=>"")); //
                        echo $form->hiddenField($comment_m,'create_user_id',array("value"=>"")); //who comment
                        echo "<td class='new-comment-file-b' style='padding: 0;width: 40px;'>";
                        echo $form->fileField($comment_m,'image',array("class"=>"add-comment-file-icon"));
                        echo "</td>";
                        echo "<td style='padding: 0'>";
                        echo $form->textField($comment_m,'text',array("placeholder"=>'Enter your message here...','style'=>'height:40px;border:0;padding:0 5%;width:90%;'));
                        echo "</td>";
                        echo "<td style='padding: 0;width:72px;'>";
                        echo CHtml::submitButton('Send',array('class'=>'','style'=>"height:40px;border:0;padding:0;background-color: #22c9ff;border-radius: 0 5px 5px 0;width:72px;color:#fff"));
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <?php $this->endWidget(); ?>
            </td>
        </tr>
    </table>
</div>