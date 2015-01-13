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
                                    <td class="padding-zero tdone left-pad white-space-nowrap" style="padding:16px ;">
                                        <a href="#" class="get-message">
                                            <img class='f-l' style='padding: 0;width:36px;height:36px;border-radius: 36px;' src='<?php echo $friend['icon'];?>'/>
                                            <div class='f-l'>
                                                <div class="message-block-user-name"><?php echo htmlspecialchars($friend['full_name']);?></div>
                                                <div class="message-block-user-position"><?php echo htmlspecialchars($friend['job_type']);?></div>
                                            </div>
                                            <div class="f-r message-block-user-time"><?php echo htmlspecialchars($friend['time']);?></div>
                                            <div class="clear"></div>
                                            <div class="message-block-user-message"><?php echo htmlspecialchars($friend['message']);?></div>
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
            <td style="overflow:hidden;width:45%;position:relative;padding: 0;border:1px solid #eaeaea;vertical-align: top;border-radius: 6px;height:640px;background: #fff;">
                <div class="message-block-title">Dialogs</div>
                <div class="before-wall-content">
                    <div class="wall-content nano" style='height: 527px;'>
                        <div class='wall nano-content' style='height: 527px;'>

                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function()
                    {
                        $(document).on('submit','form#addcomments-form',function()
                        {
//                                var fd =$(this).serializeArray();
                            var th=$(this);
                            var formElement = document.getElementById("addcomments-form");
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
                        }).on('submit','form.comment-comment-form',function(e)
                        {
                            var th= $(this);
                            var fd = th.serializeArray();
                            $.ajax({
                                url: "CommentsCommentsAdd",
                                type: "POST",
                                data: fd,
                                success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                                    data=$.parseJSON(data);
                                    console.log(data)
                                    if(data.error)
                                    {
                                        console.log(data.message)
                                    }
                                    else
                                    {
                                        th.find("input[name*=text]").val("")
                                        $(data.html).insertBefore(th.parents("table")[0])
                                    }
                                }
                            })
                            return false
                        }).on('click','.like-icon',function()
                        {
                            var th= $(this);
                            var form=th.find('div').clone();
                            var fd = th.find('form').serializeArray();
                            $.ajax({
                                url: "like",
                                type: "POST",
                                data: fd,
                                success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                                    data=$.parseJSON(data);
                                    if(data.error)
                                    {
                                        console.log(data.message)
                                    }
                                    else
                                    {
                                        th.text(data.message)
                                        th.append(form)
                                    }
                                }
                            })
                        })
                        return false
                    })
                </script>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id'=>'addcomments-form',
                    'enableAjaxValidation'=>true,
                    'enableClientValidation'=>true,
                    'htmlOptions' => array('enctype' => 'multipart/form-data',"style"=>"position:absolute;bottom:0;width:100%;height: 58px;")
                ));
                ?>
                <table style="padding:9px;background-color:#e8e8e8;height: 40px;">

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