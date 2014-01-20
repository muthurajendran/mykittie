<h3>Under contstruction</h3>
<pre>
<div class="controls-row">
    <?php
	echo(CHtml::label("Name:".$slider->name,'.span1',array('class'=>'span2'))); 
	echo(CHtml::label("Category:".$slider->category->name,'.span2',array('class'=>'span2')));
	echo(CHtml::label("Description:".$slider->description,'.span4',array('class'=>'span7')));
	?>
    <br />

    <?php 
    echo "Slideshow will come here"
    ?>
</div>
</pre>

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


<h4>Slides</h4>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'content-grid',
	'dataProvider'=>$model->search_by_slider($slider->id),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'image',
		'caption',
		'created_at',
		'updated_at',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
