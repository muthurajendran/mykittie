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
				'actions'=>array('index','view','login'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','dashboard','CreateSlider','AddSliderContent'),
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

		$model=Sliders::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');

		$this->render('add_content',array(
			'model'=>$model,
		));

	}

}