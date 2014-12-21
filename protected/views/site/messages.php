<div class="main">
<div class="messages-title">Messages</div>

    <table style="padding: 0;margin: 0;">
        <tr>
            <td style="width:53%;padding: 0;border:1px solid #eaeaea;border-radius: 6px;height:640px;vertical-align: top;background: #fff;">
                <div class="group-scroll nano" style="height: 640px;">
                    <table class="group-wall-content nano-content" style="margin: 0;">
                        <?php
                        if(count($friends)>0)
                        {
                            foreach($friends as $index => $friend)
                            {
                                echo '<tr>';
                                echo '<td class="padding-zero tdone left-pad white-space-nowrap">';
                                $user_friends=$friend->from_user_id==Yii::app()->user->id?Profile::model()->findByAttributes(array("user_id"=>$friend->from_user_id)):Profile::model()->findByAttributes(array("user_id"=>$friend->to_user_id));
                                if($user_friends->avatar)
                                {
                                    $file_company=Files::model()->findByPk($user_friends->avatar);
                                    if($file_company)
                                    {
                                        if(file_exists(Yii::app()->basePath."/../files/".$file_company->image))
                                        {
                                            echo "<a href='#'><img class='f-l' style='padding: 0;width:36px;height:36px;border-radius: 36px;' src='/files/".$file_company->image."'/></a>";
                                        }
                                        else
                                        {
                                            echo "<a href='#'><img class='f-l' style='padding: 0;width:36px;height:36px;border-radius: 36px;' src='/img/default-user.png'/></a>";
                                        }
                                    }
                                    else
                                    {
                                        echo "<a href='#'><img class='f-l' style='padding: 0;width:36px;height:36px;border-radius: 36px;' src='/img/default-user.png'/></a>";
                                    }
                                }
                                else
                                {
                                    echo "<a href='#'><img class='f-l' style='padding: 0;width:36px;height:36px;border-radius: 36px;' src='/img/default-user.png'/></a>";
                                }
                                echo "<div class='project-ver-line f-l'>";
                                echo '<div class="project-title ">'.htmlspecialchars($user->firstname." ".$user->lastname).'</div>';
                                $who_are_you=User::model()->findByPk($user_friends->user_id);
                                echo '<div class="project-pm">'.htmlspecialchars($who_are_you->job_title).'</div>';
                                echo "</div>";
                                echo '</td>';
                                echo '<td class="padding-zero tdmiddle project-ver-line">';
                                echo "<div class='project-company-date text-center'>".htmlspecialchars(Company::model()->findByPk($group_table->company)->title)."</div>";
                                echo '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td>';
//                                echo '<div class="all-friends-block-message">'.htmlspecialchars().'</div>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>

                    </table>
                </div>
            </td>
            <td style="padding: 0;width:2%;"></td>
            <td style="overflow:hidden;width:45%;position:relative;padding: 0;border:1px solid #eaeaea;vertical-align: top;border-radius: 6px;height:640px;background: #fff;">
                <div class="group-wall-title">Dialogs</div>
                <div class="before-wall-content">
                    <div class="wall-content nano" style='height: 527px;'>
                        <!--                        --><?php
                        $comments=Comments::model()->findAllByAttributes(array("parent"=>0,"commented_user_id"=>Yii::app()->user->id),array('order'=>'time ASC'));
                        if($comments)
                        {
                            echo "<div class='wall nano-content' style='height: 527px;'>";
                            foreach($comments as $index=>$com)
                            {
                                echo $this->renderPartial("message",array("com"=>$com,'index'=>$index),true);
                            }
                            echo "</div>";
                        }
                        //                        ?>
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
                        })
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
                        echo CHtml::submitButton('Send',array('class'=>'','style'=>"height:40px;border:0;padding:0;background:url('../img/comment-send-button.png')no-repeat;width:72px;color:#fff"));
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