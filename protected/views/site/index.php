<?php
//Yii::app()->clientScript->registerScriptFile('/js/less.min.js', CClientScript::POS_HEAD);
?>
<script>
    $(document).ready(function(){
//        $('head style[type="text/css"]').attr('type', 'text/less');
//        less.refreshStyles();
        window.randomize = function() {
            $('.radial-progress').attr('data-progress', Math.floor(0.33*100));
        }
        setTimeout(window.randomize, 200);
        $('.radial-progress').click(window.randomize);
        //Open a WebSocket connection.
        var wsUri = "ws://soc-ego/socket";
//        var socket = new WebSocket("ws://localhost:8081");

        websocket = new WebSocket("ws://0.0.0.0:8000");

        //Connected to server
        websocket.onopen = function(ev) {
            console.log('Connected to server', ev)
        }

        //Connection close
        websocket.onclose = function(ev) {
            console.log('Disconnected',ev)
        };

        //Message Receved
        websocket.onmessage = function(ev) {
            console.log('Message ',ev)
        };

        //Error
        websocket.onerror = function(ev) {
            console.log('Error ',ev)
        };

        //Send a Message
        $('#send').click(function(){
            var mymessage = 'This is a test message';
            websocket.send(mymessage);
        });
    });
</script>
<div class="main">
    <div class="f-l main-name-margin-b">
        <div class="main-name-style">
            <?php
            if(isset(Yii::app()->user->id))
            {
                $user=Profile::model()->findByAttributes(array("user_id"=>Yii::app()->user->id));
                echo $user->firstname," ",$user->lastname;
            }
            ?>
        </div>
        <div class="location-icon">
            <?php
            if(isset(Yii::app()->user->id))
            {
                $user=Profile::model()->findByAttributes(array("user_id"=>Yii::app()->user->id));
                if($user)
                {
                    $location=LocationManager::model()->findByPk($user->user_location);
                    if($location)
                    {
                        echo $location->locationname;
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="f-r blue-message-margin-b">
            <div class="blue-message">
                <div class="big">New Item</div>
                <div class="little">Available on market</div>
            </div>
    </div>
    <div>
        <table class="quadro-info">
            <tr>
                <td class="quadr">
                    <table class="margin-zero">
                    <tr>
                        <td class="padding-zero"><div class="info-title">birthday</div></td>
                    </tr>
                    <tr>
                        <td class="padding-zero text-center">
                        <?php
                    if(isset(Yii::app()->user->id))
                    {
                        $profile=Profile::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
                        $bday=date("d",$profile->bday);
                        $bmonth=date("m",$profile->bday);
                        $signs_img = array("capricorn.png", "aquarius.png", "pisces.png", "aries.png", "taurus.png", "gemini.png", "cancer.png", "leo.png", "virgo.png", "libra.png", "Scorpio.png", "Sagittarius.png");
                        $signs = array("capricorn", "aquarius", "pisces", "aries", "taurus", "gemini", "cancer", "leo", "virgo", "libra", "Scorpio", "Sagittarius");
                        $signsstart = array(1 => 21, 2 => 20, 3 => 20, 4 => 20, 5 => 20, 6 => 20, 7 => 21, 8 => 22, 9 => 23, 10 => 23, 11 => 23, 12 => 23);
                        echo "<img src='/img/";
                        echo $bday < $signsstart[$bmonth + 1] ? $signs_img[$bmonth - 1] : $signs_img[$bmonth%12];
                        echo "' />";
                    }
                    echo "</td></tr>";
                    echo '<tr><td class="padding-zero"><div class="info-black">'.date("d.m.Y",$profile->bday).'</div></td></tr>';
                    echo '<tr><td class="padding-zero"><div class="info-mini">';
                    echo $bday < $signsstart[$bmonth + 1] ? $signs[$bmonth - 1] : $signs[$bmonth % 12];
                    echo '</div></td></tr>'
                    ?>
                    </table>
                </td>
                <td class="pad"></td>
                <td class="quadr">
                <table class="margin-zero">
                    <tr><td class="padding-zero"><div class="info-title">level progress</div></td></tr>
                    <?php
                    echo "<tr><td class='padding-zero'>";
                    ?>
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
                    echo '<tr><td class="padding-zero"><div class="info-black">25</div></td></tr>';
                    echo '<tr><td class="padding-zero"><div class="info-mini">left to next level</div></td></tr>'
                    ?>
                    </table>
                </td>
                <td class="pad"></td>
                <td class="quadr">
                    <table class="margin-zero">
                        <tr><td class="padding-zero"><div class="info-title">rank</div></td></tr>
                        <?php
                        echo "<tr><td class='padding-zero'>";
                        $user_rank=User::model()->findByPk(Yii::app()->user->id);
                        $rank_class=null;
                        if($user_rank)
                        {
                            switch ($user_rank->job_type){
                                case "Developers":
                                    switch ($user_rank->job_title)
                                    {
                                        case "Youngling":
                                            $rank_class="developers-rank-1";
                                        break;
                                        case "Padawan":
                                            $rank_class="developers-rank-2";
                                        break;
                                        case "Jedi":
                                            $rank_class="developers-rank-3";
                                        break;
                                        case "Jedi Survivor":
                                            $rank_class="developers-rank-4";
                                        break;
                                        case "Jedi Knight":
                                            $rank_class="developers-rank-5";
                                        break;
                                        case "Master Jedi":
                                            $rank_class="developers-rank-6";
                                        break;
                                        case "The Chosen One":
                                            $rank_class="developers-rank-7";
                                        break;
                                        case "Yoda":
                                            $rank_class="developers-rank-8";
                                        break;
                                    }
                                break;
                                case "Pm":
                                    switch ($user_rank->job_title)
                                    {
                                        case "Pixie":
                                            $rank_class="pms-rank-1";
                                            break;
                                        case "Tinker Bell":
                                            $rank_class="pms-rank-2";
                                            break;
                                        case "Tinker Bell":
                                            $rank_class="pms-rank-3";
                                            break;
                                        case "Fairy":
                                            $rank_class="pms-rank-4";
                                            break;
                                        case "Djinni":
                                            $rank_class="pms-rank-5";
                                            break;
                                        case "Witch":
                                            $rank_class="pms-rank-6";
                                            break;
                                        case "Snow Queen":
                                            $rank_class="pms-rank-7";
                                            break;
                                        case "Cruella De Vil":
                                            $rank_class="pms-rank-8";
                                            break;
                                    }
                                    break;
                                    case "Designer":
                                    switch ($user_rank->job_title)
                                    {
                                        case "Muggle/Gunter":
                                            $rank_class="designers-rank-1";
                                            break;
                                        case "Muggle-born/Peppermint Butler":
                                            $rank_class="designers-rank-2";
                                            break;
                                        case "House-elf/Jake the Dog":
                                            $rank_class="designers-rank-3";
                                            break;
                                        case "Wizard/Fin":
                                            $rank_class="designers-rank-4";
                                            break;
                                        case "Metamorphmagus/Billy":
                                            $rank_class="designers-rank-5";
                                            break;
                                        case "Auror The/Ice King":
                                            $rank_class="designers-rank-6";
                                            break;
                                        case "Albus Dumbledore/The Lich":
                                            $rank_class="designers-rank-7";
                                            break;
                                        case "Lord Voldemort/Lemongrab":
                                            $rank_class="designers-rank-8";
                                            break;
                                    }
                                    break;
                                case "Qa":
                                    switch ($user_rank->job_title)
                                    {
                                        case "Gremlin":
                                            $rank_class="qas-rank-1";
                                            break;
                                        case "Elf":
                                            $rank_class="qas-rank-2";
                                            break;
                                        case "Leprechaun":
                                            $rank_class="qas-rank-3";
                                            break;
                                        case "Warlock":
                                            $rank_class="qas-rank-4";
                                            break;
                                        case "Whitelighter":
                                            $rank_class="qas-rank-5";
                                            break;
                                        case "Sorcerer":
                                            $rank_class="qas-rank-6";
                                            break;
                                        case "Driad":
                                            $rank_class="qas-rank-7";
                                            break;
                                        case "Merlin":
                                            $rank_class="qas-rank-8";
                                            break;
                                    }
                                    break;
                                case "Hr":
                                    switch ($user_rank->job_title)
                                    {
                                        case "Flora":
                                            $rank_class="hrs-rank-1";
                                            break;
                                        case "Demeter":
                                            $rank_class="hrs-rank-2";
                                            break;
                                        case "Terra":
                                            $rank_class="hrs-rank-3";
                                            break;
                                        case "Aurora":
                                            $rank_class="hrs-rank-4";
                                            break;
                                        case "Luna":
                                            $rank_class="hrs-rank-5";
                                            break;
                                        case "Aphrodite":
                                            $rank_class="hrs-rank-6";
                                            break;
                                        case "Athena":
                                            $rank_class="hrs-rank-7";
                                            break;
                                        case "Artemis":
                                            $rank_class="hrs-rank-8";
                                            break;
                                    }
                                    break;
                                case "V.I.P.":
                                    switch ($user_rank->job_title)
                                    {
                                        case "Iron Man":
                                            $rank_class="vip-rank-1";
                                            break;
                                        case "Captain America":
                                            $rank_class="vip-rank-2";
                                            break;
                                        case "Magneto":
                                            $rank_class="vip-rank-3";
                                            break;
                                        case "Rogue":
                                            $rank_class="vip-rank-4";
                                            break;
                                    }
                                    break;
                            }
                        }
                        echo "<div class='{$rank_class}'></div>";
                        echo "</td></tr>";
                        echo '<tr><td class="padding-zero"><div class="info-black">'.$user_rank->job_title.'</div></td></tr>';
                        echo '<tr><td class="padding-zero"><div class="info-mini">'.$user_rank->job_type.'</div></td></tr>'
                        ?>
                    </table>
                </td>
                <td class="pad"></td>
                <td class="quadr">
                    <table class="margin-zero">
                    <tr><td><div class="info-title">total points</div></td></tr>
                    <tr><td><div class="levelstarsprogress">
                        <div class="levelstars active"></div>
                        <div class="levelstars active padd"></div>
                        <div class="levelstars"></div>
                        <div class="clear"></div>
                    </div>
                    </td></tr>
                    <?php
                    echo '<tr><td><div class="info-black marg-bot points-style">';
                    if(isset(Yii::app()->user->id))
                    {
                        echo (int)User::model()->findByPk(Yii::app()->user->id)->points;
                    }
                    echo '</div></td></tr>';
                    echo '<tr><td><div class="info-mini">scored overall</div></td></tr>'
                    ?>
                   </table>
                </td>
            </tr>
        </table>
        <?php if(count(Store::model()->findAllByAttributes(array("hide"=>0)))>0) { ?>
        <table class="store-info">
            <tr>
                <?php
                $store_items=Store::model()->findAllByAttributes(array("hide"=>0));
                foreach($store_items as $index=>$item)
                {
                    if($index>5) break;
                ?>
                    <td class="triple">
                        <table>
                            <tr><td colspan="5"> <div class="store-title">STORE</div></td></tr>
                            <tr>
                                <td>
                                    <div class="default-store-main">
                                        <div class="new">new</div>
                                    </div>
                                    <div class="store-main-big">Store Item 1</div>
                                    <div class="store-main-little">issue1</div>
                                </td>
                                <td>
                                    <div class="default-store-main">
                                        <div class="new">new</div>
                                    </div>
                                    <div class="store-main-big">Store Item 2</div>
                                    <div class="store-main-little">issue2</div>
                                </td>
                                <td>
                                    <div class="default-store-main">
                                        <div class="new">new</div>
                                    </div>
                                    <div class="store-main-big">Store Item 3</div>
                                    <div class="store-main-little">issue3</div>
                                </td>
                                <td><div class="default-store-main"></div>
                                    <div class="store-main-big">Store Item 4</div>
                                    <div class="store-main-little">issue4</div>
                                </td>
                                <td><div class="default-store-main"></div>
                                    <div class="store-main-big">Store Item 5</div>
                                    <div class="store-main-little">issue5</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="pad"></td>
                <?php
                }
                ?>
                <td class="quadr">
                    <div class="info-title">COMPANY</div>
                    <?php
                    $company_id=Company::model()->findByAttributes(array("id"=>User::model()->findByPk(Yii::app()->user->id)->company_id));
                    if($company_id)
                    {
                        $file_company=Files::model()->findByPk($company_id->image);
                        if($file_company)
                        {
                            if(file_exists(Yii::app()->basePath."/../files/".$file_company->image))
                            {
                                echo "<img style='padding: 0;' src='/files/".$file_company->image."'/>";
                            }
                        }
                    }
                    ?>
                </td>
            </tr>
        </table>
        <?php } ?>
        <table style="padding: 0;margin: 0;">
            <tr>
                <td width="51" style="padding: 0;border:1px solid #eaeaea;border-radius: 6px;height:640px;vertical-align: top;background: #fff;">
                    <div class="group-wall-title">Projects</div>
                </td>
                <td width="4" style="padding: 0"></td>
                <td width="45" style="position:relative;padding: 0;border:1px solid #eaeaea;border-radius: 6px;height:640px;vertical-align: top;background: #fff;">
                    <div class="group-wall-title">Wall</div>
                    <div class="wall-content" style="padding: 25px 25px 0 25px;">
                        <div style="height: 502px;" class="all-comments">
                        <?php
                        $comments=Comments::model()->findAllByAttributes(array("commented_user_id"=>$id),array('order'=>'time DESC'));
                        if($comments)
                        {
                            echo "<ul class='wall'>";
                            foreach($comments as $com)
                            {
                                echo "<li>";
                                if(!empty($com->image))
                                {
                                    $comm_image=Files::model()->findByPk($com->image);
                                    if($comm_image)
                                    {
                                        if(file_exists(Yii::app()->basePath."/../files/".$comm_image->image))
                                        {
                                            echo "<div class='text-center'><img src='/files/".$comm_image->image."'/></div>";
                                        }
                                    }
                                }
                                echo "<div>".$com->text."</div>";
                                echo "</li>";
                            }
                            echo "</ul>";
                        }
                        ?>
                        </div>
                        </div>
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id'=>'addcomments-form',
                            'enableAjaxValidation'=>true,
                            'enableClientValidation'=>true,
                            'action'=>'',
                            'htmlOptions' => array('enctype' => 'multipart/form-data',"style"=>"position:absolute;bottom:0;width:100%;")
                        ));
                        ?>
                        <div style="padding:9px;background-color:#e8e8e8;height: 40px;">
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
                                    echo $form->hiddenField($comment_m,'commented_user_id',array("value"=>"")); //
                                    echo $form->hiddenField($comment_m,'create_user_id',array("value"=>"")); //who comment
                                    echo "<td class='new-comment-file-b' style='padding: 0;width: 40px;'>";
                                    echo $form->fileField($comment_m,'image',array("class"=>"add-comment-file-icon"));
                                    echo "</td>";
                                    echo "<td style='padding: 0'>";
                                    echo $form->textField($comment_m,'text',array("placeholder"=>'Enter your message here...','style'=>'border:0;padding:0 5%;width:90%;height:100%;'));
                                    echo "</td>";
                                    echo "<td style='padding: 0;width:72px;'>";
                                    echo CHtml::submitButton('Send',array('class'=>'','style'=>"border:0;padding:0;background:url('../img/comment-send-button.png')no-repeat;width:72px;height:100%;color:#fff"));
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                        </div>
                        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                        <script>
                            $(function()
                            {
                                $('form#addcomments-form').submit(function()
                                {
                                    //$(this).serializeArray()
                                    var fd = new FormData(document.getElementById("addcomments-form"));
//          fd.append("label", "WEBUPLOAD");
//          console.log(fd)
                                    $.ajax({
                                        url: "/commentsadd",
                                        type: "POST",
                                        data: fd,
                                        enctype: 'multipart/form-data',
                                        processData: false,  // tell jQuery not to process the data
                                        contentType: false,   // tell jQuery not to set contentType
                                        success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                                            data=$.parseJSON(data);
                                            var html="<li>";

                                            if(data.image!="")
                                            {
                                                html+="<div class='text-center'><img src='"+data.image+"' /></div>";
                                            }
                                            if(data.text!="")
                                            {
                                                html+="<div>"+data.text+"</div>";
                                            }
                                            html+="</li>";
                                            if(html!="")
                                            {
                                                $(html).insertBefore($('.wall li:first'))
                                                $(".new-comment textarea").val("")
                                                $(".new-comment input[type=file]").replaceWith('<input name="Comments[image]" id="Comments_image" type="file">')
                                            }
                                        }
                                    })
                                    return false
                                })
                            })
                        </script>
                        <?php $this->endWidget(); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
