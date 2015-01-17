<?php if($messages) { ?>
    <?php
    echo count($messages);
    foreach($messages as $mess)
    {
     ?>
        <?php if($current_user_id==$mess['from_id']) { ?>
        <table style="position: relative;overflow: hidden;margin-bottom: 0px; margin-top:25px;padding-right: 20px;">
            <tbody><tr>
                <td class="padding-zero wall-avatar-td">
                    <div class="wall-avatar">
                        <?php if($current_user_id==$mess['from_id']) { ?>
                            <img src="<?php echo $from_icon;?>"></div>
                        <?php } else { ?>
                            <img src="<?php echo $to_icon;?>"></div>
                        <?php } ?>
                </td>
                <td class="padding-zero">
                    <div class="message-buble">
                        <div class="message-buble-triangle"></div>
                        <div class="comment-owner">
                            <?php if($current_user_id==$mess['from_id']) { ?>
                                <?php echo $from_name;?>
                            <?php } else { ?>
                                <?php echo $to_name;?>
                            <?php } ?>
                        </div>
                        <div class="comment"><?php echo $mess['message'];?></div>
                    </div>
                </td>
            </tr>
            </tbody></table>
        <?php } else { ?>
        <table style="padding-right: 20px;">
            <tbody>
            <tr><td class="padding-zero wall-avatar-td">&nbsp;</td>
                <td class="padding-zero">
                    <div class="message-buble">
                        <div class="message-buble-triangle-back"></div>
                        <div class="comment-owner"><?php echo $to_name;?></div>
                        <div class="comment"><?php echo $mess['message'];?></div>
                    </div></td></tr>
            </tbody>
        </table>
        <?php }?>
    <?php
    }
    ?>
<?php } ?>