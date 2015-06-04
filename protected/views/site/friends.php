<div>
    <?php
    if(Yum::hasModule('friendship'))
    {
        $user_friends=YumFriendship::model()->findAllBySql("select * from friendship where (inviter_id=:inviter_id OR friend_id=:friend_id) AND status=1 ORDER BY updatetime", array(':inviter_id'=>Yii::app()->user->id,':friend_id'=>Yii::app()->user->id));
        if($user_friends)
        {
            echo "<div class='title-class'><a href='/friends'>Friends</a> (",count($user_friends),")</div>";
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
                                echo "<a href='/user?id=$profile_user->id'><div class='text-center'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/files/".$name_in_db."_little.jpg"."'/></div></a>";
                            }
                            else
                            {
                                echo "<a href='/user?id=$profile_user->id'><div class='text-center'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/img/default-user.jpg'/></div></a>";
                            }
                        }
                        else
                        {
                            echo "<a href='/user?id=$profile_user->id'><div class='text-center'><img title='".$profile_user->firstname." ".$profile_user->lastname."' src='/img/default-user.jpg'/></div></a>";
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

