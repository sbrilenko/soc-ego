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
                                            <div class="message-block-user-message"><?php echo htmlspecialchars($friend['message']);?> t is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use </div>

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
                <div class="before-wall-content not-active">
                    <div class="wall-content nano message-page-block-dialog-scroll-h">
                        <div class='dialog-messages wall nano-content message-page-block-dialog-scroll-h'>

                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function()
                    {
                        $(document).on('click','.file-upload-part-2',function()
                        {
                            var removearr=$('#newmessage-send-form').serializeArray();
                            console.log(removearr)
                            $.ajax({
                                url: "messageRemoveFile",
                                type: "POST",
                                data: removearr,
                                dataType: "json",
                                success: function (data, textStatus) {
                                    console.log(data)
                                    if(data.error)
                                    {

                                        setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                                    }
                                    else
                                    {
                                        $('#newmessage-send-form input[name*=image]').val('');
                                        $('.addmessage-form,.addmessage-form table').animate({height:68},500);
                                        $('.message-file').addClass('displ-none');
                                        $('.message-filename').text('')
                                    }
                                }
                            })
                            return false;
                        })
                        $(document).on('change','#newmessage-send-form input[type=file]',function()
                        {
                            $('.new-comment .new-comment-file-b').addClass('preloader');
                            var th=$(this);
                            var formElement = document.getElementById("newmessage-send-form");
                            var fd = new FormData(formElement);
                            $.ajax({
                                url: "messageCreateFile",
                                type: "POST",
                                data: fd,
                                dataType: "json",
                                enctype: 'multipart/form-data',
                                processData: false,
                                contentType: false,
                                success: function (data, textStatus) {
                                    console.log(data)
                                    $('.new-comment .new-comment-file-b').removeClass('preloader');
                                    if(data.error)
                                    {

                                        setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                                    }
                                    else
                                    {
                                        $('#newmessage-send-form input[name*=image]').val(data.id);
                                        $('.addmessage-form,.addmessage-form table').animate({height:124},500);
                                        $('.message-file').removeClass('displ-none');
                                        $('.message-filename').text(data.name)
                                    }
                                }
                            })
                            return false;
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
                        $('#newmessage-send-form').on( 'keyup', 'textarea', function (e){
                            $(this).css('height', 'auto' );
                            $(this).height( this.scrollHeight );
                        });
                        $('#newmessage-send-form').find( 'textarea' ).keyup();
                    })
                </script>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id'=>'newmessage-send-form',
                    'enableAjaxValidation'=>true,
                    'enableClientValidation'=>true,
                    'htmlOptions' => array('enctype' => 'multipart/form-data',"class"=>"addmessage-form not-active")
                ));
                ?>
                <div class="mar-zero displ-none">

                    <?php
                    if(isset($message) and !empty($message))
                    {
                        echo $message,"<br />";
                    }
                    else
                    {
                        echo "<div>";
                        echo "<div>";
                        echo "<div class='message-file displ-none'>";
                        echo "<div class='pad-zero' style='padding-bottom: 10px;'>";
                        echo "<div class='f-l file-upload-part-1'>
                        <div class='file-upload-part-2'></div>
                        </div>";
                        echo "<div class='f-l message-filename'></div>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='clear'></div>";
                        $message=new Message();
                        echo "<div class='new-comment'>";
                        echo $form->hiddenField($message,'from_user_id',array("value"=>Yii::app()->user->id));
                        echo $form->hiddenField($message,'to_user_id',array("value"=>""));
                        echo $form->hiddenField($message,'image',array("value"=>""));
                        echo "<div style='padding: 0;position: relative;width:100%;'>";
                        echo "<div style='padding-right:160px;'>";
                        echo $form->textArea($message,'message',array("placeholder"=>'Enter your message here...','style'=>'overflow: hidden;height:12px !important;border:0;padding:13px;width: 100%;font-family:HelveticaNeueCyr-Roman;font-size: 12px;line-height:15px; color:#c4c4c4  ;'));

                        echo "<div style='padding: 0;width: 60px;position: absolute;top: 0;right: 73px;'>";
                        echo "<div class='new-comment-file-b'>"; //preloader
                        echo $form->fileField($message,'pict',array("class"=>"add-comment-file-icon",'style'=>'cursor:pointer;padding: 0;width: 40px;border-radius: 5px;border:1px solid #dedede;'));
                        echo "</div>";
                        echo "</div>";
                        echo "<div style='padding: 0;width:72px;position: absolute;top: 0;right: 0;'>";
                        echo CHtml::submitButton('Send',array('class'=>'','style'=>"height:40px;border:0;padding:0;background-color: #22c9ff;border-radius: 5px;width:72px;color:#fff"));
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";

                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
    </div>
</div>