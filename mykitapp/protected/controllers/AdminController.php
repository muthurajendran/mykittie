<?php

class AdminController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}


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