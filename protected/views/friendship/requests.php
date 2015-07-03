<?php if(count($friendrequest)>0) { ?>
    <div class="nano has-scrollbar friends-requests-scrollbar-height">

    <div tabindex="0" class="friends-wall-content nano-content mar-zero native-scrollbar-hide">
        <?php foreach($friendrequest as $request) {?>
            <div class="friend-container">
                <!--                --><?php
                //                $form = $this->beginWidget('CActiveForm', array(
                //                    'id'=>'requests-form-'.uniqid(),
                //                    'enableAjaxValidation'=>true,
                //                    'enableClientValidation'=>true,
                //                    'htmlOptions' => array("style"=>"display:none;")
                //                ));
                ////                ?>
                <form style="display: none;" id="requests-form-<?php echo uniqid()?>">
                    <input name="request-id" type="hidden" value="<?php echo $request->id;?>">
                    <!--                --><?php //$this->endWidget(); ?>
                </form>
                <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
                    <a href='#' class="f-l">
                        <?php echo Profile::model()->getLittleAvatar($request->profile->id,'f-l friend-little-avatar') ?>
                    </a>
                    <div class='f-l'>
                        <div class="friend-fullname">
                            <?php echo htmlspecialchars($request->profile->firstname),' ',htmlspecialchars($request->profile->lastname);?>
                        </div>
                        <div class="friend-job-title">
                            <?php echo Profile::model()->jobTitle($request->id)?>
                        </div>
                    </div>
                </div>

                <div class="friend-status action-imaga-m-r">
                    <div class="friends-decline"></div>
                </div>

                <div class="friend-status">
                    <div class="friends-commit"></div>
                </div>

                <div class="clear"></div>

            </div>
        <?php } ?>

    </div>

    </div>
<?php } else { ?>
    <!-- DISPLAY THIS BLOCK INSTEAD OF PREVEOUS IF NO REQUESTS -->
    <div class="empty-requests">
        There's no active requests.
    </div>
<?php } ?>
