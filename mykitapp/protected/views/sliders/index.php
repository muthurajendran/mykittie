<?php
/* @var $this SlidersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sliders',
);

$this->menu=array(
	array('label'=>'Create Sliders', 'url'=>array('create')),
	array('label'=>'Manage Sliders', 'url'=>array('admin')),
);
?>

<h1>Sliders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
