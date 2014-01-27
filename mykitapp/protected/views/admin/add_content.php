<pre>
<div class="controls-row">
    <?php
	echo(CHtml::label("Name:".$slider->name,'.span1',array('class'=>'span2'))); 
	echo(CHtml::label("Category:".$slider->category->name,'.span2',array('class'=>'span2')));
	echo(CHtml::label("Description:".$slider->description,'.span4',array('class'=>'span7')));
	?>
    <?php 

    $content = $model->search_by_slider($slider->id);
    $data = $content->getData();

    ?>
</div>
</pre>

<?php if($data) { ?>

<ul class="bxslider">	
    <?php foreach ($data as $row) { ?>
    	 <li  style="margin:0px" ><img src="<?php echo $row->image ?>"  title="<?php echo $row->caption ?>"/></li>
    <?php } ?>
</ul>
<?php } ?>

<h4>Slides</h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'content-grid',
	'dataProvider'=>$content,
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'title',
		array('name'=>'image',
            'type'=>'html',
            'header'=>'Picture',
            'filter'=>false,
            'value'=> 'CHtml::image($data->image, "image", array("width"=>100))'
        ),
		'caption',
		//'created_at',
		//'updated_at',
		array(
            'class'=>'CButtonColumn', 
            'template'=>'{update}',
                    'buttons'=>array
                    (

                       'update' => array
                        (
                            'label'=>'Edit Slide',
                            'url'=>'Yii::app()->createUrl("content/update/".$data->id)',

                        ),
                    ),
        ),
        array(
            'class'=>'CButtonColumn', 
            'template'=>'{delete}',
                    'buttons'=>array
                    (

                       'delete' => array
                        (
                            'label'=>'Delete Slide',
                            'url'=>'Yii::app()->createUrl("content/delete/".$data->id)',

                        ),
                    ),
        ),
	),
)); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'content-form',
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<h3> Add Slide </h3>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'caption'); ?>
		<?php echo $form->textArea($model,'caption',array('size'=>60,'maxlength'=>4096)); ?>
		<?php echo $form->error($model,'caption'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add Slide' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	$(document).ready(function(){
	  $('.bxslider').bxSlider({
	  	auto: false,
  //autoControls: false,
  //controls:false,
  adaptiveHeight: true,
  mode: 'fade',
  captions: true,
  });
	});
</script>



