<?php
/* @var $this SlidersController */
/* @var $model Sliders */

$this->breadcrumbs=array(
	'Sliders'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Sliders', 'url'=>array('index')),
	array('label'=>'Create Sliders', 'url'=>array('create')),
	array('label'=>'Update Sliders', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Sliders', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Sliders', 'url'=>array('admin')),
);
?>

<h1>View Sliders #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'category_id',
		'description',
		'is_published',
		'created_at',
	),
)); ?>
