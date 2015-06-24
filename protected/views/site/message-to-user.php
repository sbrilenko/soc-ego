<?php if($message) { ?>
	<table style="padding-right: 30px; margin-top:25px; margin-bottom:25px;">
            <tbody>
            <tr><td class="padding-zero wall-avatar-td">&nbsp;</td>
                <td class="padding-zero" style="padding-left: 10%;">
                    <div class="message-buble">
                        <div class="message-buble-triangle-back"></div>
                        <div class="comment-owner f-l" style="font-size: 16px; font-weight: 500;"><?php echo $sender_name;?></div>
                        <div class="f-r" style="color: #959595; font-size: 12px;"><?php echo date('H:i', $message['timestamp']);?></div>
                        <div class="clear"></div>
                        <?php if($image) { ?>
                        <div class="comment"><img style="margin: 10px auto;" height="100" width="100" src="<?php echo $image; ?>"></div>
                       	<?php }?>
                        <div class="comment"><?php echo $message['message'];?></div>
                    </div></td></tr>
            </tbody>
    </table>
<?php } ?>