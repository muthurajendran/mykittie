<?php
/* @var $this SlidersController */
/* @var $model Sliders */

$this->breadcrumbs=array(
	'Sliders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Sliders', 'url'=>array('index')),
	array('label'=>'Manage Sliders', 'url'=>array('admin')),
);
?>

<h1>Create Sliders</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>