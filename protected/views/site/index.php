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
        $("#arc1").attr("d", describeArc(80, 80, 40, 0, 220));
    })
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
    <div>
        <table class="quadro-info">
            <tr>
                <td class="quadr">
                    <?php echo $birthday;?>
                </td>
                <td class="pad"></td>
                <td class="quadr">
                <table class="margin-zero">
                   <tr><td class="padding-zero"><div class="info-title">level progress</div></td></tr>
                   <tr><td class='padding-zero center'>
<!--                    <div class='info-diagram'><div class='info-diagram-text'>75</div></div>-->
                    <div class="radial-progress" data-progress="0">
                        <svg>
                            <path id="arc1" fill="orange" stroke="#446688" stroke-width="0" />
                        </svg>
<!--                        <div class="circle">-->
<!--                            <div class="mask full">-->
<!--                                <div class="fill"></div>-->
<!--                            </div>-->
<!--                            <div class="mask half">-->
<!--                                <div class="fill"></div>-->
<!--                                <div class="fill fix"></div>-->
<!--                            </div>-->
<!--                            <div class="shadow"></div>-->
<!--                        </div>-->
<!--                        <div class="inset">-->
<!--                            <div class="percentage">-->
<!--                                <div class="numbers"><span>-</span><span>0</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span><span>15</span><span>16</span><span>17</span><span>18</span><span>19</span><span>20</span><span>21</span><span>22</span><span>23</span><span>24</span><span>25</span><span>26</span><span>27</span><span>28</span><span>29</span><span>30</span><span>31</span><span>32</span><span>33</span><span>34</span><span>35</span><span>36</span><span>37</span><span>38</span><span>39</span><span>40</span><span>41</span><span>42</span><span>43</span><span>44</span><span>45</span><span>46</span><span>47</span><span>48</span><span>49</span><span>50</span><span>51</span><span>52</span><span>53</span><span>54</span><span>55</span><span>56</span><span>57</span><span>58</span><span>59</span><span>60</span><span>61</span><span>62</span><span>63</span><span>64</span><span>65</span><span>66</span><span>67</span><span>68</span><span>69</span><span>70</span><span>71</span><span>72</span><span>73</span><span>74</span><span>75</span><span>76</span><span>77</span><span>78</span><span>79</span><span>80</span><span>81</span><span>82</span><span>83</span><span>84</span><span>85</span><span>86</span><span>87</span><span>88</span><span>89</span><span>90</span><span>91</span><span>92</span><span>93</span><span>94</span><span>95</span><span>96</span><span>97</span><span>98</span><span>99</span><span>100</span></div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <?php
                    echo "</td></tr>";
                    if(User::model()->getLevel(Yii::app()->user->id)==0)
                    {
                        echo '<tr><td class="padding-zero"><div class="info-black last-to-next" data-level="100">0</div></td></tr>';
                    }
                    elseif(User::model()->getLevel(Yii::app()->user->id)==1)
                    {
                        echo '<tr><td class="padding-zero"><div class="info-black last-to-next" data-level="66">0</div></td></tr>';
                    }
                    elseif(User::model()->getLevel(Yii::app()->user->id)==2)
                    {
                        echo '<tr><td class="padding-zero"><div class="info-black last-to-next" data-level="33">0</div></td></tr>';
                    }
                    echo '<tr><td class="padding-zero"><div class="info-mini">left to next level</div></td></tr>'
                    ?>
                    </table>
                </td>
                <td class="pad"></td>
                <td class="quadr">
                    <?php echo $rank;?>
                </td>
                <td class="pad"></td>
                <td class="quadr">
                    <table class="margin-zero">
                    <tr><td class="padding-zero"><div class="info-title">total points</div></td></tr>
                    <tr><td class="padding-zero center">
                        <div class="levelstarsprogress ">
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

                            <div class="clear"></div>
                        </div>
                            <div class="info-black points-style">
                            <?php
                            if(isset(Yii::app()->user->id))
                                {
                                echo (int)User::model()->findByPk(Yii::app()->user->id)->points;
                                }
                                echo '</div>';?>
                    </td></tr>
                    <?php
                    echo '<tr><td class="padding-zero">';
                    echo '<div class="info-black">&nbsp;</div>';
                    echo '<div class="info-mini">scored overall</div></td>';
                    echo '</td></tr>';
                    ?>
                   </table>
                </td>
            </tr>
        </table>
        <table class="store-info">
            <tr>
                <?php echo $store;?>
                <td class="quadr position-relative">
                    <?php
                    echo $company;
                    ?>
                </td>
            </tr>
        </table>


    <table class="pad-mar-zero">
            <tr>
                <td class="projects-main-page-block">
                    <table class="group-wall-title mar-zero">
                        <tr><td class="padding-zero tdone store-head" colspan="2">Projects</td>
                            <td class="padding-zero tdmiddle text-center store-head">Company</td>
<!--                            <td class="padding-zero tdmiddle text-center store-head">Date</td>-->
                            <td class="padding-zero tdlast store-head">Status</td></tr>
                    </table>
                    <div class="group-scroll nano projects-main-page-scroll-height">
                    <table class="group-wall-content nano-content mar-zero">
                        <?php
                        $allmygr=Participants::model()->allGroupsForUser(Yii::app()->user->id);
                        if(count($allmygr)>0)
                        {
                            foreach($allmygr as $index => $group)
                            {
                                echo '<tr>';
                                echo '<td class="padding-zero tdone left-pad white-space-nowrap" colspan="2">';
                                $group_table=Usergroup::model()->findByPk($group->group_id);
                                if($group->group_id && $group_table)
                                {
                                    $file_company=Files::model()->findByPk($group_table->image);
                                    if($file_company)
                                    {
                                        if(file_exists(Yii::app()->basePath."/../files/".$file_company->image))
                                        {
                                            echo "<a href='#'><img class='f-l profile-main-page-img' src='/files/".$file_company->image."'/></a>";
                                        }
                                        else
                                        {
                                            echo "<a href='#'><img class='f-l profile-main-page-img' src='/img/group-default-little.png'/></a>";
                                        }
                                    }
                                    else
                                    {
                                        echo "<a href='#'><img class='f-l profile-main-page-img' src='/img/group-default-little.png'/></a>";
                                    }
                                }
                                else
                                {
                                    echo "<a href='#'><img class='f-l profile-main-page-img' src='/img/group-default-little.png'/></a>";
                                }
                                $user=Profile::model()->findByAttributes(array("user_id"=>$group_table->pm));
                                echo "<div class='project-ver-line f-l'>";
                                echo '<div class="project-title ">'.htmlspecialchars($group_table->title).'</div>';
                                echo '<div class="project-pm">'.htmlspecialchars($user->firstname." ".$user->lastname).'</div>';
                                echo "</div>";
                                echo '</td>';
                                echo '<td class="padding-zero tdmiddle project-ver-line">';
                                echo "<div class='project-company-date text-center'>".htmlspecialchars(Company::model()->findByPk($group_table->company)->title)."</div>";
                                echo '</td>';
//                                echo '<td class="padding-zero tdmiddle project-ver-line">';
//                                echo "<div class='project-company-date text-center'>".date("d/m/Y",strtolower($group_table->time_create))."</div>";
//                                echo '</td>';
                                echo '<td class="padding-zero tdlast project-ver-line">';
                                switch ($group_table->completed)
                                {
                                    case 0:
                                    {
                                        echo "<div class='project-status finished'>Finished</div>";
                                    }
                                    break;
                                    case 1:
                                    {
                                        echo "<div class='project-status active'>Active</div>";
                                    }
                                    break;
                                    case 2:
                                    {
                                        echo "<div class='project-status paused'>Paused</div>";
                                    }
                                    break;
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>

                    </table>
                    </div>
                </td>
                <td class="projects-and-wall-mar"></td>
                <td class="wall-block">
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
                            <table>

                                <?php
                                if(isset($message) and !empty($message))
                                {
                                    echo $message,"<br />";
                                }
                                else
                                {
                                    $comment_m=new Comments();
                                    echo "<tr class='new-comment'>";
                                    echo $form->hiddenField($comment_m,'commented_user_id',array("value"=>Yii::app()->user->id));
                                    echo $form->hiddenField($comment_m,'create_user_id',array("value"=>""));
                                    echo "<td class='pad-zero'>";
                                    echo $form->textField($comment_m,'text',array("placeholder"=>'Enter your message here...','class'=>'comment-text-style'));
                                    echo "</td>";
                                    echo "<td class='parent-file-style'>";
                                    echo "<div class='new-comment-file-b'>";
                                    echo $form->fileField($comment_m,'image',array("class"=>"add-comment-file-icon comment-file-style"));
                                    echo "</div>";
                                    echo "</td>";
                                    echo "<td class='parent-send-button'>";
                                    echo CHtml::submitButton('Send',array('class'=>'send-button'));
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                        <?php $this->endWidget(); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
