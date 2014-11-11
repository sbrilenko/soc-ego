<?php
//$this->breadcrumbs=array(
//	Yum::t('Usergroups')=>array('index'),
//        $model->title=>array('view','id'=>$model->id),
//        Yum::t('Update')
//);

$this->menu=array(
	array('label'=>'List Usergroup', 'url'=>array('index')),
	array('label'=>'Create Usergroup', 'url'=>array('create')),
	array('label'=>'View Usergroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Usergroup', 'url'=>array('admin')),
);
?>

<h1> <?php echo 'Update Usergroup'; ?> #<?php echo $model->id; ?> </h1>
<?php
$this->renderPartial('_form', array(
			'model'=>$model));
