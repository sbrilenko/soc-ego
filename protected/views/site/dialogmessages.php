<?php if($messages) { ?>
    <?php
    foreach($messages as $mess)
    {
     ?>
        <?php if($current_user_id==$mess['to_id']) { ?>
        <table style="position: relative;overflow: hidden;margin-bottom: 25px; margin-top:25px;padding-right: 20px;">
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
                    <div class="message-buble <?php if($mess['read_status']==0 )echo 'not-read-message-st';?>">
                        <div class="message-buble-triangle <?php if($mess['read_status']==0 )echo 'not-read-message-st-triangle';?>"></div>
                        <div class="comment-owner f-l">
                            <?php if($current_user_id==$mess['from_id']) { ?>
                                <?php echo $from_name;?>
                            <?php } else { ?>
                                <?php echo $to_name;?>
                            <?php } ?>
                        </div>
                        <div class="f-r"><?php echo $mess['date'];?></div>
                        <div class="clear"></div>
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
                    <div class="message-buble <?php if($mess['read_status']==0 )echo 'not-read-message-st';?>">
                        <div class="message-buble-triangle-back <?php if($mess['read_status']==0 )echo 'not-read-message-st-triangle-back';?>"></div>
                        <div class="comment-owner f-l"><?php echo $from_name;?></div><div class="f-r"><?php echo $mess['date'];?></div>
                        <div class="clear"></div>
                        <div class="comment"><?php echo $mess['message'];?></div>
                    </div></td></tr>
            </tbody>
        </table>
        <?php }?>
    <?php
    }
    ?>
<?php } ?>
<script>
    $(document).ready(function()
    {
        setTimeout(function()
        {
            $('.messages-dialog-block .not-read-message-st').each(function()
            {
                var th=$(this),tri=th.find('.message-buble-triangle'),triback=th.find('.message-buble-triangle-back');

                th.animate({backgroundColor: '#f8f8f8'}, 'slow',function(){
                    th.removeClass('not-read-message-st');
              });
                tri.animate({borderRightColor: '#f8f8f8'}, 'slow',function(){
                    tri.removeClass('not-read-message-st-triangle');
                });
                triback.animate({borderRightColor: '#f8f8f8'}, 'slow',function(){
                    triback.removeClass('not-read-message-st-triangle-back');
                });
            })
        },2000)
    })
</script>