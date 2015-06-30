<link href="/css/nanoscroller.css" rel="stylesheet">
<link href="/css/friends-responsive.css" rel="stylesheet">
<script src="/js/jquery.nanoscroller.js"></script>
<script src="/js/jquery.mousewheel.js"></script>
<script>
  $(document).ready(function()
    {
      function initScrollPanes()
        {
          $(function()
            {
              $(".nano").nanoScroller({ scroll: 'bottom',flash: true  });
            });
        }
      setTimeout(initScrollPanes, 100);
    })
</script>

<script type="text/javascript">
  // Debug script to check "Friends list/All Users functionality."

  function showAllUsers() {
    if ($("#nav-users-all").hasClass("active")) return;

    $("#nav-friends-only").removeClass("active");
    $("#friends-list").hide();
    $("#nav-users-all").addClass("active");
    $("#all-list").show();

  };

  function showFriendsOnly() {
    if ($("#nav-friends-only").hasClass("active")) return;

    $("#nav-users-all").removeClass("active");
    $("#all-list").hide();
    $("#nav-friends-only").addClass("active");
    $("#friends-list").show();

    $(".nano").nanoScroller();

  };
</script>

<div class="main">
<div class="friends-page">
  <div class="f-l">
      <div class="f-l page-title">
        Friends
      </div>
      <div class="clear">
        <div class="friends-navigation" id="nav-friends-only" onclick="showFriendsOnly();">Friend List</div>
        <div class="friends-navigation active" id="nav-users-all" onclick="showAllUsers();">All Users</div>
      </div>
  </div>
  <div class="f-r blue-message-margin-b">
      <div class="blue-message">
          <div class="big">New Item</div>
          <div class="little">Available on market</div>
      </div>
  </div>
  <div class="clear"></div>
  <div class="content friends-content">
      <div class="friends-block-all">
        <div class="friends-block friends-all">
          <div class="friends-block-head">
            <form method="get" action="/search" id="search">
              <input name="q" type="text" size="40" placeholder="Search" />
            </form>
          </div>
          <div class="nano has-scrollbar friends-all-scrollbar-height">

<!-- USE THIS BLOCK FOR ALL USERS DISPLAY -->

             <div tabindex="0" class="friends-wall-content nano-content mar-zero native-scrollbar-hide" id="all-list">
              <?php foreach($allusers as $fr) { ?>
                  <div class="friend-container">

                      <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                          <a href='#' class="f-l">
                              <img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
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
<!-- END USE THIS BLOCK FOR ALL USERS DISPLAY -->

<!-- USE THIS BLOCK FOR FRIENDS DISPLAY -->
            <div tabindex="0" class="friends-wall-content nano-content mar-zero native-scrollbar-hide" id="friends-list" style="display:none;">

              <div class="friend-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Валерий Леоньтьев
                    </div>
                    <div class="friend-job-title">
                      Senior Xamarin Developer
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

              <div class="friend-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Валерий Леоньтьев
                    </div>
                    <div class="friend-job-title">
                      Senior Xamarin Developer
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

              <div class="friend-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Валерий Леоньтьев
                    </div>
                    <div class="friend-job-title">
                      Senior Xamarin Developer
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

              <div class="friend-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Валерий Леоньтьев
                    </div>
                    <div class="friend-job-title">
                      Senior Xamarin Developer
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

              <div class="friend-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Валерий Леоньтьев
                    </div>
                    <div class="friend-job-title">
                      Senior Xamarin Developer
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

              <div class="friend-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Валерий Леоньтьев
                    </div>
                    <div class="friend-job-title">
                      Senior Xamarin Developer
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
            
            </div>
<!-- END USE THIS BLOCK FOR FRIENDS DISPLAY -->

            <div class="nano-pane">
              <div style="height: 200px; transform: translate(0px, 0px);" class="nano-slider"></div>
            </div>

          </div>

<!-- DISPLAY THIS BLOCK INSTEAD OF PREVEOUS IF NOTHING TO SHOW -->
          <div class="empty-friends-list" style="display:none;">
            Nothing's here yet. :(
          </div>
<!-- END DISPLAY THIS BLOCK INSTEAD OF PREVEOUS IF NOTHING TO SHOW -->
        </div>
      </div>
      <div class="friends-pad"></div>
      <div class="friends-block-requests">
        <div class="friends-block friends-requests">
          
          <div class="friends-block-head">
            <div class="block-head-title">
              Requests
            </div>
          </div>

          <div class="nano has-scrollbar friends-requests-scrollbar-height">

            <div tabindex="0" class="friends-wall-content nano-content mar-zero native-scrollbar-hide">

              <div class="friend-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Валерий Леоньтьев
                    </div>
                    <div class="friend-job-title">
                      Senior Xamarin Developer
                    </div>
                  </div>
                </div>
                
                <div class="friend-status action-imaga-m-r">
                    <div class="friends-decline"></div>    
                </div>

                <div class="friend-status">
                    <div class="friends-commit"></div>    
                </div>

                <div class="clear"></div>

              </div>

              <div class="friend-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Валерий Леоньтьев
                    </div>
                    <div class="friend-job-title">
                      Senior Xamarin Developer
                    </div>
                  </div>
                </div>
                
                <div class="friend-status action-imaga-m-r">
                    <div class="friends-decline"></div>    
                </div>

                <div class="friend-status">
                    <div class="friends-commit"></div>    
                </div>

                <div class="clear"></div>

              </div>

              <div class="friend-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Валерий Леоньтьев
                    </div>
                    <div class="friend-job-title">
                      Senior Xamarin Developer
                    </div>
                  </div>
                </div>
                
                <div class="friend-status action-imaga-m-r">
                    <div class="friends-decline"></div>    
                </div>

                <div class="friend-status">
                    <div class="friends-commit"></div>    
                </div>

                <div class="clear"></div>

              </div>

              <div class="friend-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Валерий Леоньтьев
                    </div>
                    <div class="friend-job-title">
                      Senior Xamarin Developer
                    </div>
                  </div>
                </div>
                
                <div class="friend-status action-imaga-m-r">
                    <div class="friends-decline"></div>    
                </div>

                <div class="friend-status">
                    <div class="friends-commit"></div>    
                </div>

                <div class="clear"></div>

              </div>

            </div>

          </div>

<!-- DISPLAY THIS BLOCK INSTEAD OF PREVEOUS IF NO REQUESTS -->
          <div class="empty-requests" style="display:none;">
            There's no active requests.
          </div>
<!-- END DISPLAY THIS BLOCK INSTEAD OF PREVEOUS IF NO REQUESTS -->

        </div>
      </div>
      <div class="friends-block-recent">
        <div class="friends-block">
          <div class="friends-block-head">
            <div class="block-head-title">
              Recent
            </div>
          </div>
          <div class="recent-block-main">
          <div class="friend-container recent-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Тарас Бульба
                    </div>
                    <div class="friend-job-title">
                      Middle Product Designer
                    </div>
                  </div>
                </div>
                
                <div class="clear"></div>

            </div>

            <div class="friend-container recent-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Тарас Бульба
                    </div>
                    <div class="friend-job-title">
                      Middle Product Designer
                    </div>
                  </div>
                </div>
                
                <div class="clear"></div>

            </div>

            <div class="friend-container recent-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Генрик Михайлов
                    </div>
                    <div class="friend-job-title">
                      Junior Xamarin Developer
                    </div>
                  </div>
                </div>
                
                <div class="clear"></div>

              </div>

              <div class="friend-container recent-container">
                
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                  <a href='#' class="f-l"><img class='f-l friend-little-avatar' src='/img/default-user.png'/></a>
                  <div class='f-l'>
                    <div class="friend-fullname">
                      Генрик Михайлов
                    </div>
                    <div class="friend-job-title">
                      Junior Xamarin Developer
                    </div>
                  </div>
                </div>
                
                <div class="clear"></div>

              </div>

            </div>

<!-- DISPLAY THIS BLOCK INSTEAD OF PREVEOUS IF NO RECENT FRIENDS -->
            <div class="empty-recent" style="display:none;">
              There's no recent friends.
            </div>
<!-- END DISPLAY THIS BLOCK INSTEAD OF PREVEOUS IF NO RECENT FRIENDS -->

        </div>
      </div>

      <div class="friends-bottom-pad"></div>
  </div>
</div>
</div>
