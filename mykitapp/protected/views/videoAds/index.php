<?php
/* @var $this VideoAdsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Video Ads',
);

$this->menu=array(
	array('label'=>'Create VideoAds', 'url'=>array('create')),
	array('label'=>'Manage VideoAds', 'url'=>array('admin')),
);
?>

<h1>Video Ads</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
