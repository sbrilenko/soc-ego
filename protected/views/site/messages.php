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
                                                <?php if($friend['current_user_id']==$mess->from_user_id) { ?>
                                                <?php echo $form->hiddenField($mess,'id');?>
                                                <?php echo $form->hiddenField($mess,'from_user_id');?>
                                                <?php echo $form->hiddenField($mess,'to_user_id');?>
                                                <?php } else { ?>
                                                    <?php echo $form->hiddenField($mess,'id');?>
                                                    <?php echo $form->hiddenField($mess,'from_user_id',array('value'=>$mess->to_user_id));?>
                                                    <?php echo $form->hiddenField($mess,'to_user_id',array('value'=>$mess->from_user_id));?>
                                                <?php } ?>
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
                        $(document).on('change','#newmessage-send-form input[type=file]',function()
                        {
                            var th=$(this);
                            var formElement = document.getElementById("newmessage-send-form");
                            var fd = new FormData(formElement);
                            $.ajax({
                                url: "getMessagesHistory",
                                type: "POST",
                                data: form,
                                dataType: "json",
                                success: function (data, textStatus) {
                                    if(data.error)
                                    {

                                    }
                                    else
                                    {
                                        $('.dialog-messages').empty().append(data.html)
                                        $('#newmessage-send-form input[name*=from_user_id]').val(data.from_id);
                                        $('#newmessage-send-form input[name*=to_user_id]').val(data.to_id);
                                        setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                                    }
                                }
                            })
                            return false;
                            $('#newmessage-send-form .new-comment-file-b').addClass('preloader')
                        })
                        $(document).on('click','.get-message',function()
                        {
                            $('.message-block .active-dialog').hide()
                            $('.messages-dialog-block').find('.not-active').removeClass('not-active')
                            $('#newmessage-send-form >table').show();
                            $('.active-dialog',this).show();
                            $(this).parent('td').removeClass('.not-read-message-st');

                            var th=$(this);
                            var form=th.find('form').serializeArray();
                            console.log(form)
                            $.ajax({
                                url: "getMessagesHistory",
                                type: "POST",
                                data: form,
                                dataType: "json",
                                success: function (data, textStatus) {
                                    if(data.error)
                                    {

                                    }
                                    else
                                    {
                                        $('.dialog-messages').empty().append(data.html)
                                        $('#newmessage-send-form input[name*=from_user_id]').val(data.from_id);
                                        $('#newmessage-send-form input[name*=to_user_id]').val(data.to_id);
                                        setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                                    }
                                }
                            })
                            return false;
                        }).on('submit','#newmessage-send-form',function(){
                            var th=$(this);
                            var formElement = document.getElementById("newmessage-send-form");
                            var fd = new FormData(formElement);
                            console.log(th.serializeArray()," | ")
                            var msg = {
                                type: 'system.message',
                                data: th.serializeArray()
                            };
                            console.log(msg);
                            try{ websocket.send(JSON.stringify(msg));console.log('send')}
                            catch(ex){
                                console.log(ex.data);
                                return false}
                            return false
                        })
                    })
                </script>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id'=>'newmessage-send-form',
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
                        $message=new Message();
                        echo "<tr class='new-comment'>";
                        echo $form->hiddenField($message,'from_user_id',array("value"=>Yii::app()->user->id));
                        echo $form->hiddenField($message,'to_user_id',array("value"=>""));
                        echo "<td style='padding: 0'>";
                        echo $form->textField($message,'message',array("placeholder"=>'Enter your message here...','style'=>'height:40px;border:0;padding:0 5%;width:90%;'));
                        echo "</td>";
                        echo "<td style='padding: 0;width: 60px;'>";
                        echo "<div class='new-comment-file-b'>"; //preloader
                        echo $form->fileField($message,'image',array("class"=>"add-comment-file-icon",'style'=>'cursor:pointer;padding: 0;width: 40px;border-radius: 5px;border:1px solid #dedede;'));
                        echo "</div>";
                        echo "</td>";
                        echo "<td style='padding: 0;width:72px;'>";
                        echo CHtml::submitButton('Send',array('class'=>'','style'=>"height:40px;border:0;padding:0;background-color: #22c9ff;border-radius: 5px;width:72px;color:#fff"));
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