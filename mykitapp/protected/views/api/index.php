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
