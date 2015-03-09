<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/d3.js"></script>
<script>
    function polarToCartesian(centerX, centerY, radius, angleInDegrees) {
        var angleInRadians = (angleInDegrees-90) * Math.PI / 180.0;

        return {
            x: centerX + (radius * Math.cos(angleInRadians)),
            y: centerY + (radius * Math.sin(angleInRadians))
        };
    }

    function describeArc(x, y, radius, startAngle, endAngle){

        var start = polarToCartesian(x, y, radius, endAngle);
        var end = polarToCartesian(x, y, radius, startAngle);

        var arcSweep = endAngle - startAngle <= 180 ? "0" : "1";

        var d = [
            "M", start.x, start.y,
            "A", radius, radius, 0, arcSweep, 0, end.x, end.y,
            "L", x,y,
            "L", start.x, start.y
        ].join(" ");

        return d;
    }
    $(document).ready(function()
    {
        var vis = d3.select("#arc1")
        var pi = Math.PI;
        <?php
        if(User::model()->getLevel(Yii::app()->user->id)==0)
        {
        ?>
        var arc = d3.svg.arc()
            .innerRadius(30)
            .outerRadius(40)
            .startAngle(0 * (pi/180))
            .endAngle(135 * (pi/180))
        var arc1 = d3.svg.arc()
            .innerRadius(30)
            .outerRadius(40)
            .startAngle(135 * (pi/180))
            .endAngle(360 * (pi/180))
        <?php
        }
        elseif(User::model()->getLevel(Yii::app()->user->id)==1)
        {?>
        var arc = d3.svg.arc()
            .innerRadius(30)
            .outerRadius(40)
            .startAngle(0 * (pi/180))
            .endAngle(225* (pi/180))
        var arc1 = d3.svg.arc()
            .innerRadius(30)
            .outerRadius(40)
            .startAngle(225 * (pi/180))
            .endAngle(360 * (pi/180))
        <?php
        }
        elseif(User::model()->getLevel(Yii::app()->user->id)==2){?>
        var arc = d3.svg.arc()
            .innerRadius(30)
            .outerRadius(40)
            .startAngle(0 * (pi/180))
            .endAngle(360 * (pi/180))

        <?php } ?>
        vis.attr("width", "80").attr("height", "80") // Added height and width so arc is visible
            .append("path")
            .attr("d", arc)
            .attr("fill", "#22c9ff")
            .attr("transform", "translate(40,40)");
        if(arc1)
        {
            vis.attr("width", "80").attr("height", "80")
                .append("path")
                .attr("d", arc1)
                .attr("fill", "#d6dadc")
                .attr("transform", "translate(40,40)");
        }


    })

//    $(document).ready(function()
//    {
//        $("#arc1").attr("d", describeArc(80, 80, 40, 60, 220));
//    })
</script>

<script>
    $(document).ready(function(){
        window.randomize = function() {
            <?php
            if(User::model()->findByPk(Yii::app()->user->id)->level==0)
            {

            }elseif(User::model()->findByPk(Yii::app()->user->id)->level==1)
            {
            ?>
                $('.radial-progress').attr('data-progress', Math.floor(0.33*100));
            <?php
            }elseif(User::model()->findByPk(Yii::app()->user->id)->level==2)
            {
            ?>
            $('.radial-progress').attr('data-progress', Math.floor(0.66*100));
            <?php
            }
            ?>

        }
        var datalevel=$(".last-to-next").attr("data-level");
        window.lasttonext=function()
        {
             $(".last-to-next").text(datalevel)
        }
        setTimeout(window.randomize, 200);
        setTimeout(window.lasttonext, 200);
        $('.radial-progress').click(window.randomize);

    });
</script>
<div class="main">
    <div class="f-l main-name-margin-b">
        <div class="main-name-style">
            <?php
            echo $name;
            ?>
        </div>
        <div class="location-icon">
            <?php
            echo $location;
            ?>
        </div>
    </div>
    <div class="f-r blue-message-margin-b">
            <div class="blue-message">
                <div class="big">New Item</div>
                <div class="little">Available on market</div>
            </div>
    </div>
    <div class="clear"></div>
        <div class="quadro-info">
                <div class="width-23-5 f-l">
                    <div class="quadr">
                        <?php echo $birthday;?>
                    </div>
                </div>
                <div class="pad f-l"></div>
                <div class="width-23-5 f-l">
                <div class="quadr">
                   <div class="main-block-padding">
                       <div class="block-table-style padding-zero">
                           <div class="display-table-cell info-title">level progress</div>
                       </div>
                            <div class="block-table-style "><!-- radial-progress -->
                                <div class="display-table-cell block-height">
                                    <svg id="arc1" height="80" width="80" >

                                    </svg>
                                </div>

                            </div>
                            <?php
                            if(User::model()->getLevel(Yii::app()->user->id)==0)
                            {
                                echo '<div class="block-table-style"><div class="display-table-cell info-black last-to-next" data-level="100">0</div></div>';
                            }
                            elseif(User::model()->getLevel(Yii::app()->user->id)==1)
                            {
                                echo '<div class="block-table-style"><div class="display-table-cell info-black last-to-next" data-level="66">0</div></div>';
                            }
                            elseif(User::model()->getLevel(Yii::app()->user->id)==2)
                            {
                                echo '<div class="block-table-style"><div class="display-table-cell info-black last-to-next" data-level="33">0</div></div>';
                            }
                            echo '<div class="block-table-style"><div class="display-table-cell info-mini">left to next level</div></div>';
                            ?>
                   </div>
                </div>
                </div>
                <div class="pad f-l"></div>
                <div class="width-23-5 f-l">
                    <div class="quadr">
                        <?php echo $rank;?>
                    </div>
                </div>
                <div class="pad f-l"></div>
                <div class="width-23-5 f-l">
                <div class="quadr">
                    <div class="main-block-padding">
                        <div class="block-table-style"><div class="display-table-cell info-title">total points</div></div>
                        <div class="block-height">
                            <div class="block-table-style levelstarsprogress-parent">
                                <div class="display-table-cell levelstarsprogress">
                                    <?php
                                    if(User::model()->getLevel(Yii::app()->user->id)==0)
                                    {
                                    ?>
                                        <div class="levelstars active"></div>
                                        <div class="levelstars padd"></div>
                                        <div class="levelstars"></div>
                                    <?php
                                    }elseif(User::model()->getLevel(Yii::app()->user->id)==1)
                                    {
                                    ?>
                                        <div class="levelstars active"></div>
                                        <div class="levelstars active padd"></div>
                                        <div class="levelstars"></div>
                                    <?php
                                    }elseif(User::model()->getLevel(Yii::app()->user->id)==2)
                                    {
                                    ?>
                                        <div class="levelstars active"></div>
                                        <div class="levelstars active padd"></div>
                                        <div class="levelstars active"></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="block-table-style">
                                <div class="display-table-cell info-black points-style">
                                    <?php
                                    if(isset(Yii::app()->user->id))
                                    {
                                        echo (int)User::model()->findByPk(Yii::app()->user->id)->points;
                                    }
                                    ?>
                               </div>
                            </div>
                        </div>
                        <div class="block-table-style">
                            <div class="display-table-cell info-black">&nbsp;</div>
                        </div>
                        <div class="block-table-style">
                            <div class="display-table-cell info-mini">scored overall</div>
                        </div>
                   </div>
                </div>
                </div>
            </div>
         <div class="clear"></div>
        <div class="store-info f-l margin-top">
            <?php echo $store;?>
        </div>
        <?php if(!empty($store)) echo '<div class="pad f-l margin-top"></div>';?>
         <div class="width-23-5 f-l margin-top ">
                <div class="quadr">
                    <div class="main-block-padding">
                        <?php echo $company; ?>
                    </div>
                </div>
         </div>
         <div class="clear"></div>

    <div class="pad-mar-zero margin-top">
                <div class="projects-main-page-width  f-l">
                <div class="projects-main-page-block">
                    <div class="group-wall-title mar-zero">
                        <div class="padding-zero tdone store-head f-l">Projects</div>
                        <div class="padding-zero tdmiddle text-center store-head f-l">Company</div>
                        <div class="padding-zero tdlast store-head f-l">Status</div>
                        <div class="clear"></div>
                    </div>
                    <div class="group-scroll nano projects-main-page-scroll-height">
                    <div class="group-wall-content nano-content mar-zero">
                        <?php
                        $allmygr=Participants::model()->allGroupsForUser(Yii::app()->user->id);
                        if(count($allmygr)>0)
                        {
                            foreach($allmygr as $index => $group)
                            {
                                ?>
                                <div style="padding: 18px 16px;">
                                <div class="padding-zero tdone left-pad white-space-nowrap f-l">
                                <?php $group_table=Usergroup::model()->findByPk($group->group_id); ?>
                                <?php if($group->group_id && $group_table)
                                {
                                    $file_company=Files::model()->findByPk($group_table->image);
                                    if($file_company)
                                    {
                                        if(file_exists(Yii::app()->basePath."/../files/".$file_company->image))
                                        {
                                        ?>
                                        <a href='#' class="f-l"><img class='f-l profile-main-page-img' src='/files/<?php echo $file_company->image;?>'/></a>
                                        <?php }
                                        else
                                        {
                                        ?>
                                            <a href='#' class="f-l"><img class='f-l profile-main-page-img' src='/img/group-default-little.png'/></a>
                                        <?php }
                                    }
                                    else
                                    {
                                    ?>
                                        <a href='#' class="f-l"><img class='f-l profile-main-page-img' src='/img/group-default-little.png'/></a>
                                    <?php }
                                }
                                else
                                {
                                ?>
                                    <a href='#' class="f-l"><img class='f-l profile-main-page-img' src='/img/group-default-little.png'/></a>
                                <?php }
                                $user=Profile::model()->findByAttributes(array("user_id"=>$group_table->pm));
                                ?>
                                <div class='f-l'>
                                    <div class="project-title">
                                        <?php echo htmlspecialchars($group_table->title);?>
                                    </div>
                                    <div class="project-pm">
                                        <?php echo htmlspecialchars($user->firstname." ".$user->lastname);?>
                                    </div>
                                    </div>
                                </div>
                                <div class="padding-zero tdmiddle f-l position-relative">
                                    <div class="project-ver-line spec-mar" style="position:absolute;width: 1px;"></div>
                                    <div class=' project-company-date text-center f-l'>
                                        <?php echo htmlspecialchars(Company::model()->findByPk($group_table->company)->title);?>
                                    </div>
                                </div>
<!--                                <div class="padding-zero tdmiddle project-ver-line f-l">-->
<!--                                    <div class='project-company-date text-center f-l'>-->
<!--                                        --><?php //echo date("d/m/Y",strtolower($group_table->time_create));?>
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="padding-zero tdlast f-l">
                                    <div class="project-ver-line spec-mar f-l" style="width: 1px"></div>
                                <?php switch ($group_table->completed)
                                {
                                    case 0:
                                    {
                                     ?>
                                        <div class='project-status finished f-l'>Finished</div>
                                    <?php }
                                    break;
                                    case 1:
                                    {
                                        ?>
                                        <div class='project-status active f-l'>Active</div>
                                    <?php }
                                    break;
                                    case 2:
                                    {
                                    ?>
                                        <div class='project-status paused f-l'>Paused</div>
                                    <?php }
                                    break;
                                }
                                ?>
                                </div>
                                    <div class="clear"></div>
                                 </div>
                            <?php }
                        }
                        ?>

                    </div>
                    </div>
                </div>
                </div>
                <div class="projects-and-wall-mar f-l"></div>
                <div class="wall-block-w f-l">
                <div class="wall-block">
                    <div class="group-wall-title">Wall</div>
                   <div class="before-wall-content">
                    <div class="wall-content nano wall-block-scroll-height">
                    <?php
                        $comments=Comments::model()->findAllByAttributes(array("parent"=>0,"commented_user_id"=>Yii::app()->user->id),array('order'=>'time ASC'));
                        if($comments)
                        {
                            echo "<div class='wall nano-content wall-block-scroll-height'>";
                            foreach($comments as $index=>$com)
                            {
                                echo $this->renderPartial("message",array("com"=>$com,'index'=>$index),true);
                            }
                            echo "</div>";
                        }
//                        ?>
                    </div>
                    </div>
                    <script>
                        $(document).ready(function()
                        {
                            $(document).on('submit','form#addcomments-form',function()
                            {
//                                var fd =$(this).serializeArray();
                                var th=$(this);
                                var formElement = document.getElementById("addcomments-form");
                                var fd = new FormData(formElement);
                                console.log(fd)
                                $.ajax({
                                    url: "CommentsAdd",
                                    type: "POST",
                                    data: fd,
                                    enctype: 'multipart/form-data',
                                    processData: false,
                                    contentType: false,
                                    dataType: "json",
                                    success: function (data, textStatus) {
                                        console.log(data)
                                        //data=$.parseJSON(data);
                                        if(data.error)
                                        {

                                        }
                                        else
                                        {
                                            $(".wall").append(data.html)
                                            th.find("input[name*=text]").val("");
                                            setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                                        }
                                    }
                                })
                                return false
                            }).on('submit','form.comment-comment-form',function(e)
                            {
                                    var th= $(this);
                                    var fd = th.serializeArray();
                                    $.ajax({
                                        url: "CommentsCommentsAdd",
                                        type: "POST",
                                        data: fd,
                                        dataType: "json",
                                        success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                                            //data=$.parseJSON(data);
                                            console.log(data)
                                            if(data.error)
                                            {
                                                console.log(data.message)
                                            }
                                            else
                                            {
                                                th.find("input[name*=text]").val("")
                                                $(data.html).insertBefore(th.parents("table")[0])
                                            }
                                        }
                                    })
                                return false
                            }).on('click','.like-icon',function()
                            {
                                var th= $(this);
                                var form=th.find('div').clone();
                                var fd = th.find('form').serializeArray();
                                $.ajax({
                                    url: "like",
                                    type: "POST",
                                    data: fd,
                                    dataType: "json",
                                    success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                                        //data=$.parseJSON(data);
                                        if(data.error)
                                        {
                                            console.log(data.message)
                                        }
                                        else
                                        {
                                            th.text(data.message)
                                            th.append(form)
                                        }
                                    }
                                })
                            })
                            return false
                        })
                    </script>
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id'=>'addcomments-form',
                            'enableAjaxValidation'=>true,
                            'enableClientValidation'=>true,
                            'htmlOptions' => array('enctype' => 'multipart/form-data',"class"=>"addcomments-form")
                        ));
                        ?>
                            <div>

                                <?php
                                if(isset($message) and !empty($message))
                                {
                                    echo $message,"<br />";
                                }
                                else
                                {
                                    $comment_m=new Comments();
                                    echo "<div class='new-comment'>";
                                    echo $form->hiddenField($comment_m,'commented_user_id',array("value"=>Yii::app()->user->id));
                                    echo $form->hiddenField($comment_m,'create_user_id',array("value"=>""));
                                    echo "<div class='pad-zero'>";
                                    echo $form->textField($comment_m,'text',array("placeholder"=>'Enter your message here...','class'=>'comment-text-style'));
                                    echo "</div>";
                                    echo "<div class='parent-file-style'>";
                                    echo "<div class='new-comment-file-b'>";
                                    echo $form->fileField($comment_m,'image',array("class"=>"add-comment-file-icon comment-file-style"));
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<div class='parent-send-button'>";
                                    echo CHtml::submitButton('Send',array('class'=>'send-button'));
                                    echo "</div>";
                                    echo "</div>";
                                }
                                ?>
                            </div>
                        <?php $this->endWidget(); ?>
                </div>
                </div>
        </div>
</div>
