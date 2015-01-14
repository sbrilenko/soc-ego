<table class='participants-table'>
<?php
if(!$group) $group=new Usergroup();
if($model)
{
    foreach($model as $user)
    {
        if($user->job_type!=="PM")
        {
            echo "<tr>";
            $user_profile=Profile::model()->findByAttributes(array("user_id"=>$user->id));
            if(Participants::model()->findAllByAttributes(array("status"=>1,"group_id"=>$group->id,"user_id"=>$user->id)))
            {
                echo "<td>",CHtml::activeCheckBox($group,'participants['.$user->id.']',  array('checked'=>'checked')),"</td>";
                echo "<td>",CHtml::activeLabelEx($group,$user_profile->firstname." ".$user_profile->lastname),"</td>";
            }
            else
            {
                echo "<td>",CHtml::activeCheckBox($group,'participants['.$user->id.']'),"</td>";
                echo "<td>",CHtml::activeLabelEx($group,$user_profile->firstname." ".$user_profile->lastname),"</td>";
            }
            echo "</tr>";
        }
    }
}
else { ?>
    <tr><td>No users</td></tr>
<?php
}
?>
</table>