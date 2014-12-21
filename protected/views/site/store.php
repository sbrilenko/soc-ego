<?php if(count($stores)>0){?>
<td class="triple">
    <table>
        <tr><td colspan="5" class="padding-zero"> <div class="store-title">STORE</div></td></tr>
        <tr>
            <?php
            foreach($stores as $index=>$item)
            {
                if($index>5) break;
                ?>
                <td class="padding-zero">
                    <?php
                    if(Yii::app()->user->id)
                    {
                        $avatar_id=Store::model()->findByAttributes(array("id"=>$item->id));
                        if($avatar_id)
                        {
                            $file_avatar=Files::model()->findByPk($avatar_id->image);
                            if($file_avatar)
                            {
                                if(file_exists(Yii::app()->basePath."/../files/".$file_avatar->image))
                                {
                                    echo "<div class='text-center'><img class='img-store-main' src='/files/".$file_avatar->image."'/>";
                                }
                                else
                                {
                                    echo '<div class="default-store-main">';
                                }
                            }
                            else
                            {
                                echo '<div class="default-store-main">';
                            }
                        }
                        else
                        {
                            echo '<div class="default-store-main">';
                        }
                    }
                    if($item->stock==1)
                    {
                        ?>
                        <div class="new">new</div>
                    <?php
                    }
                    ?>

                    </div>
                    <div class="store-main-big"><?php echo htmlspecialchars($item->title);?></div>
                    <div class="store-main-little"><?php echo htmlspecialchars((int)$item->price);?></div>
                </td>

            <?php
            }
            ?>
        </tr>
    </table>
</td>
<td class="pad"></td>
<?php } ?>