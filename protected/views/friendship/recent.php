<?php if(count($friends)>0) { ?>
    <div class="recent-block-main">
        <?php foreach($friends as $index=>$fr) { ?>
            <?php if($index>3) break;?>
            <div class="friend-container recent-container">

                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                    <a href='<?= $this->createUrl('profile/view', ['id' => $fr->id]) ?>' class="f-l">
                        <?php echo Profile::model()->getLittleAvatar($fr->id,'f-l friend-little-avatar') ?>
                    </a>
                    <div class='f-l'>
                        <div class="friend-fullname">
                            <?php echo htmlspecialchars($fr->profile->firstname),' ',htmlspecialchars($fr->profile->lastname);?>
                        </div>
                        <div class="friend-job-title">
                            <?php echo Profile::model()->jobTitle($fr->id)?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>

            </div>
        <?php } ?>

    </div>
<?php } else { ?>
    <!-- DISPLAY THIS BLOCK INSTEAD OF PREVEOUS IF NO RECENT FRIENDS -->
    <div class="empty-recent">
        There's no recent friends.
    </div>
<?php } ?>