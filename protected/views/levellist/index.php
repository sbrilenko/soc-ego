<?php
if($job_type)
{

    echo "<table>";
    foreach($job_type as $index=>$level)
    {
    ?>
        <tr>
            <td style="width:25px;">
            <div>
                Position: <?php echo $level->job_type; ?>
            </div>
                <?php foreach($job_title as $title) { ?>
                    <?php if($title->job_type_id==$level->id) { ?>
                        <div style="margin-left: 35px">
                            <a href="/levellist/update/id/<?php echo $title->id;?>" title="Update level">
                                <?php
                                echo CHtml::image(
                                    Yii::app()->getAssetManager()->publish(
                                        Yii::getPathOfAlias('zii.widgets.assets.gridview').'/update.png'));
                                ?>
                            </a>
                            <span>&nbsp;<?php echo htmlspecialchars($title->job_title);?></span>
                        </div>
                    <?php } ?>
                <?php } ?>
            </td>

        </tr>
        <tr><td colspan="2">
            <hr style="margin:10px 0"/>
        </td></tr>
    <?php
    }
    echo "</table>";

}
?>
