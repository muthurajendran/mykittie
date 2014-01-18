<?php
/* @var $this VideoAdsController */
/* @var $model VideoAds */

$this->breadcrumbs=array(
	'Video Ads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VideoAds', 'url'=>array('index')),
	array('label'=>'Manage VideoAds', 'url'=>array('admin')),
);
?>

<h1>Create VideoAds</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>