<link href="/css/nanoscroller.css" rel="stylesheet">
<link href="/css/friends-responsive.css" rel="stylesheet">
<script src="/js/jquery.nanoscroller.js"></script>
<script src="/js/jquery.mousewheel.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script>
  $(document).ready(function()
    {
        var ajaxdata=function(data,tabnumber)
        {
            var alllist=$('#all-list'),
                friendslist=$('#friends-list');
            var ajaxurl='/Friendship/GetAllUsersByName';
            ajaxurl=tabnumber==0?'/Friendship/GetAllUsersByName':'/Friendship/GetAllFriendsByName';
            $.ajax({
                url:ajaxurl,
                type:'post',
                data:data,
                dataType:'json',
                success: function(data){
                    $('#search input[name=q]').removeClass('ui-autocomplete-loading');
                    if(alllist.is(':visible'))
                    {
                        alllist.replaceWith(data.allusershtml)
                    }
                    else
                    {
                        friendslist.empty().append(data.allfriendshtml)
                    }
                }
            });
        }
        function showAllUsers() {
            $('#search input[name=q]').val('');
            ajaxdata($('#search').serializeArray(),0);
            if ($("#nav-users-all").hasClass("active")) return;

            $("#nav-friends-only").removeClass("active");
            $("#friends-list").hide();
            $("#nav-users-all").addClass("active");
            $("#all-list").show();

        };

        function showFriendsOnly() {
            $('#search input[name=q]').val('');
            var formd=$('#search').serializeArray()
            ajaxdata(formd,1);
            if ($("#nav-friends-only").hasClass("active")) return;

            $("#nav-users-all").removeClass("active");
            $("#all-list").hide();
            $("#nav-friends-only").addClass("active");
            $("#friends-list").show();

            $(".nano").nanoScroller();

        };
        $(document).on('click','#nav-friends-only',function(){
            showFriendsOnly()
        });
        $(document).on('click','#nav-users-all',function()
        {
            showAllUsers();
        });


        $('#search input[name=q]').autocomplete({
            search  : function(){$(this).addClass('ui-autocomplete-loading');},
            open    : function(){$(this).removeClass('ui-autocomplete-loading');},
            source: function(request, response){
                var searchword=$('#search input[name=q]').val().toLowerCase().trim();
                var formdata=$('#search').serializeArray();
                if(searchword.length<3)
                {
                    for(datarow in formdata)
                    {
                        if(formdata[datarow].name=='q') formdata[datarow].value=='';
                    }
                }
                var alllist=$('#all-list');
                alllist.is(':visible')?ajaxdata(formdata,0):ajaxdata(formdata,1);
            },
            select: function( event, ui ) {
                return false;
            }
        });

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

<div class="main">
<div class="friends-page">
  <div class="f-l">
      <div class="f-l page-title">
        Friends
      </div>
      <div class="clear">
        <div class="friends-navigation" id="nav-friends-only">Friend List</div>
        <div class="friends-navigation active" id="nav-users-all">All Users</div>
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
              <?php
              $form = $this->beginWidget('CActiveForm', array(
                  'id'=>'search',
                  'enableAjaxValidation'=>true,
                  'enableClientValidation'=>true,
                  'htmlOptions' => array('enctype' => 'multipart/form-data',"class"=>"addcomments-form")
              ));
              ?>
              <input name="q" type="text" size="40" placeholder="Search" />
              <?php $this->endWidget(); ?>
          </div>
          <div class="nano has-scrollbar friends-all-scrollbar-height">

<!-- USE THIS BLOCK FOR ALL USERS DISPLAY -->

             <?php echo $allusershtml;?>
<!-- END USE THIS BLOCK FOR ALL USERS DISPLAY -->

<!-- USE THIS BLOCK FOR FRIENDS DISPLAY -->
              <div tabindex="0" class="friends-wall-content nano-content mar-zero native-scrollbar-hide" id="friends-list" style="display:none;">
              <?php echo $allfriendshtml;?>
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
          <?php if(count($friendrequest)>0) { ?>
          <div class="nano has-scrollbar friends-requests-scrollbar-height">

            <div tabindex="0" class="friends-wall-content nano-content mar-zero native-scrollbar-hide">

                <?php foreach($friendrequest as $request) {?>
                    <div class="friend-container">

                        <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                            <a href='#' class="f-l">
                                <?php echo Profile::model()->getLittleAvatar($request->id,'f-l friend-little-avatar') ?>
                            </a>
                            <div class='f-l'>
                                <div class="friend-fullname">
                                    <?php echo htmlspecialchars($request->profile->firstname),' ',htmlspecialchars($request->profile->lastname);?>
                                </div>
                                <div class="friend-job-title">
                                    <?php echo Profile::model()->jobTitle($request->id)?>
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
                <?php } ?>

            </div>

          </div>
            <?php } else { ?>
<!-- DISPLAY THIS BLOCK INSTEAD OF PREVEOUS IF NO REQUESTS -->
          <div class="empty-requests">
            There's no active requests.
          </div>
          <?php } ?>
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
          <?php if(count($friends)>0) { ?>
          <div class="recent-block-main">
              <?php foreach($friends as $index=>$fr) { ?>
                  <?php if($index>3) break;?>
                  <div class="friend-container recent-container">

                      <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                          <a href='#' class="f-l">
                              <?php echo Profile::model()->getLittleAvatar($fr->user->id,'f-l friend-little-avatar') ?>
                          </a>
                          <div class='f-l'>
                              <div class="friend-fullname">
                                  <?php echo htmlspecialchars($fr->user->profile->firstname),' ',htmlspecialchars($fr->user->profile->lastname);?>
                              </div>
                              <div class="friend-job-title">
                                  <?php echo Profile::model()->jobTitle($fr->user->id)?>
                              </div>
                          </div>
                      </div>

                      <div class="clear"></div>

                  </div>
              <?php } ?>

            </div>
            <?php } else { ?>
<!-- DISPLAY THIS BLOCK INSTEAD OF PREVEOUS IF NO RECENT FRIENDS -->
            <div class="empty-recent" >
              There's no recent friends.
            </div>
            <?php } ?>
<!-- END DISPLAY THIS BLOCK INSTEAD OF PREVEOUS IF NO RECENT FRIENDS -->

        </div>
      </div>

      <div class="friends-bottom-pad"></div>
  </div>
</div>
</div>
