<?php
echo "<div class='badge-add-b'>";
echo CHtml::link(Yum::t('Create new level'), array(
    '//levellist/levellist/create'), array('class' => 'btn'));
echo "</div>";
$alllevellist=Levellist::model()->findAll();
if($alllevellist)
{
    echo "<table>";
    foreach($alllevellist as $index=>$level)
    {
    ?>
        <tr>
            <td style="width:25px;">
                <a href="<?php echo Yum::module('levellist')->updateUrl;?>/id/<?php echo $level->id;?>" title="Update level">
                    <?php
                    echo CHtml::image(
                        Yii::app()->getAssetManager()->publish(
                            Yii::getPathOfAlias('zii.widgets.assets.gridview').'/update.png'));
                    ?>
                </a>
                <br />
                <a class="level-delete" href="<?php echo Yum::module('levellist')->deleteUrl;?>/id/<?php echo $level->id;?>" title="Delete level">
                <?php
                    echo CHtml::image(
                        Yii::app()->getAssetManager()->publish(
                            Yii::getPathOfAlias('zii.widgets.assets.gridview').'/delete.png'));
                    ?>
                </a>
            </td>
            <td>

                Position: <?php echo $level->position; ?>
                <br />
                Priority: <?php echo $level->priority; ?>
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('a.level-delete').on('click',function()
        {
            return confirm("Are you sure?")?true:false;
        })
    })
</script>
