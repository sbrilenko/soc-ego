<table style="padding-right: 20px;position: relative;overflow: hidden;<?php if($index>-1) echo "margin-bottom: 0px;" ?> <?php if($index==0) echo 'margin-top:25px;';?>">
    <tr>
        <td class="padding-zero wall-avatar-td">
                    <?php if($com->parent==0) {
                        if(Yii::app()->user->id)
                        {
                            $avatar_id=Profile::model()->findByAttributes(array("user_id"=>$com->commented_user_id));
                            if($avatar_id)
                            {
                                $file_avatar=Files::model()->findByPk($avatar_id->avatar);
                                if($file_avatar)
                                {
                                    if(file_exists(Yii::app()->basePath."/../files/".$file_avatar->image))
                                    {
                                        echo "<div class='wall-avatar'><img src='/files/".$file_avatar->image."'/></div>";
                                    }
                                    else
                                    {
                                        echo "<div class='wall-avatar'><img src='/img/default-user.png'/></div>";
                                    }
                                }
                                else
                                {
                                    echo "<div class='wall-avatar'><img src='/img/default-user.png'/></div>";
                                }
                            }
                            else
                            {
                                echo "<div class='wall-avatar'><img src='/img/default-user.png'/></div>";
                            }
                        }
                     }?>
                </td>
        <td class="padding-zero">
            <div class="message-buble">
                <div class="message-buble-triangle"></div>
                        <div class="comment-owner"><?php echo htmlspecialchars(Profile::model()->findByAttributes(array("user_id"=>$com->create_user_id))->firstname." ".Profile::model()->findByAttributes(array("user_id"=>$com->create_user_id))->lastname);?></div>
                        <div class="comment"><?php echo addslashes($com->text);?></div>
                    <?php if(!empty($com->image))
                    {
                        $comm_image=Files::model()->findByPk($com->image);
                        if($comm_image)
                        {
                            if(file_exists(Yii::app()->basePath."/../files/".$comm_image->image))
                            {
                            ?>
                        <div class='text-center wall-comm-img'><img src='/files/<?php echo $comm_image->image; ?>'/></div>
                    <?php
                                }
                        }
                    }
                    ?>
            </div>
                <div class="like-time-padding f-r">
                    <span class="time">
                    <?php
                        echo date("d",$com->time),".",date("m",$com->time),".",date("Y",$com->time)," ",date("H",$com->time),":",date("i",$com->time)," | ";
                    ?>
                    </span><span title="Like" class="like-icon">0
                        <div style="display: none;">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id'=>'comments-form-'.uniqid(),
                            'enableAjaxValidation'=>true,
                            'enableClientValidation'=>true,
                            'htmlOptions'=>array('class'=>'like-form')
                        ));
                        ?>
                        <?php echo $form->hiddenField($com,'id');?>
                        <?php $this->endWidget(); ?>
                        </div>
                    </span>
                </div>
        </td>
    </tr>
</table>
<?php
    $child_comm=Comments::model()->findAllByAttributes(array("commented_user_id"=>Yii::app()->user->id,"parent"=>$com->id));
    if($child_comm)
    {
        foreach($child_comm as $index=>$children)
        {
            if(count($child_comm)>3 && $index>3) break;
            echo "<table style='padding-right: 20px;'>";
            echo "<tr>";
            echo '<td class="padding-zero wall-avatar-td">&nbsp;</td>';
            echo "<td class='padding-zero'>";
    echo '<div class="message-buble">
        <div class="message-buble-triangle-back"></div>
        <div class="comment-owner">'.htmlspecialchars(Profile::model()->findByAttributes(array("user_id"=>$com->create_user_id))->firstname." ".Profile::model()->findByAttributes(array("user_id"=>$com->create_user_id))->lastname).'</div>
    <div class="comment">'.addslashes($children->text).'</div>
    </div>';
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        }
    }
?>
<?php
    echo "<table style='padding-right: 20px;'>";
    echo "<tr>";
    echo '<td class="padding-zero wall-avatar-td">&nbsp;</td>';
    echo "<td class='padding-zero'>";
    $new_comment_comment=new Comments();
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'addcomment-comment-'.uniqid(),
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'htmlOptions' => array("class"=>"comment-comment-form")
    ));
    echo "<div>";
    echo $form->hiddenField($new_comment_comment,'create_user_id',array("value"=>Yii::app()->user->id));
    echo $form->hiddenField($new_comment_comment,'parent',array("value"=>$com->id));
    echo $form->textField($new_comment_comment,'text',array("placeholder"=>"Comment..."));
    echo "</div>";
    $this->endWidget();
    echo "</td>";
    echo "</tr>";
    echo "</table>";

?>

<!--</div>-->

