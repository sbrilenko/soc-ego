<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'gamificationmanager-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
));
?>

<div class="row">
    <div class="span6">

        <?php
            if(isset($message) and !empty($message))
            {
                echo $message,"<br />";
            }
    //        if(count($model))
    //        {
    //            foreach($model as $index=>$location)
    //            {
    //                $remove_link = 	CHtml::image(
    //                    Yii::app()->getAssetManager()->publish(
    //                        Yii::getPathOfAlias('zii.widgets.assets.gridview').'/delete.png'));
    //                echo "<div>",$form->hiddenField($location,'['.$location->id.']id');
    //                echo $form->textField($location, '['.$location->id.']locationname',array('value'=>$location->locationname)),"&nbsp;&nbsp;&nbsp;<a href='".Yum::module('locationmanager')->deleteUrl."/id/$location->id' class='delete-location' title='Delete location'>".$remove_link."</a></div>";
    //
    //            }
    //            echo CHtml::submitButton(Yum::t('Update'));
    //        }
        $trainee_low=$trainee_normal=$trainee_high=
        $junior_low=$junior_normal=$junior_high=
        $junior_middle_low=$junior_middle_normal=$junior_middle_high=
        $middle_low=$middle_normal=$middle_high=
        $middle_senior_low=$middle_senior_normal=$middle_senior_high=
        $senior_low=$senior_normal=$senior_high=
        $senior_lead_low=$senior_lead_normal=$senior_lead_high=
        $lead_low=$lead_normal=$lead_high=
        $tech_officer_low=$tech_officer_normal=$tech_officer_high=null;
        if($model)
        foreach($model as $index=>$gam)
        {
            switch($gam->level)
            {
                case "Trainee":
                    if($gam->seniority=="Low")
                        $trainee_low=$gam;
                    if($gam->seniority=="Normal")
                        $trainee_normal=$gam;
                    if($gam->seniority=="High")
                        $trainee_high=$gam;
                break;
                case "Junior":
                    if($gam->seniority=="Low")
                        $junior_low=$gam;
                    if($gam->seniority=="Normal")
                        $junior_normal=$gam;
                    if($gam->seniority=="High")
                        $junior_high=$gam;
                break;
                case "Junior_Middle":
                    if($gam->seniority=="Low")
                        $junior_middle_low=$gam;
                    if($gam->seniority=="Normal")
                        $junior_middle_normal=$gam;
                    if($gam->seniority=="High")
                        $junior_middle_high=$gam;
                break;
                case "Middle":
                    if($gam->seniority=="Low")
                        $middle_low=$gam;
                    if($gam->seniority=="Normal")
                        $middle_normal=$gam;
                    if($gam->seniority=="High")
                        $middle_high=$gam;
                break;
                case "Middle_Senior":
                    if($gam->seniority=="Low")
                        $middle_senior_low=$gam;
                    if($gam->seniority=="Normal")
                        $middle_senior_normal=$gam;
                    if($gam->seniority=="High")
                        $middle_senior_high=$gam;
                break;
                case "Senior":
                    if($gam->seniority=="Low")
                        $senior_low=$gam;
                    if($gam->seniority=="Normal")
                        $senior_normal=$gam;
                    if($gam->seniority=="High")
                        $senior_high=$gam;
                break;
                case "Senior_Lead":
                    if($gam->seniority=="Low")
                        $senior_lead_low=$gam;
                    if($gam->seniority=="Normal")
                        $senior_lead_normal=$gam;
                    if($gam->seniority=="High")
                        $senior_lead_high=$gam;
                break;
                case "Lead":
                    if($gam->seniority=="Low")
                        $lead_low=$gam;
                    if($gam->seniority=="Normal")
                        $lead_normal=$gam;
                    if($gam->seniority=="High")
                        $lead_high=$gam;
                break;
                case "Tech_Officer":
                    if($gam->seniority=="Low")
                        $tech_officer_low=$gam;
                    if($gam->seniority=="Normal")
                        $tech_officer_normal=$gam;
                    if($gam->seniority=="High")
                        $tech_officer_high=$gam;
                break;
            }
        }

         ?>
        <table>
            <tr>
                <th>
                    Level
                </th>
                <th>
                    Seniority
                </th>
                <th>
                    Start month
                </th>
            </tr>
            <tr>
                <td>
                    Trainee
                </td>
                <td>
                    <div>Low</div>
                    <div>Normal</div>
                    <div>Hight</div>
                </td>
                <td>
                    <div><?php echo Chtml::textField('Trainee[Low]',is_null($trainee_low)?'':$trainee_low->start_month);?></div>
                    <div><?php echo Chtml::textField('Trainee[Normal]',is_null($trainee_normal)?'':$trainee_normal->start_month);?></div>
                    <div><?php echo Chtml::textField('Trainee[High]',is_null($trainee_high)?'':$trainee_high->start_month);?></div>
                </td>
            </tr>
            <tr>
                <td>
                    Junior
                </td>
                <td>
                    <div>Low</div>
                    <div>Normal</div>
                    <div>Hight</div>
                </td>
                <td>
                    <div><?php echo Chtml::textField('Junior[Low]',is_null($junior_low)?'':$junior_low->start_month);?></div>
                    <div><?php echo Chtml::textField('Junior[Normal]',is_null($junior_normal)?'':$junior_normal->start_month);?></div>
                    <div><?php echo Chtml::textField('Junior[High]',is_null($junior_high)?'':$junior_high->start_month);?></div>
                </td>
            </tr>
            <tr>
                <td>
                    Junior / Middle
                </td>
                <td>
                    <div>Low</div>
                    <div>Normal</div>
                    <div>Hight</div>
                </td>
                <td>
                    <div><?php echo Chtml::textField('Junior_Middle[Low]',is_null($junior_middle_low)?'':$junior_middle_low->start_month);?></div>
                    <div><?php echo Chtml::textField('Junior_Middle[Normal]',is_null($junior_middle_normal)?'':$junior_middle_normal->start_month);?></div>
                    <div><?php echo Chtml::textField('Junior_Middle[High]',is_null($junior_middle_high)?'':$junior_middle_high->start_month);?></div>
                </td>
            </tr>
            <tr>
                <td>
                    Middle
                </td>
                <td>
                    <div>Low</div>
                    <div>Normal</div>
                    <div>Hight</div>
                </td>
                <td>
                    <div><?php echo Chtml::textField('Middle[Low]',is_null($middle_low)?'':$middle_low->start_month);?></div>
                    <div><?php echo Chtml::textField('Middle[Normal]',is_null($middle_normal)?'':$middle_normal->start_month);?></div>
                    <div><?php echo Chtml::textField('Middle[High]',is_null($middle_high)?'':$middle_high->start_month);?></div>
                </td>
            </tr>
            <tr>
                <td>
                    Middle / Senior
                </td>
                <td>
                    <div>Low</div>
                    <div>Normal</div>
                    <div>Hight</div>
                </td>
                <td>
                    <div><?php echo Chtml::textField('Middle_Senior[Low]',is_null($middle_senior_low)?'':$middle_senior_low->start_month);?></div>
                    <div><?php echo Chtml::textField('Middle_Senior[Normal]',is_null($middle_senior_normal)?'':$middle_senior_normal->start_month);?></div>
                    <div><?php echo Chtml::textField('Middle_Senior[High]',is_null($middle_senior_high)?'':$middle_senior_high->start_month);?></div>
                </td>
            </tr>
            <tr>
                <td>
                    Senior
                </td>
                <td>
                    <div>Low</div>
                    <div>Normal</div>
                    <div>Hight</div>
                </td>
                <td>
                    <div><?php echo Chtml::textField('Senior[Low]',is_null($senior_low)?'':$senior_low->start_month);?></div>
                    <div><?php echo Chtml::textField('Senior[Normal]',is_null($senior_normal)?'':$senior_normal->start_month);?></div>
                    <div><?php echo Chtml::textField('Senior[High]',is_null($senior_high)?'':$senior_high->start_month);?></div>
                </td>
            </tr>
            <tr>
                <td>
                    Senior / Lead
                </td>
                <td>
                    <div>Low</div>
                    <div>Normal</div>
                    <div>Hight</div>
                </td>
                <td>
                    <div><?php echo Chtml::textField('Senior_Lead[Low]',is_null($senior_lead_low)?'':$senior_lead_low->start_month);?></div>
                    <div><?php echo Chtml::textField('Senior_Lead[Normal]',is_null($senior_lead_normal)?'':$senior_lead_normal->start_month);?></div>
                    <div><?php echo Chtml::textField('Senior_Lead[High]',is_null($senior_lead_high)?'':$senior_lead_high->start_month);?></div>
                </td>
            </tr>
            <tr>
                <td>
                    Lead
                </td>
                <td>
                    <div>Low</div>
                    <div>Normal</div>
                    <div>Hight</div>
                </td>
                <td>
                    <div><?php echo Chtml::textField('Lead[Low]',is_null($lead_low)?'':$lead_low->start_month);?></div>
                    <div><?php echo Chtml::textField('Lead[Normal]',is_null($lead_normal)?'':$lead_normal->start_month);?></div>
                    <div><?php echo Chtml::textField('Lead[High]',is_null($lead_high)?'':$lead_high->start_month);?></div>
                </td>
            </tr>
            <tr>
                <td>
                    Tech Officer
                </td>
                <td>
                    <div>Low</div>
                    <div>Normal</div>
                    <div>Hight</div>
                </td>
                <td>
                    <div><?php echo Chtml::textField('Tech_Officer[Low]',is_null($tech_officer_low)?'':$tech_officer_low->start_month);?></div>
                    <div><?php echo Chtml::textField('Tech_Officer[Normal]',is_null($tech_officer_normal)?'':$tech_officer_normal->start_month);?></div>
                    <div><?php echo Chtml::textField('Tech_Officer[High]',is_null($tech_officer_high)?'':$tech_officer_high->start_month);?></div>
                </td>
            </tr>
        </table>
        <div style="text-align: center">
            <?php echo CHtml::submitButton(Yum::t('Update'));?>
        </div>

</div>
</div>
<?php $this->endWidget(); ?>



