<?php 
echo 'The Usergroup {groupname} has been successfully created', array('groupname' => $model)
?>

<?php 
echo CHtml::Button('Back', array('id' => $relation.'_done'));
echo CHtml::Button('Add another Usergroup', array('id' => $relation.'_create'));
