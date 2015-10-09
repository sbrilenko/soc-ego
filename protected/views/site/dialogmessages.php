<?php if($messages) { ?>
    <?php $current_date = 0; ?>
    <?php
    foreach($messages as $index=>$mess)
    {
     ?>
    <?php if($current_date !== date('d M y', $mess['date'])) { ?>
        <div style="width:100%; margin:0 auto; text-align: center; color: #959595;<?php if($current_date == 0) echo 'margin-top: 25px;';?>">
            <?php echo date('d M y', $mess['date']); ?>
        </div>
        <?php $current_date = date('d M y', $mess['date']); ?>
    <?php } ?>
        <?php if($current_user_id==$mess['to_id']) { ?>
        <table style="position: relative;overflow: hidden;margin-bottom: 25px; margin-top:25px;padding-right: 30px;">
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
                        <div class="comment-owner f-l" style="font-size: 16px; font-weight: 500;">
                            <?php if($current_user_id==$mess['from_id']) { ?>
                                <?php echo $from_name;?>
                            <?php } else { ?>
                                <?php echo $to_name;?>
                            <?php } ?>
                        </div>
                        <div class="f-r" style="color: #959595; font-size: 12px;"><?php echo date('H:i', $mess['date']);?></div>
                        <div class="clear"></div>
                        <?php if($mess['image']) { ?>
                        <div class="comment"><a href="<?php echo $mess['image']; ?>" target="_blank"><img style="margin: 10px auto;" height="100" width="100" src="<?php echo $mess['image']; ?>"></a></div>
                        <?php }?>
                        <div class="comment"><?php echo $mess['message'];?></div>
                    </div>
                </td>
            </tr>
            </tbody></table>
        <?php } else { ?>
        <table style="padding-right: 30px; margin-top:25px; margin-bottom:25px; <?php if($index==0) echo 'margin-top: 1.4em;';?>">
            <tbody>
            <tr><td class="padding-zero wall-avatar-td">&nbsp;</td>
                <td class="padding-zero" style="padding-left: 10%;">
                    <div class="message-buble">
                        <div class="message-buble-triangle-back"></div>
                        <div class="comment-owner f-l" style="font-size: 16px; font-weight: 500;"><?php echo $from_name;?></div>
                        <div class="f-r" style="color: #959595; font-size: 12px;"><?php echo date('H:i', $mess['date']);?></div>
                        <div class="clear"></div>
                        <?php if($mess['image']) { ?>
                        <div class="comment"><a href="<?php echo $mess['image']; ?>" target="_blank"><img style="margin: 10px auto;" height="100" width="100" src="<?php echo $mess['image']; ?>"></a></div>
                        <?php }?>
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