<?php
/* @var $this SlidersController */
/* @var $model Sliders */

$this->breadcrumbs=array(
	'Sliders'=>array('index'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sliders-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>All Slideshows</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sliders-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'name',
		array(
            'header' => 'Category',
            'name' => 'category_search',
            'value' => '$data->category->name'
        ),
		'description',
		array(
            'header' => 'Is Published',
            'name' => 'is_published',
            'filter'=>false,
            'value' => '$data->is_published?"Published":"Draft"'
        ),

        array(
            'class'=>'CButtonColumn', 
            'template'=>'{Embed}',
                    'buttons'=>array
                    (

                       'Embed' => array
                        (
                            'label'=>'Embed code',
                            'url'=>'Yii::app()->createUrl("admin/embed/".$data->id)',

                        ),
                    ),
        ),
        array(
            'class'=>'CButtonColumn', 
            'template'=>'{Edit}',
                    'buttons'=>array
                    (

                       'Edit' => array
                        (
                            'label'=>'Edit Slide',
                            'url'=>'Yii::app()->createUrl("admin/addslidercontent/".$data->id)',

                        ),
                    ),
        ),
	),
)); ?>
