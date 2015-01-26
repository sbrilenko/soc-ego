
<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
    <?php if(isset(Yii::app()->user->id)) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/site.css">
    <?php } else { ?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css">
    <?php } ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <?php if(isset(Yii::app()->user->id) && Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="index") { ?>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/nanoscroller.css" rel="stylesheet">
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.nanoscroller.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mousewheel.js"></script>

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
    <?php }?>
    <?php if(isset(Yii::app()->user->id)) { ?>
    <script>
        if (!window.WebSocket) {
            //window.location.reload();
        } else {
            //create a new WebSocket object.
            var wsUri = "ws://"+document.location.hostname+":1600";
//            var wsUri = "ws://0.0.0.0:1500";
            websocket = new WebSocket(wsUri);

            // ----------------------------------------------------
            websocket.onopen = function(ev) { // connection is open
                var msg = {
                    type: 'system.init_user_online',
                    from_user_id: <?php echo Yii::app()->user->id; ?>
                };
                console.log(msg);
                try{ websocket.send(JSON.stringify(msg));console.log('send')}
                catch(ex){
                    console.log(ex.data);
                    return false}
            };
            //Connection close
            websocket.onclose = function(ev) {

                console.log('Disconnected',ev)
            };

            //Message Receved
            websocket.onmessage = function(ev) {
                console.log('Message ',ev)
                var msg = JSON.parse(ev.data); //PHP sends Json data
                console.log(msg)
                var type = msg.type; //message type
                switch (type) {
                    case 'system.message':

                        if(msg.to==<?php echo Yii::app()->user->id;?>)
                        {
                            if(!msg.error)
                            {
                                //if page not messages
                                $('.top-menu .messages-icon').next().text(msg.count).show();
                                <?php if(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="messages") { ?>
                                /*setTimeout(function(){
                                 $('.top-menu .messages-icon').next().fadeOut(function(){ $(this).text('');})
                                 },2000)*/
                                <?php } ?>

                            }

                        }
                        else
                        if(msg.from==<?php echo Yii::app()->user->id;?>)
                        {
                            if(!msg.error)
                            {
                                <?php if(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="messages") { ?>
                                var mess="";
                                mess+='<table style="padding-right: 20px;"><tbody><tr><td class="padding-zero wall-avatar-td">&nbsp;</td>';
                                mess+='<td class="padding-zero">';
                                mess+='<div class="message-buble">';
                                mess+='<div class="message-buble-triangle-back"></div>';
                                mess+='<div class="comment-owner f-l">'+msg.from_name+'</div><div class="f-r">'+msg.date+'</div>';
                                mess+='<div class="clear"></div>';
                                mess+='<div class="comment">'+msg.message+'</div>';
                                mess+='</div></td></tr></tbody></table>';
                                $('.dialog-messages').append(mess);
                                setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                                //clear the form
                                $('#newmessage-send-form input[name*=message]').val('');
                                <?php } ?>
                            }
                        }
                        break;
                    case 'system.quickmessage':
                        if(msg.to==<?php echo Yii::app()->user->id;?>)
                        {
                            if(!msg.error)
                            {
                                //if page not messages
                                $('.top-menu .messages-icon').next().text(msg.count).show();
                                <?php if(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="messages") { ?>
                                /*setTimeout(function(){
                                    $('.top-menu .messages-icon').next().fadeOut(function(){ $(this).text('');})
                                },2000)*/
                                <?php } ?>
                                $('.get-message').each(function()
                                {
                                    var form=$(this).find('form');
                                    if(form.find('input[name*=from_user_id]').val()==msg.from || form.find('input[name*=to_user_id]').val()==msg.from)
                                    {

                                        $('.message-block-user-time',this).text(msg.date)
                                        $('.message-block-user-message',this).text(msg.message)
                                        $('.message-new-message').text(msg.count).show()
                                    }
                                })
                            }

                        }
                        else
                        if(msg.from==<?php echo Yii::app()->user->id;?>)
                        {
                            if(!msg.error)
                            {
                                <?php if(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="messages") { ?>
                                //clear quickmessage form
                                $('#message-to-user input[name=to_user],#message-to-user textarea,#message-to-user input[name=user]').val('');
                                $('.quick-message-user-icon').empty();
                                $('.get-message').each(function()
                                {
                                    var form=$(this).find('form');
                                    if(form.find('input[name*=from_user_id]').val()==msg.from || form.find('input[name*=to_user_id]').val()==msg.from)
                                    {
                                        $('.message-block-user-time',this).text(msg.date)
                                        $('.message-block-user-message',this).text(msg.message)
                                    }
                                })
                                <?php } ?>
                            }
                        }
                    break;
                }
            };

            //Error
            websocket.onerror = function(ev) {
                console.log('Error ',ev)
            };
        }
        $(document).ready(function()
        {
            $(document).on('click','.tri',function()
            {

            }).on('click',function(el)
            {
                $(el.target).hasClass("triangle")?$('.triangle-menu').is(":visible")?$('.triangle-menu').removeAttr("style"):$('.triangle-menu').show():$('.triangle-menu').removeAttr("style");
            }).on('keydown',function(el)
            {
                if(el.keyCode==27)
                {
                    $('.triangle-menu').removeAttr("style");
                }
            })
                $('.left-columb-icon').parent().on('click',function()
                {
                    if(!$(".left-column").hasClass("close") && !$(".left-column").is(":animated"))
                    {
                        $(".left-column").animate({width:0,maxWidth:0,minWidth:0},500,function(){$(".left-column").addClass("close")})
                    }
                    else
                    {
                        $(".left-column").animate({width:314,maxWidth:314,minWidth:314},500,function(){$(".left-column").removeClass("close")})
                    }
                })
        })
    </script>
    <?php } ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body <?php if(!isset(Yii::app()->user->id)) echo "style='background:#393939;'"; ?>>
    <?php
    if(isset(Yii::app()->user->id))
    {
    ?>
    <div class="main-content header-top">
        <div class="left-column">
            <div id="header" class="header-top left-column">
                <div id="logo"><a href="/"></a></div>
            </div><!-- header -->
        </div>
        <?php require_once "header.php";?>
<!--        <div style="position: relative;display: table-cell;">-->
<!--            <div class="header-shadow"></div>-->
<!--        </div>-->

    </div>
    <div class="main-content" style="overflow: visible;padding: 0">
        <div class="left-column">
            <div class='avatar-container'>
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
                    <?php

                    if(true)
                    {
                        $user_friends=Friendship::model()->findAllBySql("select * from friendship where (inviter_id=:inviter_id OR friend_id=:friend_id) AND status=1 ORDER BY updatetime", array(':inviter_id'=>Yii::app()->user->id,':friend_id'=>Yii::app()->user->id));
                        if($user_friends)
                        {
                            $frie_count_class="friends-title-count-text";
                            $frie_count=count($user_friends);
                            if($frie_count>10)
                                $frie_count_class="friends-title-count-text-more";
                            echo "<div><div class='friends-title-count'><div class='".$frie_count_class."'>".$frie_count."</div></div><div class='friends-title' href='/friends'>Friends</div></div><div class='clear'></div>";
                            echo "<ul class='friends-list'>";
                            foreach($user_friends as $friend)
                            {
                                echo "<li>";
                                if($friend->inviter_id==Yii::app()->user->id)
                                {
                                    $profile_user=Profile::model()->findByPk($friend->friend_id);
                                    if($profile_user && !is_null($profile_user->avatar) && $profile_user->avatar>0)
                                    {
                                        echo "<table class='friends-list-table'>";
                                        $avatar_image=Files::model()->findByPk($profile_user->avatar);
                                        if($avatar_image)
                                        {
                                            if(file_exists(Yii::app()->basePath."/../files/".$avatar_image->image))
                                            {
                                                $name_in_db=str_replace('.jpg','',$avatar_image->image);
                                                echo "<tr><td class='width'><a href='/user?id=$profile_user->id'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/files/".$name_in_db."_little.jpg"."'/></a></td>";
                                                echo "<td><div class='friends-name'>".$profile_user->firstname." ".$profile_user->lastname."</div><div class='friends-position'>".User::model()->findByPk($profile_user->user_id)->job_type."</div></td></tr>";
                                            }
                                            else
                                            {
                                                echo "<tr><td class='width'><a href='/user?id=$profile_user->id'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/img/default-user-mini.png'/></a></td>";
                                                echo "<td><div class='friends-name'>".$profile_user->firstname." ".$profile_user->lastname."</div><div class='friends-position'>".User::model()->findByPk($profile_user->user_id)->job_type."</div></td></tr>";
                                            }
                                        }
                                        else
                                        {
                                            echo "<tr><td class='width'><a href='/user?id=$profile_user->id'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/img/default-user-mini.png'/></a></td>";
                                            echo "<td><div class='friends-name'>".$profile_user->firstname." ".$profile_user->lastname."</div><div class='friends-position'>".User::model()->findByPk($profile_user->user_id)->job_type."</div></td></tr>";
                                        }
                                        echo "</table>";
                                    }
                                }
                                else
                                {
                                    $profile_user=Profile::model()->findByPk($friend->inviter_id);
                                    if($profile_user && !is_null($profile_user->avatar) && $profile_user->avatar>0)
                                    {
                                        echo "<table class='friends-list-table'>";
                                        $avatar_image=Files::model()->findByPk($profile_user->avatar);
                                        if($avatar_image)
                                        {
                                            if(file_exists(Yii::app()->basePath."/../files/".$avatar_image->image))
                                            {
                                                $name_in_db=str_replace('.png','',$avatar_image->image);
                                                echo "<tr><td class='width'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/files/".$name_in_db."_little.png"."'/></td>";
                                                echo "<td><div class='friends-name'>".$profile_user->firstname." ".$profile_user->lastname."</div><div class='friends-position'>".User::model()->findByPk($profile_user->user_id)->job_type."</div></td></tr>";
                                            }
                                            else
                                            {
                                                echo "<tr><td class='width'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/img/default-user-mini.png'/></td>";
                                                echo "<td><div class='friends-name'>".$profile_user->firstname." ".$profile_user->lastname."</div><div class='friends-position'>".User::model()->findByPk($profile_user->user_id)->job_type."</div></td></tr>";
                                            }
                                        }
                                        else
                                        {
                                            echo "<tr><td class='width'><div class='text-center'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/img/default-user-mini.png'/></div></td>";
                                            echo "<td><div class='friends-name'>".$profile_user->firstname." ".$profile_user->lastname."</div><div class='friends-position'>".User::model()->findByPk($profile_user->user_id)->job_type."</div></td></tr>";
                                        }
                                        echo "</table>";
                                    }
                                }
                                echo "</li>";
                            }
                            echo "</ul>";
                        }
                    }
//                    ?>
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
        <?php require_once "header.php";?>
        <div style="position: relative;display: table-cell;width:100%;">
            <?php echo $content; ?>
        </div>
        <div class="clear"></div>
<!--        --><?php //require_once "footer.php";?>
    </div>

<?php } else { ?>
            <?php echo $content; ?>
<?php } ?>

</body>
</html>
