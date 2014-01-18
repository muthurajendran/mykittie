<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
     
          <!-- Be sure to leave the brand out there if you want it shown -->
          <a class="brand" href="<?php echo Yii::app()->getBaseUrl('true') ?>">Tastery</a>
          <?php if(!Yii::app()->user->isGuest) { ?>
          <div class="nav-collapse">
			<?php 
     // $new_count = Order::model()->count(array('condition'=>'status=:value','params'=>array(':value'=>"New"),));
     // $complete_count = Order::model()->count(array('condition'=>'status=:value','params'=>array(':value'=>"Complete"),));
     // $process_count = Order::model()->count(array('condition'=>'status=:value','params'=>array(':value'=>"Processing"),));
     // $cancel_count = Order::model()->count(array('condition'=>'status=:value','params'=>array(':value'=>"Cancelled"),));

      $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'pull-right nav'),
                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
					'itemCssClass'=>'item-test',
                    'encodeLabel'=>false,
                    'items'=>array(
                       // array('label'=>'Dashboard', 'url'=>array('/admin/dashboard')),
                        array('label'=>'New Order', 'url'=>array('/admin/neworder')),
                        array('label'=>'Content', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                            array('label'=>'Manage Experience', 'url'=>'/experience/admin'),
                             array('label'=>'Manage Cuisines', 'url'=>'/admin/cuisines'),
                            array('label'=>'Manage Locations', 'url'=>'/location/admin'),
                            array('label'=>'Manage Chefs', 'url'=>'/chefs/admin'),
                            array('label'=>'Add Chefs', 'url'=>'/chefs/create'),
                        )),
                        
                        array('label'=>'Users', 'url'=>'/users/admin','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                            array('label'=>'Create Users', 'url'=>'/users/create'),
                            array('label'=>'Manage Users', 'url'=>'/users/admin'),
                            array('label'=>'Create Api Users', 'url'=>'/api/create'),
                            array('label'=>'Manage Api Users', 'url'=>'/api/admin'),
                        )),
                        // array('label'=>'Settings', 'url'=>array('/settings/admin')),
                        /* array('label'=>'Orders', 'url'=>'/order/admin','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                            array('label'=>'New<span class="badge badge-warning pull-right">'.$new_count.'</span>', 'url'=>'/order/new'),
                            array('label'=>'Processing<span class="badge badge-important pull-right">'.$process_count.'</span>', 'url'=>'/order/processing'),
                            array('label'=>'Completed<span class="badge badge-info pull-right">'.$complete_count.'</span>', 'url'=>'/order/complete'),
                            array('label'=>'Cancelled', 'url'=>'/order/cancelled'),
                        )), */
                        array('label'=>'Payments', 'url'=>'/payment/admin','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                            array('label'=>'Manage Payments', 'url'=>'/payment/admin'),
                            array('label'=>'Make Payment', 'url'=>'/admin/payment'),
                            array('label'=>'Make refund', 'url'=>'/admin/refund'),

                        )),

                        array('label'=>'Others', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                            array('label'=>'Launch emails', 'url'=>array('/notifier/admin')),
                            array('label'=>'Splash page orders', 'url'=>array('/launchCart/admin')),

                        )),
                        
                        /*array('label'=>'Gii generated', 'url'=>array('customer/index')),*/
                       /* array('label'=>'My Account <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                            array('label'=>'My Messages <span class="badge badge-warning pull-right"></span>', 'url'=>'#'),
              							array('label'=>'My Tasks <span class="badge badge-important pull-right">112</span>', 'url'=>'#'),
              							array('label'=>'My Invoices <span class="badge badge-info pull-right">12</span>', 'url'=>'#'),
              							array('label'=>'Separated link', 'url'=>'#'),
              							array('label'=>'One more separated link', 'url'=>'#'),
                        )),*/
                        array('label'=>'Login', 'url'=>array('/admin/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/admin/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    ),
                )); ?>
    	</div>
        <?php } ?> 
    </div>
	</div>
</div>