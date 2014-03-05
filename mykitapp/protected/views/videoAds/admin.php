<?php
/* @var $this VideoAdsController */
/* @var $model VideoAds */

$this->breadcrumbs=array(
	'Ads'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List VideoAds', 'url'=>array('index')),
	array('label'=>'Create VideoAds', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#video-ads-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ads</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'video-ads-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'description',
		'type',
		'content',
		//'vast_tag',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
