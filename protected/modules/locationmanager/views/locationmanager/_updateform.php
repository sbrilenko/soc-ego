<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'action'=>Yum::module('locationmanager')->updateUrl,
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
));
?>

<div class="row">
    <div class="span6 updates-locations">

        <?php
            if(isset($message) and !empty($message))
            {
                echo $message,"<br />";
            }
            else
            {
                if(count($model))
                {
                    foreach($model as $index=>$location)
                    {
                        $remove_link = 	CHtml::image(
                            Yii::app()->getAssetManager()->publish(
                                Yii::getPathOfAlias('zii.widgets.assets.gridview').'/delete.png'));
                        echo "<div>",$form->hiddenField($location,'['.$location->id.']id');
                        echo $form->textField($location, '['.$location->id.']locationname',array('value'=>$location->locationname)),"&nbsp;&nbsp;&nbsp;<a href='".Yum::module('locationmanager')->deleteUrl."/id/$location->id' class='delete-location' title='Delete location'>".$remove_link."</a></div>";

                    }
                    echo CHtml::submitButton(Yum::t('Update'),array('title'=>'Update locations'));
                }

            }
        ?>
</div>
</div>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('a.delete-location').on('click',function(e)
            {
                return confirm("Are you sure?")?true:false;
            })
        })
    </script>
<?php $this->endWidget(); ?>



