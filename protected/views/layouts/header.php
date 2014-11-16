<div id="mainmenu">
    <div class="left-columb-icon"></div>
    <ul class="top-menu">
        <li><a href="/friends" style="padding: 0"><div class="friends-icon"></div><div class="messages-not"></div></a></li>
        <li><a href="/messages" style="padding: 0"><div class="messages-icon"></div><div class="messages-not"></div></a></li>
        <li><a href="/groups" style="padding: 0"><div class="groups-icon"></div></a></li>
        <li><a href="/store" style="padding: 0"><div class="store-icon"></div></a></li>
        <li><div class="column"></div></li>
        <li><div class="text"><a href="/faq">FAG</a></div></li>

        <?php
        if(isset(Yii::app()->user->id)){
        ?>
        <li><div class="menu-avatar">
               <?php
               if(Yii::app()->user->id)
               {
                   $avatar_id=Profile::model()->findByAttributes(array("user_id"=>Yii::app()->user->id));
                   if($avatar_id)
                   {
                       $file_avatar=Files::model()->findByPk($avatar_id->avatar);
                       if($file_avatar)
                       {
                           if(file_exists(Yii::app()->basePath."/../files/".$file_avatar->image))
                           {
                               echo "<img src='/files/".$file_avatar->image."'/>";
                           }
                           else
                           {
                               echo "<img src='/img/default-user.png'/>";
                           }
                       }
                       else
                       {
                           echo "<img src='/img/default-user.png'/>";
                       }
                   }
                   else
                   {
                       echo "<img src='/img/default-user.png'/>";
                   }
               }
               ?>
            </div></li>
            <li><div class="text"><?php
                    $user=Profile::model()->findByAttributes(array("user_id"=>Yii::app()->user->id));
                    echo $user->firstname," ",$user->lastname;
                    ?></div></li>
            <li class="tri"><a href="#" class="no-padding"><div class="triangle"></div></a>
                <div class="triangle-menu">
                    <div class="popup-triangle"></div>
                    <a href="#" class="profile-icon">Profile</a>
                    <br /> <br />
                    <a href="/logout" class="logout-icon">Log Out</a>
                </div>
            </li>
            <script>
                $(document).ready(function()
                {
                    $(document).on('click','.tri',function()
                    {

                    }).on('click',function(el)
                    {
                        el.toElement.className=="triangle"?$('.triangle-menu').is(":visible")?$('.triangle-menu').removeAttr("style"):$('.triangle-menu').show():$('.triangle-menu').removeAttr("style");
                    }).on('keydown',function(el)
                    {
                        if(el.keyCode==27)
                        {
                            $('.triangle-menu').removeAttr("style");
                        }
                    })
                    .on('click','.left-columb-icon',function()
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
    </ul>

    <!--    --><?php //$this->widget('zii.widgets.CMenu',array(
//        'items'=>array(
//            array('label'=>'Settings', 'url'=>array('/settings')),
//            //				array('label'=>'Home', 'url'=>array('/site/index')),
//            //				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
//            //				array('label'=>'Contact', 'url'=>array('/site/contact')),
//            array('label'=>'Login', 'url'=>array('/login'), 'visible'=>Yii::app()->user->isGuest),
//            array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
//        ),
//    )); ?>
</div><!-- mainmenu -->