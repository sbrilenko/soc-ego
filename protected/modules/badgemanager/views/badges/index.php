<?php

echo CHtml::link(Yum::t('Create new User'), array(
    '//badgemanager/badges/create'), array('class' => 'btn'));
$allbadgesBadges=Badges::model()->findAll();
if($allbadgesBadges)
{
    echo "<table>";
    foreach($allbadgesBadges as $index=>$badge)
    {
    ?>
        <tr>
            <td style="width:25px;">
                <a href="<?php echo Yum::module('badgemanager')->updateUrl;?>/id/<?php echo $badge->id;?>" title="Update badge">
                    <?php
                    echo CHtml::image(
                        Yii::app()->getAssetManager()->publish(
                            Yii::getPathOfAlias('zii.widgets.assets.gridview').'/update.png'));
                    ?>
                </a>
                <br />
                <a class="badge-delete" href="<?php echo Yum::module('badgemanager')->deleteUrl;?>/id/<?php echo $badge->id;?>" title="Delete badge">
                <?php
                    echo CHtml::image(
                        Yii::app()->getAssetManager()->publish(
                            Yii::getPathOfAlias('zii.widgets.assets.gridview').'/delete.png'));
                    ?>
                </a>
            </td>
            <?php
            if($badge->image>0)
            {
                $image_file=Files::model()->findByPk($badge->image);
                if($image_file)
                {
                    $little_ph=str_replace('.jpg','',$image_file->image);
                    if(file_exists(Yii::app()->basePath."/../files/".$little_ph."_little.jpg"))
                    {
                    ?>
                        <td style="width:75px;">
                            <img src='/files/<?php echo $little_ph."_little.jpg"; ?>'/>
                        </td>
                    <?php
                    }
                }
            } ?>
            <td>

                Title: <?php echo $badge->title; ?>
                <br />
                Cost: <?php echo $badge->cost; ?>
            </td>
            <td>
                <?php
                $users=YumUser::model()->findAll();
                if(count($users)>0)
                {
                    $form = $this->beginWidget('CActiveForm', array(
                        'id'=>'user-form',
                        'enableAjaxValidation'=>false,
                        'action'=>Yum::module('badgemanager')->badgeusermanagerUrl,
                        'enableClientValidation'=>true,
                    ));
                    echo "<table style='width:150px;'><tr><td style='vertical-align: middle'>";
                    $dropdownusers=array();
                    foreach($users as $index=>$user)
                    {
                        $badges_on_user=BadgeUser::model()->findByAttributes(array('user_id'=>$user->id,'badge_id'=>$badge->id));
                        if($badges_on_user && $badges_on_user->count>0)
                            $dropdownusers[$user->id]=$user->username." (".$badges_on_user->count.")";
                        else $dropdownusers[$user->id]=$user->username;
                    }
                    $badge_user=new BadgeUser();
                    echo $form->dropDownList($badge_user,'user_id',$dropdownusers);
                    echo $form->hiddenField($badge_user,"badge_id", array("value" => $badge->id));
                    echo "</td><td style='vertical-align: middle;text-align: center'>";

                    echo CHtml::submitButton(Yum::t('Add'),array('name' => 'badgeusersubmit1'));
                    echo CHtml::submitButton(Yum::t('remove'),array('name' => 'badgeusersubmit2'));
                    echo "</td></table>";

                $this->endWidget();
                }

                ?>
            </td>
        </tr>
    <?php
    }
    echo "</table>";

}
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('a.badge-delete').on('click',function()
        {
            return confirm("Are you sure?")?true:false;
        })
    })
</script>
