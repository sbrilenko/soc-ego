<?php
//$this->breadcrumbs=array(
//	Yum::t('Usergroups')=>array('index'),
//	Yum::t('Create'),
//);
?>
<?php //$this->title = 'Create Usergroup'; ?>
<?php
$this->renderPartial('_form', array(
			'model' => new Usergroup()));

?>

