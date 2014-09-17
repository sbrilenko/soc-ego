<?php
/* @var $this SiteController */

?>
<div class="main float-left">
    <div>
    <?php
    if(Yum::hasModule('profile') && Yii::app()->user->id)
    {
        $profile=YumProfile::model()->findByAttributes(array("user_id"=>Yii::app()->user->id));
        if($profile)
        {
        ?>
          <div class="name text-center"><?php echo $profile->firstname," ",$profile->lastname ;?></div>

        <?php
        }
        echo '<div class="text-center">';
              $job_type=YumUser::model()->findByPk(Yii::app()->user->id);
              if($job_type)
              {
                  echo '<span class="name text-center">',$job_type->job_title,"</span>";
                  if(!empty($job_type->work_count) && strtotime(date("Y-m-d H:i:s"))>$job_type->work_count)
                  {
                      $date_day=strtotime(date("Y-m-d H:i:s"))-$job_type->work_count;
//                      echo date("Y-m-d H:i:s",$date_day);
                  }
                  echo "<span ><img src='/img/star_.png'/><img src='/img/star_.png'/><img src='/img/star_.png'/></span>";
              }

        echo '</div>';
        ?>
    <?php
    }
    if(Yum::hasModule('usergroup') && Yii::app()->user->id)
    {
        $usergroups=YumUsergroup::model()->findAll();
        if($usergroups)
        {
            $my_group=array();
            foreach($usergroups as $group)
            {
                if(!empty($group->participants))
                {
                    $part=explode(',',$group->participants);
                    if(in_array(Yii::app()->user->id,$part))
                    {
                        $my_group[]=$group;
                    }
                }
            }
            if(count($my_group)>0)
            {
                echo "<div class='title-class'>Groups (",count($my_group),")</div>";
                echo "<ul class='groups-list'>";
                foreach($my_group as $group_m)
                {
                    echo "<li class='float-left'><div class='group-padd'>";
                        if(!is_null($group_m) && $group_m->image>0)
                        {
                            $group_avatar=Files::model()->findByPk($group_m->image);
                            if($group_avatar)
                            {
                                $name_in_db=str_replace('.jpg','',$group_avatar->image);
                                if(file_exists(Yii::app()->basePath."/../files/".$name_in_db."_little.jpg"))
                                {
                                    echo "<div class='img'><img src='/files/".$name_in_db."_little.jpg' /></div>";
                                    echo "<div class='group-name'>",$group_avatar->title,"</div>";
                                }
                            }
                        }
                    echo "</div></li>";
                }
                echo "</ul>";
            }

        }
    }
    ?>
    </div>
    <div class="clear"></div>
    <?php

if(Yum::hasModule('comments') && Yii::app()->user->id)
{
    echo "<div class='title-class'>Wall</div>";
    echo $this->renderPartial('_addcommentform');
    $comments=Comments::model()->findAllByAttributes(array("commented_user_id"=>Yii::app()->user->id),array('order'=>'time DESC'));
    if($comments)
    {
        echo "<ul class='wall'>";
        foreach($comments as $com)
        {
            echo "<li>";
            if(!empty($com->image))
            {
                $comm_image=Files::model()->findByPk($com->image);
                if($comm_image)
                {
                    if(file_exists(Yii::app()->basePath."/../files/".$comm_image->image))
                    {
                        echo "<div class='text-center'><img src='/files/".$comm_image->image."'/></div>";
                    }
                }
            }
            echo "<div>".$com->text."</div>";
            echo "</li>";
        }
        echo "</ul>";
//
    }
}
?>
    </div>
</div>

<div class="right-block">
    <?php
      if(Yum::hasModule('profile') && Yii::app()->user->id)
      {
        $avatar_id=YumProfile::model()->findByAttributes(array("user_id"=>Yii::app()->user->id));
        if($avatar_id)
        {
            $file_avatar=Files::model()->findByPk($avatar_id->avatar);
            if($file_avatar)
            {
                if(file_exists(Yii::app()->basePath."/../files/".$file_avatar->image))
                {
                    echo "<div class='text-center'><img src='/files/".$file_avatar->image."'/></div>";
                }
            }
        }
      }

    if(Yum::hasModule('badgemanager'))
    {
        $user_badge=BadgeUser::model()->findAllByAttributes(array("user_id"=>Yii::app()->user->id));
        if($user_badge)
        {
            echo "<div class='title-class'>Badges (",count($user_badge),")</div>";
            echo "<ul class='badges-list'>";
            foreach($user_badge as $badge)
            {
                echo "<li class='float-left'>";
                $badge_id=Badges::model()->findByPk($badge->badge_id);
                if($badge_id)
                {
                    $badge_image=Files::model()->findByPk($badge_id->image);

                    if($badge_image)
                    {
                        if(file_exists(Yii::app()->basePath."/../files/".$badge_image->image))
                        {
                            $name_in_db=str_replace('.jpg','',$badge_image->image);
                            echo "<div class='text-center'><img title='".$badge_id->title."' src='/files/".$name_in_db."_little.jpg"."'/></div>";
                        }
                    }
                }
                echo "</li>";
            }
            echo "</ul>";
            echo "<div class='clear'></div>";

        }
    }

    if(Yum::hasModule('friendship'))
    {
        $user_friends=YumFriendship::model()->findAllBySql("select * from friendship where (inviter_id=:inviter_id OR friend_id=:friend_id) AND status=1 ORDER BY updatetime", array(':inviter_id'=>Yii::app()->user->id,':friend_id'=>Yii::app()->user->id));
        if($user_friends)
        {
            echo "<div class='title-class'>Friends (",count($user_friends),")</div>";
            echo "<ul class='friends-list'>";
            foreach($user_friends as $friend)
            {
                echo "<li class='float-left'>";
                if($friend->inviter_id==Yii::app()->user->id)
                {
                    $profile_user=YumProfile::model()->findByPk($friend->friend_id);
                    if($profile_user && !is_null($profile_user->avatar) && $profile_user->avatar>0)
                    {
                        $avatar_image=Files::model()->findByPk($profile_user->avatar);
                        if($avatar_image)
                        {
                            if(file_exists(Yii::app()->basePath."/../files/".$avatar_image->image))
                            {
                                $name_in_db=str_replace('.jpg','',$avatar_image->image);
                                echo "<div class='text-center'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/files/".$name_in_db."_little.jpg"."'/></div>";
                            }
                            else
                            {
                                echo "<div class='text-center'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/img/default-user.jpg'/></div>";
                            }
                        }
                        else
                        {
                            echo "<div class='text-center'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/img/default-user.jpg'/></div>";
                        }
                    }

                }
                else
                {
                    $profile_user=YumProfile::model()->findByPk($friend->inviter_id);
                    if($profile_user && !is_null($profile_user->avatar) && $profile_user->avatar>0)
                    {
                        $avatar_image=Files::model()->findByPk($profile_user->avatar);
                        if($avatar_image)
                        {
                            if(file_exists(Yii::app()->basePath."/../files/".$avatar_image->image))
                            {
                                $name_in_db=str_replace('.jpg','',$avatar_image->image);
                                echo "<div class='text-center'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/files/".$name_in_db."_little.jpg"."'/></div>";
                            }
                            else
                            {
                                echo "<div class='text-center'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/img/default-user.jpg'/></div>";
                            }
                        }
                        else
                        {
                            echo "<div class='text-center'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/img/default-user.jpg'/></div>";
                        }
                    }
                }
                echo "</li>";
            }
            echo "</ul>";

        }
    }
    ?>

</div>

