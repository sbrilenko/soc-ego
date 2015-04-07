<link rel="stylesheet" type="text/css" href="/css/friends.css">
<div class="main friends-page">
  <div class="f-l main-name-margin-b">
    <div class="main-name-style">
      Friends
    </div>
    <div>
      <span class="uppercase active">Friends list</span>
      <span class="uppercase">All User</span>
    </div>
    <div class="content">
      <div class="friends-list">
        <div class="header"></div>
        <div class="list">
         <!-- Короче наверстал я тут пля :( --> 
         <?php $friend_count = 1; ?>
         <?php foreach($friends as $friend): ?>
         <?php if(($friend_count % 2) != 0): ?>
          <div class="row">
          <?php endif; ?>
            <div class="col-<?php echo $friend_count % 2 != 0 ? 'left' : 'right';?>">
              <div class="f-avatar"><?php echo Profile::model()->getLittleAvatar($friend->user->id);?></div>
              <div class="f-description">
                <span class="user-name"><?php echo $friend->user->profile->firstname . ' ' . $friend->user->profile->lastname; ?></span>
                <div></div>
                <span class="job-title"><?php echo $friend->user->job_title; ?></span>
              </div>
            </div>
           <?php $friend_count++; ?>
           <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
