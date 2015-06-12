        <div class="main">
            <div class="f-l page-title">
                Groups View
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
                        <div class="main-block-padding pos-relative">
                            <div class="block-table-style">
                                <div class="display-table-cell info-title">
                                    PROGRESS
                                </div>
                            </div>
                            <div class="block-table-style">
                                <div class="display-table-cell groups-circle-block-height">
                                    <svg id="finished-svg"></svg>
                                </div>
                            </div>
                            <div class="block-table-style info-black inside-circle">
                                <div class="display-table-cell" id="finished-number">
                                </div>
                            </div>
                            <div class="block-table-style info-black">
                                <div class="display-table-cell">
                                    Finished
                                </div>
                            </div>
                            <div class="block-table-style info-mini">
                                <div class="display-table-cell">
                                    Projects
                                </div>
                            </div>
                        </div>              
                    </div>
                </div>
                <div class="pad f-l"></div>
                <div class="width-23-5 f-l">
                    <div class="quadr">
                        <div class="main-block-padding pos-relative">
                            <div class="block-table-style">
                                <div class="display-table-cell info-title">
                                    PROGRESS
                                </div>
                            </div>
                            <div class="block-table-style">
                                <div class="display-table-cell groups-circle-block-height">
                                    <svg id="active-svg"></svg>
                                </div>
                            </div>
                            <div class="block-table-style info-black inside-circle">
                                <div class="display-table-cell" id="active-number">
                                </div>
                            </div>
                            <div class="block-table-style info-black">
                                <div class="display-table-cell">
                                    Active
                                </div>
                            </div>
                            <div class="block-table-style info-mini">
                                <div class="display-table-cell">
                                    Projects
                                </div>
                            </div>
                        </div>              
                    </div>
                </div>
                <div class="pad f-l"></div>
                <div class="width-23-5 f-l">
                    <div class="quadr">
                        <div class="main-block-padding pos-relative">
                            <div class="block-table-style">
                                <div class="display-table-cell info-title">
                                    PROGRESS
                                </div>
                            </div>
                            <div class="block-table-style">
                                <div class="display-table-cell groups-circle-block-height">
                                    <svg id="paused-svg"></svg>
                                </div>
                            </div>
                            <div class="block-table-style info-black inside-circle">
                                <div class="display-table-cell" id="paused-number">
                                </div>
                            </div>
                            <div class="block-table-style info-black">
                                <div class="display-table-cell">
                                    Paused
                                </div>
                            </div>
                            <div class="block-table-style info-mini">
                                <div class="display-table-cell">
                                    Projects
                                </div>
                            </div>
                        </div>              
                    </div>
                </div>
                <div class="pad f-l"></div>
                <div class="width-23-5 f-l">
                    <div class="quadr">
                        <div class="main-block-padding pos-relative">
                            <div class="block-table-style">
                                <div class="display-table-cell info-title">
                                    PROGRESS
                                </div>
                            </div>
                            <div class="block-table-style">
                                <div class="display-table-cell groups-circle-block-height">
                                    <svg id="overall-svg"></svg>
                                </div>
                            </div>
                            <div class="block-table-style info-black inside-circle">
                                <div class="display-table-cell" id="overall-number">
                                </div>
                            </div>
                            <div class="block-table-style info-black">
                                <div class="display-table-cell">
                                    Overall
                                </div>
                            </div>
                            <div class="block-table-style info-mini">
                                <div class="display-table-cell">
                                    Projects
                                </div>
                            </div>
                        </div>              
                    </div>
                </div>
                <div class="clear"></div>

            </div>
            

            <div class="pad-mar-zero margin-top">

            <div class="group-recent-projects f-l">
                <div class="recent-projects-block">
                    <div class="group-wall-title mar-zero">
                        <div class="padding-zero recent-projects-head">Recent Projects</div>
                        <div class="clear"></div>
                    </div>
                    
                    <?php if(count($recentmygr)>0)
                        {
                            foreach($recentmygr as $index => $group)
                            { ?>
                            <div tabindex="0" class="group-wall-content mar-zero border-bot">

                                <div class="project-container">
                                    <div class="padding-zero left-pad f-l inline-with-image">
                                        <?php $group_table=Usergroup::model()->findByPk($group->group_id); ?>
                                        <?php if($group->group_id && $group_table)
                                        { ?>
                                                <?php $file_company=Files::model()->findByPk($group_table->image);
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
                                    
                                    <div class="clear"></div>
                                </div>
                                
                            </div>


                        <?php }
                        } else { ?>
                    <div class="project-container recent-empty-text">
                        No projects yet :(
                    </div>
                        <?php 
                    }
                    ?>
                </div>
            </div>
            
            <div class="projects-margin f-l"></div>

            <div class="group-projects f-l">
                <div class="groups-projects-block">
                    <div class="group-wall-title mar-zero">
                        <div class="padding-zero projects-name name-uppercase store-head f-l">Projects</div>
                        <div class="padding-zero projects-company text-center store-head f-l">Company</div>
                        <div class="padding-zero projects-date text-center store-head f-l">Date</div>
                        <div class="padding-zero projects-status store-head f-l">Status</div>
                        <div class="clear"></div>
                    </div>
                    <div class="group-scroll nano has-scrollbar group-scrollbar-height">

                        <div tabindex="0" class="group-wall-content nano-content mar-zero native-scrollbar-hide">

                        <?php if(count($allmygr)>0)
                        {
                            foreach($allmygr as $index => $group)
                            { ?>   
                            <div class="project-container">
                                <div class="padding-zero projects-name left-pad f-l inline-with-image">
                                <?php $group_table=Usergroup::model()->findByPk($group->group_id); ?>
                                <?php if($group->group_id && $group_table)
                                { ?>
                                        <?php $file_company=Files::model()->findByPk($group_table->image);
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
                                <div class="padding-zero projects-company f-l position-relative">
                                    <div class="project-ver-line spec-mar" style="position:absolute;width: 1px;"></div>
                                    <div class=" project-company-name text-center">
                                        <?php echo htmlspecialchars(Company::model()->findByPk($group_table->company)->title);?>
                                    </div>
                                </div>
                                <div class="padding-zero projects-date f-l position-relative">
                                    <div class="project-ver-line spec-mar" style="position:absolute;width: 1px;"></div>
                                    <div class=" project-start-date text-center">
                                        <?php echo htmlspecialchars(date('j/n/Y', $group_table->time_create));?>
                                    </div>
                                </div>
                                <div class="padding-zero projects-status f-l">
                                    <div class="project-ver-line spec-mar f-l" style="width: 1px"></div>
                                    <?php switch ($group_table->completed)
                                    {
                                        case 0:
                                        {
                                         ?>
                                            <div class='groups-project-status finished'>Finished</div>
                                        <?php }
                                        break;
                                        case 1:
                                        {
                                            ?>
                                            <div class='groups-project-status active'>Active</div>
                                        <?php }
                                        break;
                                        case 2:
                                        {
                                        ?>
                                            <div class='groups-project-status paused'>Paused</div>
                                        <?php }
                                        break;
                                    }
                                    ?>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <?php }
                        } else { ?>
                        <div class="empty-projects-container">
                            <div class="paper-plane-img"></div>
                            <div class="empty-text">You are not a member of any group. Please contact your PM.</div>                           
                        </div>
                        <?php }
                        ?>
                        </div>
                        
                        <div class="nano-pane">
                            <div style="height: 500px; transform: translate(0px, 0px);" class="nano-slider"></div>
                        </div>
                    </div>

                </div>
            </div>
                
            
        </div>
        <div class="groups-foot-pad f-l"></div>
    </div>
    <script type="text/javascript">
        // Variables to override by server data.
        var finishedProjects = <?php echo $finished ?>;
        var activeProjects = <?php echo $active ?>;
        var pausedProjects = <?php echo $paused ?>;

        // Calculate circle step per project.

        var overallProjects = finishedProjects + activeProjects + pausedProjects;

        function calculateStep() {
            // Calculates step per one project.
            // -

            return overallProjects > 0 ? 360/(overallProjects) : 0;
        };

        var pi = Math.PI;

        function adPartToSVG(svg, part, color) {
            // Ads new part to given SVG.
            // -

            svg.attr("width", "100").attr("height", "100")
                .append("path")
                .attr("d", part)
                .attr("fill", color)
                .attr("transform", "translate(50, 50)");
        };

        function createPart(startAngle, endAngle) {
            // Creates new circle part.
            // - 

            var part = d3.svg.arc()
                .innerRadius(30)
                .outerRadius(50)
                .startAngle(startAngle * (pi/180))
                .endAngle(endAngle * (pi/180));

            return part;
        }

        $(document).ready(function() {
            // Fill projects quantity.
            $("#finished-number").text(finishedProjects ? finishedProjects : 0);
            $("#active-number").text(activeProjects ? activeProjects : 0);
            $("#paused-number").text(pausedProjects ? pausedProjects : 0);
            $("#overall-number").text(overallProjects ? overallProjects : 0);

            // Drow empty circles.
            var circleFinished = d3.select("#finished-svg");
            var circleActive = d3.select("#active-svg");
            var circlePaused = d3.select("#paused-svg");
            var circleOverall = d3.select("#overall-svg");

            var emptyCircle = createPart(0, 360);

            adPartToSVG(circleFinished, emptyCircle, "#d6dadc");
            adPartToSVG(circleActive, emptyCircle, "#d6dadc");
            adPartToSVG(circlePaused, emptyCircle, "#d6dadc");
            
            // Drow only if user has no projects yet.
            var circleStep = calculateStep();

            if (!circleStep) {
                adPartToSVG(circleOverall, emptyCircle, "#d6dadc");
            };

            // Drow filled parts of each circle.
            if (circleStep) {

                // Calculate start and end points of circles.
                var start = 180;
                var finishedStart = start;

                var finishedEnd, activeStart, activeEnd, pausedStart, pausedEnd;

                if (finishedProjects) {
                    finishedEnd = circleStep*finishedProjects + finishedStart;
                    activeStart = finishedEnd;
                } else {
                    finishedEnd = start;
                    activeStart = start;
                }

                if (activeProjects) {
                    activeEnd = activeStart + activeProjects*circleStep;
                    pausedStart = activeEnd;
                } else {
                    activeEnd = activeStart;
                    pausedStart = activeStart;
                }

                if (pausedProjects) {
                    pausedEnd = pausedStart + pausedProjects*circleStep;
                } else {
                    pausedEnd = pausedStart;
                }

                // Create circle parts.
                var finishedPartSeparate = createPart(finishedStart, finishedEnd);
                var finishedPartOverall = finishedPartSeparate;

                var activePartSeparate = createPart(start, start + circleStep*activeProjects);
                var activePartOverall = createPart(activeStart, activeEnd);

                var pausedPartSeparate = createPart(start, start + circleStep*pausedProjects);
                var pausedPartOverall = createPart(pausedStart, pausedEnd);

                // Append created parts to SVG's.
                adPartToSVG(circleFinished, finishedPartSeparate, "#35DB7F");
                adPartToSVG(circleOverall, finishedPartOverall, "#35DB7F");

                adPartToSVG(circleActive, activePartSeparate, "#FFC047");
                adPartToSVG(circleOverall, activePartOverall, "#FFC047");

                adPartToSVG(circlePaused, pausedPartSeparate, "#DF495E");
                adPartToSVG(circleOverall, pausedPartOverall, "#DF495E");
            }
        });
    </script>
    <script src="/js/d3.js"></script>