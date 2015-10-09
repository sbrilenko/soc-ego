<?php if($message) { ?>

	<table style="position: relative;overflow: hidden;margin-bottom: 25px; margin-top:25px;padding-right: 30px;">
            <tbody><tr>
                <td class="padding-zero wall-avatar-td">
                    <div class="wall-avatar">
                        <img src="<?php echo $sender_avatar;?>">
                    </div>
                </td>
                <td class="padding-zero">
                    <div class="message-buble">
                        <div class="message-buble-triangle"></div>
                        <div class="comment-owner f-l" style="font-size: 16px; font-weight: 500;">
                            <?php echo $sender_name;?>
                        </div>
                        <div class="f-r" style="color: #959595; font-size: 12px;"><?php echo date('H:i', $message['timestamp']);?></div>
                        <div class="clear"></div>
                        <?php if($image) { ?>
                        <div class="comment"><a href="<?php echo $image; ?>" target="_blank"><img style="margin: 10px auto;" height="100" width="100" src="<?php echo $image; ?>"></a></div>
                       	<?php }?>
                        <div class="comment"><?php echo $message['message'];?></div>
                    </div>
                </td>
            </tr>
            </tbody>
    </table>

<?php }?>