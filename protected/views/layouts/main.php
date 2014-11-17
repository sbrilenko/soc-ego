
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
    <div class="clear"></div>

    <div class="main-content" style="overflow: visible;padding: 0">
        <div class="left-column">
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
                                echo "<div class='avatar-container'><img style='width:100%;' src='/files/".$file_avatar->image."'/></div>";
                            }
                            else
                            {
                                echo "<div class='avatar-container'><img style='width:100%;' src='/img/default-user.png'/></div>";
                            }
                        }
                        else
                        {
                            echo "<div class='avatar-container'><img style='width:100%;' src='/img/default-user.png'/></div>";
                        }
                    }
                    else
                    {
                        echo "<div class='avatar-container'><img style='width:100%;' src='/img/default-user.png'/></div>";
                    }
                }
                ?>
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
                                                $name_in_db=str_replace('.jpg','',$avatar_image->image);
                                                echo "<tr><td class='width'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/files/".$name_in_db."_little.jpg"."'/></td>";
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
                                            $name_in_db=str_replace('.jpg','',$badge_image->image);
                                            echo "<img title='".$badge_id->title."' src='/files/".$name_in_db."_little.jpg"."'/>";
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
<!--        --><?php //$this->render("login"); ?>
<?php } ?>

</body>
</html>
