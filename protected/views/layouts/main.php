
<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/responsive.css">
    <?php } else { ?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css">
    <?php } ?>
    <?php if(isset(Yii::app()->user->id) && Yii::app()->controller->id=="site" && (Yii::app()->controller->action->id=="index")) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/index-responsive.css">
    <?php } ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <?php if(isset(Yii::app()->user->id) && Yii::app()->controller->id=="site" && (Yii::app()->controller->action->id=="index" || Yii::app()->controller->action->id=="faq" || Yii::app()->controller->action->id=="groups")) { ?>
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
                                    if((form.find('input[name*=from_user_id]').val()==msg.from && form.find('input[name*=to_user_id]').val()==msg.to) || 
                                        (form.find('input[name*=from_user_id]').val()==msg.to && form.find('input[name*=to_user_id]').val()==msg.from))
                                    {
                                        $('.message-block-user-time',this).text(msg.date);
                                        $('.message-block-user-message',this).text(msg.message);

                                        if ($('.dialog-messages').attr('id') === msg.to ) {
                                            var mess = '';
                                            mess += '<table style="padding-right: 30px; margin-top:25px; margin-bottom:25px;">';
                                            mess += '<tbody>';
                                            mess += '<tr><td class="padding-zero wall-avatar-td">&nbsp;</td>';
                                            mess += '<td class="padding-zero" style="padding-left: 10%;">';
                                            mess += '<div class="message-buble">';
                                            mess += '<div class="message-buble-triangle-back"></div>';
                                            mess += '<div class="comment-owner f-l" style="font-size: 16px; font-weight: 500;">' + $('.avatar-name-style').text() + '</div>';
                                            mess += '<div class="f-r" style="color: #959595; font-size: 12px;">' + msg.date + '</div>';
                                            mess += '<div class="clear"></div>';
                                            mess += '<div class="comment">' + msg.message + '</div>';
                                            mess += '</div></td></tr>';
                                            mess += '</tbody>';
                                            mess += '</table>';

                                            $('.dialog-messages').append(mess);

                                            setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                                        }
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
                    if(!$(".left-block").hasClass("close") && !$(".left-block").is(":animated"))
                    {
                        $(".left-block").animate({width:0,maxWidth:0,minWidth:0},500,function(){$(".left-block").addClass("close");})
                    }
                    else
                    {
                        $(".left-block").show().animate({width:314,maxWidth:314,minWidth:314},500,function(){$(".left-block").removeClass("close")})
                    }
                })
        })
    </script>
    <?php } ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <?php
    if(isset(Yii::app()->user->id))
    {
    ?>
    <div class="main-content">
    <div class="avatar-container left-block">
        <?php require_once "leftcolumn.php";?>
    </div>
    <div class="container">
        <?php require_once "header.php";?>
        <?php echo $content; ?>
    </div>
    </div>

<?php } else { ?>
            <?php echo $content; ?>
<?php } ?>
</body>
</html>
