<script>
    $(document).ready(function(){
//        $('head style[type="text/css"]').attr('type', 'text/less');
//        less.refreshStyles();
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
           // echo $location;
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
                        <div class="circle">
                            <div class="mask full">
                                <div class="fill"></div>
                            </div>
                            <div class="mask half">
                                <div class="fill"></div>
                                <div class="fill fix"></div>
                            </div>
                            <div class="shadow"></div>
                        </div>
                        <div class="inset">
                            <div class="percentage">
                                <div class="numbers"><span>-</span><span>0</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span><span>15</span><span>16</span><span>17</span><span>18</span><span>19</span><span>20</span><span>21</span><span>22</span><span>23</span><span>24</span><span>25</span><span>26</span><span>27</span><span>28</span><span>29</span><span>30</span><span>31</span><span>32</span><span>33</span><span>34</span><span>35</span><span>36</span><span>37</span><span>38</span><span>39</span><span>40</span><span>41</span><span>42</span><span>43</span><span>44</span><span>45</span><span>46</span><span>47</span><span>48</span><span>49</span><span>50</span><span>51</span><span>52</span><span>53</span><span>54</span><span>55</span><span>56</span><span>57</span><span>58</span><span>59</span><span>60</span><span>61</span><span>62</span><span>63</span><span>64</span><span>65</span><span>66</span><span>67</span><span>68</span><span>69</span><span>70</span><span>71</span><span>72</span><span>73</span><span>74</span><span>75</span><span>76</span><span>77</span><span>78</span><span>79</span><span>80</span><span>81</span><span>82</span><span>83</span><span>84</span><span>85</span><span>86</span><span>87</span><span>88</span><span>89</span><span>90</span><span>91</span><span>92</span><span>93</span><span>94</span><span>95</span><span>96</span><span>97</span><span>98</span><span>99</span><span>100</span></div>
                            </div>
                        </div>
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
                <td class="quadr" style="position: relative;">
                    <?php
                    echo $company;
                    ?>
                </td>
            </tr>
        </table>


    <table style="padding: 0;margin: 0;">
            <tr>
                <td style="width:53%;padding: 0;border:1px solid #eaeaea;border-radius: 6px;height:640px;vertical-align: top;background: #fff;">
                    <table class="group-wall-title" style="margin: 0;">
                        <tr><td class="padding-zero tdone store-head" colspan="2">Projects</td>
                            <td class="padding-zero tdmiddle text-center store-head">Company</td>
<!--                            <td class="padding-zero tdmiddle text-center store-head">Date</td>-->
                            <td class="padding-zero tdlast store-head">Status</td></tr>
                    </table>
                    <div class="group-scroll nano" style="height: 584px;">
                    <table class="group-wall-content nano-content" style="margin: 0;">
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
                                            echo "<a href='#'><img class='f-l' style='padding: 0;width:36px;height:36px;' src='/files/".$file_company->image."'/></a>";
                                        }
                                        else
                                        {
                                            echo "<a href='#'><img class='f-l' style='padding: 0;width:36px;height:36px;' src='/img/group-default-little.png'/></a>";
                                        }
                                    }
                                    else
                                    {
                                        echo "<a href='#'><img class='f-l' style='padding: 0;width:36px;height:36px;' src='/img/group-default-little.png'/></a>";
                                    }
                                }
                                else
                                {
                                    echo "<a href='#'><img class='f-l' style='padding: 0;width:36px;height:36px;' src='/img/group-default-little.png'/></a>";
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
                <td style="padding: 0;width:2%;"></td>
                <td style="overflow:hidden;width:45%;position:relative;padding: 0;border:1px solid #eaeaea;vertical-align: top;border-radius: 6px;height:640px;background: #fff;">
                    <div class="group-wall-title">Wall</div>
                   <div class="before-wall-content">
                    <div class="wall-content nano" style='height: 527px;'>
                    <?php
                        $comments=Comments::model()->findAllByAttributes(array("parent"=>0,"commented_user_id"=>Yii::app()->user->id),array('order'=>'time ASC'));
                        if($comments)
                        {
                            echo "<div class='wall nano-content' style='height: 527px;'>";
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
                                    processData: false,  // tell jQuery not to process the data
                                    contentType: false,   // tell jQuery not to set contentType
                                    success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                                        console.log(data)
                                        data=$.parseJSON(data);
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
                                        success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                                            data=$.parseJSON(data);
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
                                    success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                                        data=$.parseJSON(data);
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
                            'htmlOptions' => array('enctype' => 'multipart/form-data',"style"=>"position:absolute;bottom:0;width:100%;height: 58px;")
                        ));
                        ?>
                            <table style="padding:9px;background-color:#e8e8e8;height: 40px;">

                                <?php
                                if(isset($message) and !empty($message))
                                {
                                    echo $message,"<br />";
                                }
                                else
                                {
                                    $comment_m=new Comments();
                                    echo "<tr class='new-comment'>";
                                    echo $form->hiddenField($comment_m,'commented_user_id',array("value"=>"")); //
                                    echo $form->hiddenField($comment_m,'create_user_id',array("value"=>"")); //who comment
                                    echo "<td class='new-comment-file-b' style='padding: 0;width: 40px;'>";
                                    echo $form->fileField($comment_m,'image',array("class"=>"add-comment-file-icon"));
                                    echo "</td>";
                                    echo "<td style='padding: 0'>";
                                    echo $form->textField($comment_m,'text',array("placeholder"=>'Enter your message here...','style'=>'height:40px;border:0;padding:0 5%;width:90%;'));
                                    echo "</td>";
                                    echo "<td style='padding: 0;width:72px;'>";
                                    echo CHtml::submitButton('Send',array('class'=>'','style'=>"height:40px;border:0;padding:0;background-color: #22c9ff;border-radius: 0 5px 5px 0;width:72px;color:#fff"));
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
