<?php if(count($stores)>0){?>
<div class="triple f-l">
        <div class="main-block-padding">
        <div class="block-table-style">
            <div class="display-table-cell store-title">STORE</div>
        </div>
            <div class="block-table-style">
            <?php
            foreach($stores as $index=>$item)
            {
                if($index>5) break;
                ?>
                <div class="display-table-cell">
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
                                    echo "<div class='text-center'><img class='img-store-main' src='/files/".$file_avatar->image."'/></div>";
                                }
                                else
                                {
                                    echo '<div class="default-store-main"></div>';
                                }
                            }
                            else
                            {
                                echo '<div class="default-store-main"></div>';
                            }
                        }
                        else
                        {
                            echo '<div class="default-store-main"></div>';
                        }
                    }
                    if($item->stock==1)
                    {
                    ?>
                        <div class="new">new</div>
                    <?php
                    }
                    ?>
                    <div class="store-main-big"><?php echo htmlspecialchars($item->title);?></div>
                    <div class="store-main-little"><?php echo htmlspecialchars((int)$item->price);?></div>
                </div>
            <?php
            }
            ?>
            </div>
    </div>
</div>
<?php } ?>