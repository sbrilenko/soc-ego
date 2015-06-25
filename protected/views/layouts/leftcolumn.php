    <div style="overflow: visible;padding: 0">
        <div class="left-column">
        <div id="header" class="header-top left-column">
            <div id="logo"><a href="/"></a></div>
        </div>
            <div class='avatar'>
<!--                <div class="avatar-back"></div>-->
            <?php
                echo Profile::model()->getLittleAvatar(Yii::app()->user->id);
                ?>
                <?php if(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id!="index") {?>
                <div class="avatar-position">
                    <div class="avatar-name-style">
                        <?php
                        if(isset(Yii::app()->user->id))
                        {
                            $user=Profile::model()->findByAttributes(array("user_id"=>Yii::app()->user->id));
                            echo $user->firstname," ",$user->lastname;
                        }
                        ?>
                    </div>
                    <div class="avatar-type-style"><?php echo User::model()->findByPk(Yii::app()->user->id)->job_title;?></div>
                    <div class="avatar-levelstarsprogress">
                    <?php
                    if(User::model()->findByPk(Yii::app()->user->id)->level==0)
                    {
                        ?>
                        <div class="avatar-levelstars active"></div>
                        <div class="avatar-levelstars padd"></div>
                        <div class="avatar-levelstars"></div>
                    <?php
                    }elseif(User::model()->findByPk(Yii::app()->user->id)->level==1)
                    {
                        ?>
                        <div class="avatar-levelstars active"></div>
                        <div class="avatar-levelstars active padd"></div>
                        <div class="avatar-levelstars"></div>
                    <?php
                    }elseif(User::model()->findByPk(Yii::app()->user->id)->level==2)
                    {
                        ?>
                        <div class="avatar-levelstars active"></div>
                        <div class="avatar-levelstars active padd"></div>
                        <div class="avatar-levelstars active"></div>
                    <?php
                    }
                    ?>
                    </div>
                </div>
                <?php } ?>

            </div>
                <div class="day-count">
                    <?php
                    if(Yii::app()->user->id)
                    {
                        $user=User::model()->findByPk(Yii::app()->user->id);
                        if($user && !is_null($user->day_count))
                        {
                            $date1 = new DateTime(date("Y-m-d H:i:s"));
                            $date2 = new DateTime(date("Y-m-d H:i:s",$user->day_count));
                            $y = $date2->diff($date1)->format("%y");
                            $m = $date2->diff($date1)->format("%m");
                            $d = $date2->diff($date1)->format("%d");
                            $h = $date2->diff($date1)->format("%h");
                            echo "<table class='day-count-table'><tr>";
                            echo "<td><span class='big'>".(int)$y."</span><br /><span class='little'>YEARS</span></td><td><span class='big'>".(int)$m."</span><br /><span class='little'>MONTH</span></td><td><span class='big'>".(int)$d."</span><br /><span class='little'>DAYS</span></td><td><span class='big'>".$h."</span><br /><span class='little'>HOURS</span></td>";
                            echo "</tr></table>";
                        }
                    }
                    ?>
                </div>
            <?php if(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="index") {?>
            <div class="friends">
              <div>
                    <?php $friends = $user->friends; ?>
                    <div class="friends-title-count">
                      <div class="friends-title-count-text"><?php echo count($friends); ?></div>
                    </div>
                    <div class="friends-title" href="/friends">Friends</div>
                  </div>
                  <div class="clear"></div>
                  <ul class="friends-list">
                    <li>
                      <table class="friends-list-table">
                        <tbody>
                          <?php foreach($friends as $friend): ?>
                          <tr>
                            <td class="width">
                              <a href="/user/show/<?php echo $friend->user->id; ?>"><img style="width:57px; border-radius:50px" title="<?php echo $friend->user->profile->firstname . ' ' . $friend->user->profile->lastname?>" src="<?php echo $friend->user->profile->getAvatarUrl(); ?>"></a>
                            </td>
                            <td>
                              <a style="text-decoration:none;" href="/user/show/<?php echo $friend->user->id; ?>"><div class="friends-name"><?php echo $friend->user->profile->firstname . ' ' . $friend->user->profile->lastname; ?></div></a>
                              <div class="friends-position"><?php echo $friend->user->job_title; ?></div>
                            </td>
                          </tr>
                         <?php endforeach; ?>
                        </tbody>
                      </table>
                    </li>
                  </ul>                
                </div>
                <a href="/friends"><div class="add-friends-button"></div></a>
                <div class="friends">
                    <?php
                    if(true)
                    {
                        $user_badge=BadgeUser::model()->findAllByAttributes(array("user_id"=>Yii::app()->user->id));
                        if($user_badge)
                        {
                            $frie_count_class="friends-title-count-text";
                            $frie_count=count($user_badge);
                            if($frie_count>10)
                                $frie_count_class="friends-title-count-text-more";
                            echo "<div><div class='friends-title-count'><div class='".$frie_count_class."'>".$frie_count."</div></div><div class='friends-title' href='/friends'>Badges</div></div><div class='clear'></div>";
                            echo "<ul class='badges-list'>";
                            foreach($user_badge as $index=>$badge)
                            {
                                if($index%4==0) echo "<li class='first'>";
                                elseif($index%4==3) echo "<li class='last'>";
                                else echo "<li class='middle'>";
                                $badge_id=Badges::model()->findByPk($badge->badge_id);
                                if($badge_id)
                                {
                                    $badge_image=Files::model()->findByPk($badge_id->image);

                                    if($badge_image)
                                    {
                                        if(file_exists(Yii::app()->basePath."/../files/".$badge_image->image))
                                        {
//                                            $name_in_db=str_replace('.png','',$badge_image->image);
                                            echo "<img title='".$badge_id->title."' src='/files/".$badge_image->image."'/>";
                                        }
                                        else
                                        {
                                            echo "<img title='".$badge_id->title."' src='/img/default-badges-mini.png"."'/>";
                                        }
                                    }
                                }
                                echo "</li>";
                            }
                            echo "</ul>";

                            echo "<div class='clear'></div>";

                        }
                    }
                    ?>

                </div>
            <?php } elseif(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="messages") { ?>
                <div class="friends">
                    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
                    <script>
                        Object.size = function(obj) {
                            var size = 0, key;
                            for (key in obj) {
                                if (obj.hasOwnProperty(key)) size++;
                            }
                            return size;
                        };

                       $(document).ready(function()
                        {
                            autocomplite_array=[];
                            $( "#message-to-user input[name=user]" ).autocomplete({
                                minLength: 0,
                                source: function( request, response ) {
                                    var arr=$('#message-to-user').serializeArray();
                                    $.ajax({
                                        url: "getAllFriends",
                                        data: arr,
                                        type:'post',
                                        dataType: "json",
                                        success: function( data ) {
//                                            data=$.parseJSON(data)
                                            console.log(data.data)
                                            response(data.data)
                                        }
                                    });
                                },
                                focus: function( event, ui ) {
                                    //$( "#project" ).val( ui.item.label );
                                    return false;
                                },
                                select: function( event, ui ) {
                                    $(this).val(ui.item.value)
                                    $('form[id=message-to-user]').find('input[name=to_user]').val(ui.item.id);
                                    $('.quick-message-user-icon').empty().append('<img src="'+ui.item.icon+'" title="'+ui.item.value+'">')

                                    return false;
                                },
                                open: function() {
                                    $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                                },
                                close: function() {
                                    autocomplite_array=[];
                                    $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                                }
                            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                                ul.addClass('quickmessage-autocomplete-ul');
                                console.log(ul, item )
                                console.log($(this))
                                return $( "<li>" )
                                    .append( "<a><div class='f-l'><img class='autocomplete-li-icon' src='"+item.icon+"' /></div><div class='f-l autocomplete-li-margin-l'><div class='autocomplete-name'>" + item.label + "</div><div class='autocomplete-position'>" + item.position + "</div></div><div class='clear'></div></a>" )
                                    .appendTo( ul );
                            };
                            $(document).on('submit','#message-to-user',function()
                            {
                                var arr=$(this).serializeArray();
                                var msg = {
                                    type: 'system.quickmessage',
                                    data: arr
                                };
                                console.log(msg);
                                try{ websocket.send(JSON.stringify(msg));console.log('send')}
                                catch(ex){
                                    console.log(ex.data);
                                    return false}

                                /*console.log(arr)
                                $.ajax({
                                    url: "sendQuickMessage",
                                    data: arr,
                                    type:'post',
                                    dataType: "json",
                                    success: function( data ) {
                                        console.log(data)
                                        if(data.error)
                                        {
                                           console.log(data.message)
                                        }
                                        else
                                        {
                                            $('#message-to-user input[name=to_user],#message-to-user input[name=user],#message-to-user textarea').val('')
                                            $('.quick-message-user-icon').empty();
                                        }
                                    }
                                });*/
                                return false
                            })
                        })
                    </script>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id'=>'message-to-user',
                    'enableAjaxValidation'=>true,
                    'enableClientValidation'=>true,
                ));
                ?>
                <div class="friends-search-bar">
                    <?php echo Chtml::textField('user');?>
                    <?php echo Chtml::hiddenField('to_user');?>
                    <?php echo Chtml::hiddenField('from_user',Yii::app()->user->id);?>
                </div>
                <div class="friends-text">
                    <?php echo Chtml::textArea('text');?>
                </div>
                <div class="message-to-user-sub-m f-l quick-message-user-icon"></div>
                    <div class="message-to-user-sub-m f-r">
                        <?php echo Chtml::submitButton('Send',array('class'=>'message-to-user'));?>
                    </div>
                    <div class="clear"></div>
                <?php $this->endWidget(); ?>
                </div>

            <?php }  ?>
        </div>
    </div>
