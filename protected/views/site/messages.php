<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/nanoscroller.css" rel="stylesheet">
<link href="/css/messages-responsive.css" rel="stylesheet">
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
<div class="f-r blue-message-margin-b">
    <div class="blue-message position-relative">
        <div class="big">New Items</div>
        <div class="little">Available on market</div>
        <div class="new-items-close-cross">x</div>
    </div>
</div>
<div class="clear"></div>
    <div class="pad-mar-zero" style="width: 100%;">
            <div class="message-block f-l">
                <div class="message-block-title">Messages</div>
                <div class="group-scroll nano message-page-block-messages-h">
                    <div class="group-wall-content nano-content mar-zero" style="left: 13px;">
                        <?php
                        if(count($friends)>0)
                        {
                            foreach($friends as $index => $friend)
                            {
                            ?>
                                <div class="messages-friend-container <?php if($friend['count']>0) echo 'not-read-message-st'?>" >
                                    <div class="padding-zero left-pad white-space-nowrap position-relative">
                                        <a href="#" class="get-message">
                                            <div class="message-page-block-messg-spec-pad">
                                            <div class="displ-none">
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
                                            <img class='f-l message-page-block-message-img messages-img-margin' src='<?php echo $friend['icon'];?>'/>
                                            <div class='f-l'>
                                                <div class="message-block-user-name"><?php echo htmlspecialchars($friend['full_name']);?><span class="message-new-message <?php if($friend['count']>0) echo "displ-inline"?>" ><?php if($friend['count']>0) echo $friend['count'];?></span></div>
                                                <div class="message-block-user-position"><?php echo htmlspecialchars(JobType::model()->findByPk($friend['job_type'])->job_type);?></div>
                                            </div>
                                            <?php if($friend['count']>0) { ?>
                                                <div class="f-l">
                                                    <div class="new-messages-number"><?php echo htmlspecialchars($friend['count']) ?></div>
                                                </div>
                                            <?php }; ?>
                                            <div class="f-r message-block-user-time"><?php echo htmlspecialchars($friend['time']);?></div>
                                            <div class="clear"></div>
                                            <div class="message-block-user-message"><?php echo htmlspecialchars($friend['message']);?></div>

                                        </div>
                                        <div class="active-dialog"></div>
                                        </a>
                                    </div>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="message-and-dialog-mar f-l"></div>
            <div class='messages-dialog-block message-page-block-dialog f-l'>
                <div class="message-block-title">Dialogs</div>
                <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id'=>'send-message-form',
                        'enableAjaxValidation'=>true,
                        'enableClientValidation'=>true,
                        'htmlOptions' => array('enctype' => 'multipart/form-data',"class"=>"send-message-form")
                    ));
                    ?>
                    <div>

                        <?php
                        if(isset($message) and !empty($message))
                        {
                            echo $message,"<br />";
                        }
                        else
                        {
                            $new_message=new Message(); ?>
                            <div class='messages-new-message position-relative' style="padding: 7px;  border-bottom: 1px solid #eaeaea;margin-bottom: 7px;">
                                <?php echo $form->hiddenField($new_message,'from_user_id',array("value"=>Yii::app()->user->id));?>
                                <?php echo $form->hiddenField($new_message,'to_user_id',array("value"=>""));?>
                                <div class='pad-zero' style="  margin-right: 127px;">
                                    <?php echo $form->textArea($new_message,'message',array("placeholder"=>'Enter your message here...','class'=>'messages-message-text-style'));?>
                                </div>
                                <div class="pos-ab" style="  right: 8px;top: 8px;">
                                    <div class='parent-file-style f-l'>
                                         <div class='messages-new-message-file-b'>
                                             <?php echo $form->fileField($new_message,'image',array("class"=>"messages-message-file-style"));?>
                                         </div>
                                    </div>
                                    <div class='parent-send-button f-l'>
                                        <?php echo CHtml::submitButton('Send',array('class'=>'send-button'));?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php $this->endWidget(); ?>
                <div class="send-message-form-placeholder"></div>
                <div class="before-wall-content not-active">
                    <div class="wall-content nano message-page-block-dialog-scroll-h">
                        <div class='dialog-messages wall nano-content message-page-block-dialog-scroll-h'>

                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function()
                    {
                        $(document).on('change','#send-message-form input[type=file]',function(e){
                            var th=$('#send-message-form .messages-new-message-file-b');
                            if(typeof e.target.files[0]=='undefined') {
                                th.removeClass('clip')
                            } else {
                                th.addClass('clip')
                            }
                        });
                        $(document).on('click','.get-message',function()
                        {
                            $('.message-block .active-dialog').hide()
                            $('.messages-dialog-block').find('.not-active').removeClass('not-active')
                            // $('#newmessage-send-form >table').show();
                            $('.send-message-form').show();
                            $('.send-message-form-placeholder').hide();
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
                                        $('.dialog-messages').empty().append(data.html).attr('id', data.to_id);
                                        $('#send-message-form input[name*=from_user_id]').val(data.from_id);
                                        $('#send-message-form input[name*=to_user_id]').val(data.to_id);
                                        setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                                    }
                                }
                            })
                            return false;
                        })
                        $(document).on('submit','form#send-message-form',function(){
                            var th=$(this);
                            var user = <?php echo Yii::app()->user->id; ?>
                            // Client side empty messages check.
                            if (th.find('input[type=file]').val() == '' && $.trim(th.find('textarea').val()) == '') return false;

                            var formElement = document.getElementById("send-message-form");
                            var fd = new FormData(formElement);
                            $.ajax({
                                url: "SendMessage",
                                type: "POST",
                                data: fd,
                                enctype: 'multipart/form-data',
                                processData: false,
                                contentType: false,
                                dataType: "json",
                                success: function (data, textStatus) {

                                    // Refresh last message inside friends tab.
                                    $('.get-message').each(function() {
                                        var form=$(this).find('form');
                                        if((form.find('input[name*=from_user_id]').val()==user && form.find('input[name*=to_user_id]').val()==data.send_to) || 
                                            (form.find('input[name*=from_user_id]').val()==data.send_to && form.find('input[name*=to_user_id]').val()==user))
                                        {
                                            $('.message-block-user-time',this).text(data.date);
                                            if (data.message) {
                                                $('.message-block-user-message',this).text(data.message);
                                            } else {
                                                $('.message-block-user-message',this).text("Image file");
                                            }
                                        }
                                    });

                                    // Append new message to conversation if it's open.
                                    if ($('.dialog-messages').attr('id') === data.send_to ) {
                                        $('.dialog-messages').append(data.to_html);
                                    }

                                    // Reset form after input message.
                                    th.wrap('<form>').closest('form').get(0).reset();
                                    th.unwrap();

                                    // Reset form clip class.
                                    th.find('.messages-new-message-file-b').removeClass('clip');

                                    setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);

                                    // Send Websocket message to reciever.

                                    msg = {
                                        'send_to': data.send_to,
                                        'from': user,
                                        'text': data.message,
                                        'html': data.from_html,
                                        'date': data.date,
                                        'type': 'system.friendmessage'
                                    };
                                    try {
                                        websocket.send(JSON.stringify(msg));
                                    } catch (e) {
                                        console.log(e);
                                    }

                                },

                            });
                            return false;
                        })
                        // $('#newmessage-send-form').on( 'keyup', 'textarea', function (e){
                        //     $(this).css('height', 'auto' );
                        //     $(this).height( this.scrollHeight );
                        // });
                        // $('#newmessage-send-form').find( 'textarea' ).keyup();
                    })
                </script>
            </div>
    </div>
</div>