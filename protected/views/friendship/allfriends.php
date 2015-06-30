
            <div tabindex="0" class="friends-wall-content nano-content mar-zero native-scrollbar-hide" id="friends-list" style="display:none;">
              <?php foreach($friends as $fri) { ?>
              <div class="friend-container">
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l">
                      <?php echo Profile::model()->getLittleAvatar($fri->friend_id,'f-l friend-little-avatar') ?>
                  </a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                        <?php echo htmlspecialchars($fri->user->profile->firstname),' ',htmlspecialchars($fri->user->profile->lastname);?>
                    </div>
                    <div class="friend-job-title">
                        <?php echo Profile::model()->jobTitle($fri->friend_id)?>
                    </div>
                  </div>
                </div>
                
                <div class="friend-status action-imaga-m-r">
                    <div class="friends-write-message">
                    </div>    
                </div>

                <div class="friend-status">
                    <div class="remove-from-friends">
                    </div>    
                </div>

                <div class="clear"></div>

              </div>
                <?php } ?>
            </div>