<?php
/* @var $this VideoAdsController */
/* @var $model VideoAds */

$this->breadcrumbs=array(
	'Video Ads'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List VideoAds', 'url'=>array('index')),
	array('label'=>'Create VideoAds', 'url'=>array('create')),
	array('label'=>'Update VideoAds', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete VideoAds', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VideoAds', 'url'=>array('admin')),
);
?>

<h1>View VideoAds #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'description',
		'content',
	),
)); ?>
