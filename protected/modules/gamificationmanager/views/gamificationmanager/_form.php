
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
<script>
    $(function() {
        $( "#tabs" ).tabs();
    });
</script>
<div class="row">
    <div class="span6">

        <?php
            if(isset($message) and !empty($message))
            {
                echo $message,"<br />";
            }
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
        <?php $tab_number=$tab_number_li=$tab_number_div=2; ?>
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Months</a></li>
                <?php
                    $gamifica_position=GamificationfactorsPositions::model()->findAll();
                    if($gamifica_position)
                    {
                        foreach($gamifica_position as $pos)
                        {
                            echo '<li><a href="#tabs-'.$tab_number_li.'">'.$pos->position.'</a></li>';
                            $tab_number_li++;
                        }
                    }
                ?>
                <li><a href="#tabs-add-new-position">Add new position</a></li>
            </ul>
            <div id="tabs-1">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id'=>'gamificationmanager-form',
                    'enableAjaxValidation'=>false,
                    'enableClientValidation'=>true,
                ));

                ?>
                <table>
                    <tr>
                        <th>
                            Seniority
                        </th>
                        <th>
                            Experience
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
                            <div>High</div>
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
                            <div>High</div>
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
                            <div>High</div>
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
                            <div>High</div>
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
                            <div>High</div>
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
                            <div>High</div>
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
                            <div>High</div>
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
                            <div>High</div>
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
                            <div>High</div>
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
                <?php $this->endWidget(); ?>
            </div>
            <?php
            $gamifica_position=GamificationfactorsPositions::model()->findAll();
            if($gamifica_position && Yii::app()->db->getSchema()->getTable('gamificationmanager') && count(GamificationManager::model()->findAll())>0)
            {
                foreach($gamifica_position as $pos)
                {
                    ?>
                        <div id="tabs-<?php echo $tab_number_div;?>">
                            <?php
                            $tab_number_div++;
                            $form = $this->beginWidget('CActiveForm', array(
                                'id'=>'gamificationmanager-form-update',
                                'action'=>Yum::module('gamificationmanager')->updateUrl,
                                'enableAjaxValidation'=>false,
                                'enableClientValidation'=>true,
                            ));

                            ?>
                            <div><?php echo Chtml::hiddenField($pos->position.'[id]',$pos->id);?></div>
                            <table>
                                <tr>
                                    <td>
                                        <div><?php echo Chtml::label("Position",'Developer_position');?></div>
                                        <div><?php echo Chtml::textField($pos->position.'[position]',$pos->position);?></div>
                                    </td>
                                    <td>
                                        <div><?php echo Chtml::label("Base salary",'Developer_position');?></div>
                                        <div><?php echo Chtml::textField($pos->position.'[base_salary]',$pos->base_salary);?></div>
                                    </td>
                                    <td>
                                        <a class="delete" href="<?php echo Yum::module('gamificationmanager')->deleteUrl;?>/id/<?php echo $pos->id;?>" title="Delete">
                                            <?php
                                            echo CHtml::image(
                                                Yii::app()->getAssetManager()->publish(
                                                    Yii::getPathOfAlias('zii.widgets.assets.gridview').'/delete.png'));
                                            ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Seniority
                                    </th>
                                    <th>
                                        Seniority factor
                                    </th>
                                    <th>
                                        Experience
                                    </th>
                                    <th>
                                        Experience factor
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
                                       <?php
                                       if(!is_null($trainee_low))
                                       {
                                           $factor_for_tra_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$trainee_low->id));
                                           if($factor_for_tra_low && $factor_for_tra_low->seniority_factor>0)
                                           {
                                               echo "<div>".Chtml::textField($pos->position.'[trainer_low_seniority_factor]',$factor_for_tra_low->seniority_factor)."</div>";
                                           }
                                           else
                                           {
                                               echo "<div>".Chtml::textField($pos->position.'[trainer_low_seniority_factor]','')."</div>";
                                           }
                                           echo "<div>".Chtml::hiddenField($pos->position.'[trainer_low_id]',$trainee_low->id)."</div>";
                                       }

                                       if(!is_null($trainee_normal))
                                       {
                                           $factor_for_tra_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$trainee_normal->id));
                                           if($factor_for_tra_normal && $factor_for_tra_normal->seniority_factor>0)
                                           {
                                               echo "<div>".Chtml::textField($pos->position.'[trainer_normal_seniority_factor]',$factor_for_tra_normal->seniority_factor)."</div>";
                                           }
                                           else
                                           {
                                               echo "<div>".Chtml::textField($pos->position.'[trainer_normal_seniority_factor]','')."</div>";
                                           }
                                           echo "<div>".Chtml::hiddenField($pos->position.'[trainer_normal_id]',$trainee_normal->id)."</div>";
                                       }

                                       if(!is_null($trainee_high))
                                       {
                                           $factor_for_tra_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$trainee_high->id));
                                           if($factor_for_tra_high && $factor_for_tra_high->seniority_factor>0)
                                           {
                                               echo "<div>".Chtml::textField($pos->position.'[trainer_high_seniority_factor]',$factor_for_tra_high->seniority_factor)."</div>";
                                           }
                                           else
                                           {
                                               echo "<div>".Chtml::textField($pos->position.'[trainer_high_seniority_factor]','')."</div>";
                                           }
                                           echo "<div>".Chtml::hiddenField($pos->position.'[trainer_high_id]',$trainee_high->id)."</div>";
                                       }
                                       ?>
                                   </td>
                                    <td>
                                        <div>Low</div>
                                        <div>Normal</div>
                                        <div>High</div>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($trainee_low))
                                        {
                                            $factor_for_tra_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$trainee_low->id));
                                            if($factor_for_tra_low && $factor_for_tra_low->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[trainer_low_experience_factor]',$factor_for_tra_low->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[trainer_low_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($trainee_normal))
                                        {
                                            $factor_for_tra_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$trainee_normal->id));
                                            if($factor_for_tra_normal && $factor_for_tra_normal->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[trainer_normal_experience_factor]',$factor_for_tra_normal->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[trainer_normal_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($trainee_high))
                                        {
                                            $factor_for_tra_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$trainee_high->id));
                                            if($factor_for_tra_high && $factor_for_tra_high->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[trainer_high_experience_factor]',$factor_for_tra_high->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[trainer_high_experience_factor]','')."</div>";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if(!is_null($trainee_low))
                                            {
                                              echo "<div>".$trainee_low->start_month."</div>";
                                            }
                                            else echo "<div>&nbsp;</div>";
                                            if(!is_null($trainee_normal))
                                            {
                                                echo "<div>".$trainee_normal->start_month."</div>";
                                            }
                                            else echo "<div>&nbsp;</div>";
                                            if(!is_null($trainee_high))
                                            {
                                                echo "<div>".$trainee_high->start_month."</div>";
                                            }
                                            else echo "<div>&nbsp;</div>";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Junior
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($junior_low))
                                        {
                                            $factor_for_junior_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_low->id));
                                            if($factor_for_junior_low && $factor_for_junior_low->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_low_seniority_factor]',$factor_for_junior_low->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_low_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[junior_low_id]',$junior_low->id)."</div>";
                                        }

                                        if(!is_null($junior_normal))
                                        {
                                            $factor_for_junior_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_normal->id));
                                            if($factor_for_junior_normal && $factor_for_junior_normal->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_normal_seniority_factor]',$factor_for_junior_normal->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_normal_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[junior_normal_id]',$junior_normal->id)."</div>";
                                        }

                                        if(!is_null($junior_high))
                                        {
                                            $factor_for_junior_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_high->id));
                                            if($factor_for_junior_high && $factor_for_junior_high->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_high_seniority_factor]',$factor_for_junior_high->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_high_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[junior_high_id]',$junior_high->id)."</div>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div>Low</div>
                                        <div>Normal</div>
                                        <div>High</div>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($junior_low))
                                        {
                                            $factor_for_junior_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_low->id));
                                            if($factor_for_junior_low && $factor_for_junior_low->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_low_experience_factor]',$factor_for_junior_low->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_low_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($junior_normal))
                                        {
                                            $factor_for_junior_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_normal->id));
                                            if($factor_for_junior_normal && $factor_for_junior_normal->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_normal_experience_factor]',$factor_for_junior_normal->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_normal_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($junior_high))
                                        {
                                            $factor_for_junior_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_high->id));
                                            if($factor_for_junior_high && $factor_for_junior_high->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_high_experience_factor]',$factor_for_junior_high->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_high_experience_factor]','')."</div>";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($junior_low))
                                        {
                                            echo "<div>".$junior_low->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($junior_normal))
                                        {
                                            echo "<div>".$junior_normal->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($junior_high))
                                        {
                                            echo "<div>".$junior_high->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Junior / Middle
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($junior_middle_low))
                                        {
                                            $factor_for_junior_middle_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_middle_low->id));
                                            if($factor_for_junior_middle_low && $factor_for_junior_middle_low->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_low_seniority_factor]',$factor_for_junior_middle_low->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_low_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[junior_middle_low_id]',$junior_middle_low->id)."</div>";
                                        }

                                        if(!is_null($junior_middle_normal))
                                        {
                                            $factor_for_junior_middle_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_middle_normal->id));
                                            if($factor_for_junior_middle_normal && $factor_for_junior_middle_normal->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_normal_seniority_factor]',$factor_for_junior_middle_normal->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_normal_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[junior_middle_normal_id]',$junior_middle_normal->id)."</div>";
                                        }

                                        if(!is_null($junior_middle_high))
                                        {
                                            $factor_for_junior_middle_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_middle_high->id));
                                            if($factor_for_junior_middle_high && $factor_for_junior_middle_high->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_high_seniority_factor]',$factor_for_junior_middle_high->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_high_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[junior_middle_high_id]',$junior_middle_high->id)."</div>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div>Low</div>
                                        <div>Normal</div>
                                        <div>High</div>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($junior_middle_low))
                                        {
                                            $factor_for_junior_middle_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_middle_low->id));
                                            if($factor_for_junior_middle_low && $factor_for_junior_middle_low->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_low_experience_factor]',$factor_for_junior_middle_low->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_low_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($junior_middle_normal))
                                        {
                                            $factor_for_junior_middle_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_middle_normal->id));
                                            if($factor_for_junior_middle_normal && $factor_for_junior_middle_normal->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_normal_experience_factor]',$factor_for_junior_middle_normal->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_normal_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($junior_middle_high))
                                        {
                                            $factor_for_junior_middle_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$junior_middle_high->id));
                                            if($factor_for_junior_middle_high && $factor_for_junior_middle_high->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_high_experience_factor]',$factor_for_junior_middle_high->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[junior_middle_high_experience_factor]','')."</div>";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($junior_middle_low))
                                        {
                                            echo "<div>".$junior_middle_low->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($junior_middle_normal))
                                        {
                                            echo "<div>".$junior_middle_normal->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($junior_middle_high))
                                        {
                                            echo "<div>".$junior_middle_high->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Middle
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($middle_low))
                                        {
                                            $factor_for_middle_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_low->id));
                                            if($factor_for_middle_low && $factor_for_middle_low->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_low_seniority_factor]',$factor_for_middle_low->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_low_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[middle_low_id]',$middle_low->id)."</div>";
                                        }

                                        if(!is_null($middle_normal))
                                        {
                                            $factor_for_middle_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_normal->id));
                                            if($factor_for_middle_normal && $factor_for_middle_normal->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_normal_seniority_factor]',$factor_for_middle_normal->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_normal_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[middle_normal_id]',$middle_normal->id)."</div>";
                                        }

                                        if(!is_null($middle_high))
                                        {
                                            $factor_for_middle_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_high->id));
                                            if($factor_for_middle_high && $factor_for_middle_high->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_high_seniority_factor]',$factor_for_middle_high->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_high_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[middle_high_id]',$middle_high->id)."</div>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div>Low</div>
                                        <div>Normal</div>
                                        <div>High</div>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($middle_low))
                                        {
                                            $factor_for_middle_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_low->id));
                                            if($factor_for_middle_low && $factor_for_middle_low->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_low_experience_factor]',$factor_for_middle_low->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_low_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($middle_normal))
                                        {
                                            $factor_for_middle_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_normal->id));
                                            if($factor_for_middle_normal && $factor_for_middle_normal->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_normal_experience_factor]',$factor_for_middle_normal->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_normal_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($middle_high))
                                        {
                                            $factor_for_middle_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_high->id));
                                            if($factor_for_middle_high && $factor_for_middle_high->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_high_experience_factor]',$factor_for_middle_high->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_high_experience_factor]','')."</div>";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($middle_low))
                                        {
                                            echo "<div>".$middle_low->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($middle_normal))
                                        {
                                            echo "<div>".$middle_normal->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($middle_high))
                                        {
                                            echo "<div>".$middle_high->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Middle / Senior
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($middle_senior_low))
                                        {
                                            $factor_for_middle_senior_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_senior_low->id));
                                            if($factor_for_middle_senior_low && $factor_for_middle_senior_low->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_low_seniority_factor]',$factor_for_middle_senior_low->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_low_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[middle_senior_low_id]',$middle_senior_low->id)."</div>";
                                        }

                                        if(!is_null($middle_senior_normal))
                                        {
                                            $factor_for_middle_senior_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_senior_normal->id));
                                            if($factor_for_middle_senior_normal && $factor_for_middle_senior_normal->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_normal_seniority_factor]',$factor_for_middle_senior_normal->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_normal_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[middle_senior_normal_id]',$middle_senior_normal->id)."</div>";
                                        }

                                        if(!is_null($middle_senior_high))
                                        {
                                            $factor_for_middle_senior_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_senior_high->id));
                                            if($factor_for_middle_senior_high && $factor_for_middle_senior_high->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_high_experience_factor]',$factor_for_middle_senior_high->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_high_experience_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[middle_senior_high_id]',$middle_senior_high->id)."</div>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div>Low</div>
                                        <div>Normal</div>
                                        <div>High</div>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($middle_senior_low))
                                        {
                                            $factor_for_middle_senior_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_senior_low->id));
                                            if($factor_for_middle_senior_low && $factor_for_middle_senior_low->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_low_experience_factor]',$factor_for_middle_senior_low->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_low_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($middle_senior_normal))
                                        {
                                            $factor_for_middle_senior_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_senior_normal->id));
                                            if($factor_for_middle_senior_normal && $factor_for_middle_senior_normal->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_normal_experience_factor]',$factor_for_middle_senior_normal->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_normal_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($middle_senior_high))
                                        {
                                            $factor_for_middle_senior_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$middle_senior_high->id));
                                            if($factor_for_middle_senior_high && $factor_for_middle_senior_high->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_high_experience_factor]',$factor_for_middle_senior_high->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[middle_senior_high_experience_factor]','')."</div>";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($middle_senior_low))
                                        {
                                            echo "<div>".$middle_senior_low->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($middle_senior_normal))
                                        {
                                            echo "<div>".$middle_senior_normal->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($middle_senior_high))
                                        {
                                            echo "<div>".$middle_senior_high->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Senior
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($senior_low))
                                        {
                                            $factor_for_senior_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_low->id));
                                            if($factor_for_senior_low && $factor_for_senior_low->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_low_seniority_factor]',$factor_for_senior_low->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_low_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[senior_low_id]',$senior_low->id)."</div>";
                                        }

                                        if(!is_null($senior_normal))
                                        {
                                            $factor_for_senior_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_normal->id));
                                            if($factor_for_senior_normal && $factor_for_senior_normal->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_normal_seniority_factor]',$factor_for_senior_normal->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_normal_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[senior_normal_id]',$senior_normal->id)."</div>";
                                        }

                                        if(!is_null($senior_high))
                                        {
                                            $factor_for_senior_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_high->id));
                                            if($factor_for_senior_high && $factor_for_senior_high->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_high_seniority_factor]',$factor_for_senior_high->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_high_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[senior_high_id]',$senior_high->id)."</div>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div>Low</div>
                                        <div>Normal</div>
                                        <div>High</div>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($senior_low))
                                        {
                                            $factor_for_senior_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_low->id));
                                            if($factor_for_senior_low && $factor_for_senior_low->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_low_experience_factor]',$factor_for_senior_low->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_low_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($senior_normal))
                                        {
                                            $factor_for_senior_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_normal->id));
                                            if($factor_for_senior_normal && $factor_for_senior_normal->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_normal_experience_factor]',$factor_for_senior_normal->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_normal_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($senior_high))
                                        {
                                            $factor_for_senior_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_high->id));
                                            if($factor_for_senior_high && $factor_for_senior_high->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_high_experience_factor]',$factor_for_senior_high->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_high_experience_factor]','')."</div>";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($senior_low))
                                        {
                                            echo "<div>".$senior_low->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($senior_normal))
                                        {
                                            echo "<div>".$senior_normal->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($senior_high))
                                        {
                                            echo "<div>".$senior_high->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Senior / Lead
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($senior_lead_low))
                                        {
                                            $factor_for_senior_lead_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_lead_low->id));
                                            if($factor_for_senior_lead_low && $factor_for_senior_lead_low->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_low_seniority_factor]',$factor_for_senior_lead_low->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_low_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[senior_lead_low_id]',$senior_lead_low->id)."</div>";
                                        }

                                        if(!is_null($senior_lead_normal))
                                        {
                                            $factor_for_senior_lead_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_lead_normal->id));
                                            if($factor_for_senior_lead_normal && $factor_for_senior_lead_normal->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_normal_seniority_factor]',$factor_for_senior_lead_normal->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_normal_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[senior_lead_normal_id]',$senior_lead_normal->id)."</div>";
                                        }

                                        if(!is_null($senior_lead_high))
                                        {
                                            $factor_for_senior_lead_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_lead_high->id));
                                            if($factor_for_senior_lead_high && $factor_for_senior_lead_high->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_high_seniority_factor]',$factor_for_senior_lead_high->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_high_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[senior_lead_high_id]',$senior_lead_high->id)."</div>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div>Low</div>
                                        <div>Normal</div>
                                        <div>High</div>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($senior_lead_low))
                                        {
                                            $factor_for_senior_lead_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_lead_low->id));
                                            if($factor_for_senior_lead_low && $factor_for_senior_lead_low->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_low_experience_factor]',$factor_for_senior_lead_low->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_low_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($senior_lead_normal))
                                        {
                                            $factor_for_senior_lead_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_lead_normal->id));
                                            if($factor_for_senior_lead_normal && $factor_for_senior_lead_normal->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_normal_experience_factor]',$factor_for_senior_lead_normal->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_normal_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($senior_lead_high))
                                        {
                                            $factor_for_senior_lead_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$senior_lead_high->id));
                                            if($factor_for_senior_lead_high && $factor_for_senior_lead_high->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_high_experience_factor]',$factor_for_senior_lead_high->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[senior_lead_high_experience_factor]','')."</div>";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($senior_lead_low))
                                        {
                                            echo "<div>".$senior_lead_low->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($senior_lead_normal))
                                        {
                                            echo "<div>".$senior_lead_normal->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($senior_lead_high))
                                        {
                                            echo "<div>".$senior_lead_high->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Lead
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($lead_low))
                                        {
                                            $factor_for_lead_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$lead_low->id));
                                            if($factor_for_lead_low && $factor_for_lead_low->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_low_seniority_factor]',$factor_for_lead_low->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_low_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[lead_low_id]',$lead_low->id)."</div>";
                                        }

                                        if(!is_null($lead_normal))
                                        {
                                            $factor_for_lead_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$lead_normal->id));
                                            if($factor_for_lead_normal && $factor_for_lead_normal->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_normal_seniority_factor]',$factor_for_lead_normal->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_normal_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[lead_normal_id]',$lead_normal->id)."</div>";
                                        }

                                        if(!is_null($lead_high))
                                        {
                                            $factor_for_lead_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$lead_high->id));
                                            if($factor_for_lead_high && $factor_for_lead_high->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_high_seniority_factor]',$factor_for_lead_high->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_high_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[lead_high_id]',$lead_high->id)."</div>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div>Low</div>
                                        <div>Normal</div>
                                        <div>High</div>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($lead_low))
                                        {
                                            $factor_for_lead_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$lead_low->id));
                                            if($factor_for_lead_low && $factor_for_lead_low->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_low_experience_factor]',$factor_for_lead_low->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_low_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($lead_normal))
                                        {
                                            $factor_for_lead_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$lead_normal->id));
                                            if($factor_for_lead_normal && $factor_for_lead_normal->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_normal_experience_factor]',$factor_for_lead_normal->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_normal_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($lead_high))
                                        {
                                            $factor_for_lead_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$lead_high->id));
                                            if($factor_for_lead_high && $factor_for_lead_high->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_high_experience_factor]',$factor_for_lead_high->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[lead_high_experience_factor]','')."</div>";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($lead_low))
                                        {
                                            echo "<div>".$lead_low->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($lead_normal))
                                        {
                                            echo "<div>".$lead_normal->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($lead_high))
                                        {
                                            echo "<div>".$lead_high->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tech Officer
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($tech_officer_low))
                                        {
                                            $factor_for_tech_officer_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$tech_officer_low->id));
                                            if($factor_for_tech_officer_low && $factor_for_tech_officer_low->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_low_seniority_factor]',$factor_for_tech_officer_low->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_low_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[tech_officer_low_id]',$tech_officer_low->id)."</div>";
                                        }

                                        if(!is_null($tech_officer_normal))
                                        {
                                            $factor_for_tech_officer_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$tech_officer_normal->id));
                                            if($factor_for_tech_officer_normal && $factor_for_tech_officer_normal->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_normal_seniority_factor]',$factor_for_tech_officer_normal->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_normal_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[tech_officer_normal_id]',$tech_officer_normal->id)."</div>";
                                        }

                                        if(!is_null($tech_officer_high))
                                        {
                                            $factor_for_tech_officer_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$tech_officer_high->id));
                                            if($factor_for_tech_officer_high && $factor_for_tech_officer_high->seniority_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_high_seniority_factor]',$factor_for_tech_officer_high->seniority_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_high_seniority_factor]','')."</div>";
                                            }
                                            echo "<div>".Chtml::hiddenField($pos->position.'[tech_officer_high_id]',$tech_officer_high->id)."</div>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div>Low</div>
                                        <div>Normal</div>
                                        <div>High</div>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($tech_officer_low))
                                        {
                                            $factor_for_tech_officer_low=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$tech_officer_low->id));
                                            if($factor_for_tech_officer_low && $factor_for_tech_officer_low->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_low_experience_factor]',$factor_for_tech_officer_low->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_low_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($tech_officer_normal))
                                        {
                                            $factor_for_tech_officer_normal=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$tech_officer_normal->id));
                                            if($factor_for_tech_officer_normal && $factor_for_tech_officer_normal->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_normal_experience_factor]',$factor_for_tech_officer_normal->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_normal_experience_factor]','')."</div>";
                                            }
                                        }

                                        if(!is_null($tech_officer_high))
                                        {
                                            $factor_for_tech_officer_high=Gamificationfactors::model()->findByAttributes(array("gamificationfactors_positions_id"=>$pos->id,'gamificationmanager_id'=>$tech_officer_high->id));
                                            if($factor_for_tech_officer_high && $factor_for_tech_officer_high->experience_factor>0)
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_high_experience_factor]',$factor_for_tech_officer_high->experience_factor)."</div>";
                                            }
                                            else
                                            {
                                                echo "<div>".Chtml::textField($pos->position.'[tech_officer_high_experience_factor]','')."</div>";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(!is_null($tech_officer_low))
                                        {
                                            echo "<div>".$tech_officer_low->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($tech_officer_normal))
                                        {
                                            echo "<div>".$tech_officer_normal->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        if(!is_null($tech_officer_high))
                                        {
                                            echo "<div>".$tech_officer_high->start_month."</div>";
                                        }
                                        else echo "<div>&nbsp;</div>";
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <div style="text-align: center">
                                <?php echo CHtml::submitButton(Yum::t('Update'));?>
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>
                    <?php
                }
            }
            ?>

            <div id="tabs-add-new-position">
                <?php
                if(!empty($message))
                {
                        echo '<div style="color:red">'.$message.'</div>';
                }
                $form = $this->beginWidget('CActiveForm', array(
                    'id'=>'new-gamificationmanager-form',
                    'enableAjaxValidation'=>false,
                    'action'=>Yum::module('gamificationmanager')->addpositionUrl,
                    'enableClientValidation'=>true,
                ));
                ?>
                <div><?php echo Chtml::label('New position','new-position');?></div>
                <div><?php echo Chtml::textField('new_position','',array('id'=>'new-position'));?></div>

                <div style="text-align: center">
                    <?php echo CHtml::submitButton(Yum::t('Add'));?>
                </div>
                <?php $this->endWidget(); ?>
                <script>
                $(function()
                {
                    $("form#new-gamificationmanager-form").submit(function()
                    {
                        var formArray=$(this).serializeArray();
                        if(formArray[0]['value']!="")
                        {
                            return true
                        }
                        else
                        {
                            alert("Something wrong: Position is required field")
                        }

                        return false;
                    })
                })
                </script>
            </div>

        </div>


</div>
</div>
<script>
    $(function()
    {
        $('a.delete').on('click',function()
        {
            return confirm("Are you sure?")?true:false;
        })
    })
</script>



