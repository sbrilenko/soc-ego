
  <?php foreach($friends as $fri) { ?>
  <div class="friend-container">
<!--      --><?php
//      $form = $this->beginWidget('CActiveForm', array(
//          'id'=>'allfriends-from-'.uniqid(),
//          'enableAjaxValidation'=>true,
//          'enableClientValidation'=>true,
//          'htmlOptions' => array('enctype' => 'multipart/form-data',"style"=>"display: none")
//      ));
//      ?>
      <form style="display: none;" id="allfriends-from-<?php echo uniqid();?>">
        <input name="allfriends-id" value="<?php echo $fri->id; ?>" type="hidden">
      </form>
<!--      --><?php //$this->endWidget(); ?>
    <div class="padding-zero friend-name-container left-pad f-l inline-with-image">
      <a href='<?= $this->createUrl('profile/view', ['id' => $fri->id]) ?>' class="f-l">
          <?php echo Profile::model()->getLittleAvatar($fri->id,'f-l friend-little-avatar') ?>
      </a>
      <div class='f-l'>
        <div class="friend-fullname">
            <?php echo htmlspecialchars($fri->profile->firstname),' ',htmlspecialchars($fri->profile->lastname);?>
        </div>
        <div class="friend-job-title">
            <?php echo Profile::model()->jobTitle($fri->id)?>
        </div>
      </div>
    </div>

    <div class="friend-status action-imaga-m-r">
        <div class="friends-write-message">
        </div>
    </div>

    <div class="friend-status">
        <div class="remove-from-friends">
        </div>
    </div>

    <div class="clear"></div>

  </div>
    <?php } ?>