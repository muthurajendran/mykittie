<?php
/* @var $this SlidersController */
/* @var $model Sliders */

$this->breadcrumbs=array(
	'Sliders'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Sliders', 'url'=>array('index')),
	array('label'=>'Create Sliders', 'url'=>array('create')),
	array('label'=>'View Sliders', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Sliders', 'url'=>array('admin')),
);
?>

<h1>Update Sliders <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>