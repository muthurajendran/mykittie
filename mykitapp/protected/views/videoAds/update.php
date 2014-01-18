<?php
/* @var $this VideoAdsController */
/* @var $model VideoAds */

$this->breadcrumbs=array(
	'Video Ads'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VideoAds', 'url'=>array('index')),
	array('label'=>'Create VideoAds', 'url'=>array('create')),
	array('label'=>'View VideoAds', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VideoAds', 'url'=>array('admin')),
);
?>

<h1>Update VideoAds <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>