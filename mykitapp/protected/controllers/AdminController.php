<?php

class AdminController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','login','CreateFeed'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','dashboard','CreateSlider','AddSliderContent',),
                'expression' => 'Yii::app()->user->isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public $layout='//layouts/column2';


	public function actionCreateFeed(){
		//print_r(Yii::app()->getBaseUrl('true'));
		//exit;

		Yii::import('ext.feed.*');
		// RSS 2.0 is the default type
		$feed = new EFeed();
		 
		$feed->title= 'News';
		$feed->description = 'Test feed for site';
		 
		$feed->setImage('Testing RSS 2.0 EFeed class',Yii::app()->getBaseUrl('true').'/admin/createfeed',
		'http://www.yiiframework.com/forum/uploads/profile/photo-7106.jpg');
		 
		$feed->addChannelTag('language', 'en-us');
		$feed->addChannelTag('pubDate', date(DATE_RSS, time()));
		$feed->addChannelTag('link', Yii::app()->getBaseUrl('true').'/admin/createfeed');
		 
		// * self reference
		$feed->addChannelTag('atom:link',Yii::app()->getBaseUrl('true').'/admin/createfeed');
		 
		$content = Content::model()->findAll();
		$ads = VideoAds::model()->findAll();


		$xml = '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
	    $xml .= '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
	    // channel required properties
	    $xml .= '<channel>' . "\n";
	    $xml .= '<title>' . 'News' . '</title>' . "\n";
	    $xml .= '<link>' . Yii::app()->getBaseUrl('true').'/admin/createfeed' . '</link>' . "\n";
	    $xml .= '<description>' . 'Test feed for site' . '</description>' . "\n";
	 
	   
	   
	    $xml .= '<image>' . "\n";
      	$xml .= '<title>' . 'News' . '</title>' . "\n";
      	$xml .= '<link>' . Yii::app()->getBaseUrl('true').'/admin/createfeed' . '</link>' . "\n";
      	$xml .= '<url>' . 'http://www.yiiframework.com/forum/uploads/profile/photo-7106.jpg' . '</url>' . "\n";
      	$xml .= '</image>' . "\n";

      	 // channel optional properties
	    $xml .= '<language>' . "en-us" . '</language>' . "\n";

      	$xml .= '<pubDate>Mon, 27 Jan 2014 08:32:01 +0100</pubDate>'. "\n";;
      	$xml .= '<atom:link rel="self" href="'. Yii::app()->getBaseUrl('true') .'/admin/createfeed" type="application/rss+xml"></atom:link>'. "\n";
	   	//$xml .= '</atom:link>'. "\n";
	 
	    // get RSS channel items
	    $now =  date("YmdHis"); // get current time  // configure appropriately to your environment
	    //$rss_items = $this->get_feed_items($now);
	    $i=0;
	    foreach ($content as $row) {
	   		$xml .= '<item>' . "\n";
	     	$xml .= '<title>' . $row->title . '</title>' . "\n";
	      	//$xml .= '<link>' .  . '</link>' . "\n";
	      	$xml .= '<description>' . $row->caption. '</description>' . "\n";
	    	$xml .= '<pubDate>Mon, 27 Jan 2014 08:32:01 +0100</pubDate>'. "\n";;
	    	//$xml .= '<category>' . $rss_item['category'] . '</category>' . "\n";
	    	//$xml .= '<source>' . $rss_item['source'] . '</source>' . "\n";
	 		$xml .= '<enclosure url="'.str_replace('https', 'http', $row->image).'" length="1280" type="image/jpeg">'. "\n";;
	      	/*if($this->full_feed) {
	        	$xml .= '<content:encoded>' . $rss_item['content'] . '</content:encoded>' . "\n";
	      	}*/
	      	$xml .= '</enclosure>'."\n";

	      	$xml .= '<guid>'.Yii::app()->getBaseUrl('true').'/'.$i.'</guid>'."\n";
	      	$xml .= '</item>' . "\n";
	      	$i++;
	    }
	 /*
	    foreach($rss_items as $rss_item) {
	    	$xml .= '<item>' . "\n";
	    	$xml .= '<title>' . $rss_item['title'] . '</title>' . "\n";
	    	$xml .= '<link>' . $rss_item['link'] . '</link>' . "\n";
	    	$xml .= '<description>' . $rss_item['description'] . '</description>' . "\n";
	    	$xml .= '<pubDate>Mon, 27 Jan 2014 08:32:01 +0100</pubDate>';
	    	//$xml .= '<category>' . $rss_item['category'] . '</category>' . "\n";
	    	//$xml .= '<source>' . $rss_item['source'] . '</source>' . "\n";
	 		$xml = '<enclosure url="'.$row->image.'" length="1280" type="image/jpeg"></enclosure>';
	      	if($this->full_feed) {
	        	$xml .= '<content:encoded>' . $rss_item['content'] . '</content:encoded>' . "\n";
	      	}
	      	$xml .= '</item>' . "\n";
	    } */
	 
	    $xml .= '</channel>';
	 
	    $xml .= '</rss>';

	    header('Content-Type: application/rss+xml; charset=utf-8');

	    echo $xml;

	    //var_dump($xml);
	   // die();

	    Yii::app()->end();
	 
	    /*return $xml; 

		
		foreach ($content as $row) {

			$item = $feed->createNewItem();
		 
			$item->title = $row->title;
			//$item->link = Yii::app()->getBaseUrl('true').'/admin/createfeed';
			//$item->date = time();
			$item->description = $row->caption;
			//$item->image = $row->image;
			//$item->addTag('image',$row->image);
			//	'title'=>'W3Schools.com', 'link'=>'http://www.w3schools.com'));
			// this is just a test!!
			$item->setEncloser($row->image, '1280', 'image/jpeg');
			 
			$item->addTag('author', 'thisisnot@myemail.com (Antonio Ramirez)');
			$item->addTag('guid', 'http://www.ramirezcobos.com/',array('isPermaLink'=>'true'));
			 
			$feed->addItem($item);
			
		}

		foreach ($ads as $row) {
			$item = $feed->createNewItem();
		 
			$item->title = $row->title;
			$item->link = Yii::app()->getBaseUrl('true').'/admin/createfeed';
			//$item->date = time();
			$item->description = $row->description;
			//$item->image = $row->image;
			//$item->addTag('image',$row->image);
			//	'title'=>'W3Schools.com', 'link'=>'http://www.w3schools.com'));
			// this is just a test!!
			$item->setEncloser($row->content, '128090', 'video/mpeg');
			 
			//$item->addTag('author', 'thisisnot@myemail.com (Antonio Ramirez)');
			//$item->addTag('guid', 'http://www.ramirezcobos.com/',array('isPermaLink'=>'true'));
			 
			$feed->addItem($item);
			# code...
		}

		$feed->generateFeed();
		Yii::app()->end(); */

	
	}

	public function actionDashboard()
	{
		$model=new Sliders('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Sliders']))
			$model->attributes=$_GET['Sliders'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionCreateSlider(){
		$model=new Sliders;

		if(isset($_POST['Sliders']))
		{
			$model->attributes=$_POST['Sliders'];
			if($model->save())
				$this->redirect(array('addslidercontent','id'=>$model->id));
		}

		$this->render('slide_create',array(
			'model'=>$model,
		));
	}

	public function actionAddSliderContent($id){

		$slider=Sliders::model()->findByPk($id);
		if($slider===null)
			throw new CHttpException(404,'The requested page does not exist.');


		$model=new Content;

		if(isset($_POST['Content']))
		{
			$model->attributes=$_POST['Content'];

			if($model->validate()){
				$upload = EUploadedImage::getInstance($model,'image');
				$model->slider_id = $slider->id;

				Yii::import('application.vendor.*');
		        require_once('AWS/sdk.class.php');
		        $s3 = new AmazonS3();
		        $bucketname = "slideradfuse";

		        $rand = rand();
		        if($upload){
					$name = "images/content-".$rand.".jpg";
					if($upload->saveAs($name)){
						$tname = "content-".$rand.".jpg";
						$response = $s3->create_object($bucketname, "images/" . $tname , array(
					    	'fileUpload' => substr(Yii::app()->iwi->load($name)->adaptive(540,300,Image::AUTO,false)->cache(),11),
					        'contentType' => $upload->type,
					        'acl' => $s3::ACL_PUBLIC
						));
						if($response)
					        $model->image = "https://s3.amazonaws.com/".$bucketname."/images/".$tname;
					}
				}
				if($model->save())
					$this->redirect(array('admin/addslidercontent','id'=>$slider->id));
			}
		}

		$this->render('add_content',array(
			'model'=>$model,'slider'=>$slider,
		));

	}

}