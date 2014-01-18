<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

  <div class="row-fluid">
	<div class="span3">
		<div class="sidebar-nav">
      <?php 
      $new_count = Order::model()->count(array('condition'=>'status=:value','params'=>array(':value'=>"New"),));
      $complete_count = Order::model()->count(array('condition'=>'status=:value','params'=>array(':value'=>"Complete"),));
      $process_count = Order::model()->count(array('condition'=>'status=:value','params'=>array(':value'=>"Processing"),));
      $final_count = Order::model()->count(array('condition'=>'status=:value','params'=>array(':value'=>"Finalized"),));
      $cancel_count = Order::model()->count(array('condition'=>'status=:value','params'=>array(':value'=>"Cancelled"),)); 
      $exp = new Order('search');
      $expdata = $exp->search("Expired");
      $exp_count = $expdata->totalItemCount;
      //$exp_count = Order::model()->count(array('condition'=>'status!="Complete" status!="Complete"','params'=>array(':value'=>"Expired"),)); 

      ?>
        
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>array(
				array('label'=>' New Orders <span class="badge badge-warning pull-right">'.$new_count.'</span>', 'url'=>array('/order/new'),'itemOptions'=>array('class'=>'')),
        array('label'=>' In Process Orders <span class="badge badge-warning pull-right">'.$process_count.'</span>', 'url'=>array('/order/processing'),'itemOptions'=>array('class'=>'')),
        array('label'=>' Finalized Orders <span class="badge badge-warning pull-right">'.$final_count.'</span>', 'url'=>array('/order/finalized'),'itemOptions'=>array('class'=>'')),
        array('label'=>' Completed Orders <span class="badge badge-info pull-right">'.$complete_count.'</span>', 'url'=>array('/order/complete'),'itemOptions'=>array('class'=>'')),
        array('label'=>' Cancelled Orders <span class="badge badge-important pull-right">'.$cancel_count.'</span>', 'url'=>array('/order/cancelled'),'itemOptions'=>array('class'=>'')),
        
				// Include the operations menu
				array('label'=>'Alerts','items'=>array(
            array('label'=>' Expired Orders - Need immediate action <span class="badge badge-important pull-right">'.$exp_count.'</span>', 'url'=>array('/order/expired'),'itemOptions'=>array('class'=>'')),
          )),
			),
			));?>

		</div>

        <br>
        <!--
        <table class="table table-striped table-bordered">
          <tbody>
            <tr>
              <td width="50%">Bandwith Usage</td>
              <td>
              	<div class="progress progress-danger">
                  <div class="bar" style="width: 80%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Disk Spage</td>
              <td>
             	<div class="progress progress-warning">
                  <div class="bar" style="width: 60%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Conversion Rate</td>
              <td>
             	<div class="progress progress-success">
                  <div class="bar" style="width: 40%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Closed Sales</td>
              <td>
              	<div class="progress progress-info">
                  <div class="bar" style="width: 20%"></div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      
		<div class="well">
        
            <dl class="dl-horizontal">
              <dt>Account status</dt>
              <dd>$1,234,002</dd>
              <dt>Open Invoices</dt>
              <dd>$245,000</dd>
              <dt>Overdue Invoices</dt>
              <dd>$20,023</dd>
              <dt>Converted Quotes</dt>
              <dd>$560,000</dd>
              
            </dl>
      </div>
		-->
    </div><!--/span-->
    <div class="span9">
    
    <?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
			'homeLink'=>CHtml::link('Dashboard'),
			'htmlOptions'=>array('class'=>'breadcrumb')
        )); ?><!-- breadcrumbs -->
    <?php endif?>
    
    <!-- Include content pages -->
    <?php echo $content; ?>

	</div><!--/span-->
  </div><!--/row-->


<?php $this->endContent(); ?>