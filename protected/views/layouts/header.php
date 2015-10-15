<div id="mainmenu">
    <input type="hidden" value="<?php echo Yii::app()->controller->uniqueid; ?>" id="controllerId">
    <input type="hidden" value="<?php echo Yii::app()->controller->action->id; ?>" id="controllerActionId">
    <ul class="top-menu">
        <li>
            <a href="#" class="no-padding">
                <div class="menu-padding">
                    <div class="left-columb-icon"></div>
                </div>
            </a>
        </li>
        <li>
            <a href="/" title="Home" class="no-padding">
                <div class="menu-padding <?php if(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="index") echo "current";?>">
                    <div class="home-icon "></div>
                </div>
            </a></li>
        <li>
            <a href="/friends" class="no-padding">
                <div class="menu-padding <?php if(Yii::app()->controller->id=="friendship") echo "current";?>">
                    <div class="friends-icon"></div>
                    <div class="messages-not yellow" id="newFriendRequestsCount" <?php if (Friendship::model()->countFriendRequests(Yii::app()->user->id)>0) {echo "style='display:initial;'";} ?> ><?php echo Friendship::model()->countFriendRequests(Yii::app()->user->id);?></div>
                </div>
            </a></li>
        <li>
            <a href="/messages" class="no-padding">
                <div class="menu-padding <?php if(Yii::app()->controller->action->id=="messages") echo "current";?>">
                    <div class="messages-icon"></div><div class="messages-not" id="newMessagesCount" <?php if (Message::model()->allNotReadMessages(Yii::app()->user->id)>0) {echo "style='display:initial;'";} ?> ><?php echo Message::model()->allNotReadMessages(Yii::app()->user->id);?></div>
                </div>
            </a></li>
        <li>
            <a href="/groups" class="no-padding">
                <div class="menu-padding <?php if(Yii::app()->controller->action->id=="groups") echo "current";?>">
                    <div class="groups-icon"></div>
                </div>
            </a>
        </li>
        <li>
            <a href="/store" class="no-padding">
                <div class="menu-padding <?php if(Yii::app()->controller->action->id=="store") echo "current";?>">
                    <div class="store-icon"></div>
                </div>
            </a></li>
        <li><div class="column"></div></li>
        <li><div class="text">
                <div class="menu-padding">
                    <a <?php if(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="faq") echo "current";?> href="/faq">FAQ</a>
                </div>
            </div>
        </li>
        </ul>

        <?php
        if(isset(Yii::app()->user->id)){
        ?>

        <ul class="f-r">
            <li>
                <div class="menu-padding" style="padding-right: 0px;">
                    <div class="menu-avatar f-l">
                       <?php
                       echo Profile::model()->getLittleAvatar(Yii::app()->user->id);
                       ?>
                    </div>
                    <div class="text f-l"><?php
                        $user=Profile::model()->findByAttributes(array("user_id"=>Yii::app()->user->id));
                        if ($user) {
                            echo $user->firstname," ",$user->lastname;
                        }
                        ?>
                    </div>
                </div>
            </li>
            <li class="tri">
                <a href="#" class="no-padding">
                    <div class="menu-padding">
                        <div class="triangle"></div>
                    </div>
                </a>
                <div class="triangle-menu">
                    <div class="popup-triangle"></div>
                    <div class="menu-padding">
                        <div class="menu-avatar f-l">
                            <?php
                            echo Profile::model()->getLittleAvatar(Yii::app()->user->id);
                            ?>
                        </div>
                        <div class="text f-l"><?php
                            $user=Profile::model()->findByAttributes(array("user_id"=>Yii::app()->user->id));
                            if ($user) {
                                echo $user->firstname," ",$user->lastname;
                            }
                            ?>
                        </div>
                    </div>
                    <a href="#" class="profile-icon">Profile</a>
                    <br /> <br />
                    <a href="/logout" class="logout-icon">Log Out</a>
                </div>
            </li>
        </ul>
        <?php } ?>



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