
             <div tabindex="0" class="friends-wall-content nano-content mar-zero native-scrollbar-hide" id="all-list">
              <?php foreach($allusers as $fr) { ?>
                  <div class="friend-container">

                      <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                          <a href='#' class="f-l">
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
                      <?php if(count($fr->friends)>0) { ?>
                          <div class="friend-all-status">
                              <div class="in-friends">
                                  <div class="friends-request-sent-popup">
                                      <div class="friends-popup-header">YOUR FRIEND</div>
                                      <div class="friends-popup-message">This user is already your friend.</div>
                                  </div>
                              </div>
                          </div>
                      <?php } else if(in_array($fr->id,$curruserinviter)) {?>
                      <!-- if request sent-->
                      <div class="friend-all-status">
                          <div class="in-friends">
                              <div class="friends-request-sent-popup">
                                  <div class="friends-popup-header">Friends Request</div>
                                  <div class="friends-popup-message">You've already sent request to this user.</div>
                              </div>
                          </div>
                      </div>
                      <?php  } else if(in_array($fr->id,$currusernotinviter)){ ?>
                                <div class="friend-all-status">
                                    <div class="in-friends">
                                        <div class="friends-request-sent-popup">
                                            <div class="friends-popup-header">WAITING FOR CONFIRMATION</div>
                                            <div class="friends-popup-message">You already have the pending request from this user.</div>
                                        </div>
                                    </div>
                                </div>
                      <?php } else {?>
<!--                       if request is not send-->
                                <div class="friend-all-status">
                                    <div class="friends-commit"></div>
                                </div>
                      <?php } ?>
                      <div class="clear"></div>

                  </div>
              <?php } ?>

            </div>