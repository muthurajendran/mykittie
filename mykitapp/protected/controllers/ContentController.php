<?php

class ContentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','index','view'),
				'expression' => 'Yii::app()->user->isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Content('create');
		//$model->image = EUploadedImage::getInstance($model,'image');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Content']))
		{
			$model->attributes=$_POST['Content'];

			//die(var_dump($model->image));
			if($model->validate()){
				$upload = EUploadedImage::getInstance($model,'image');

				// die(var_dump($upload));

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
					$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Content']))
		{
			$model->attributes=$_POST['Content'];
			if($model->validate()){
				$upload = EUploadedImage::getInstance($model,'image');

				// die(var_dump($upload));

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

						//die(var_dump($response));

						if($response)
					        $model->image = "https://s3.amazonaws.com/".$bucketname."/images/".$tname;
					}
				}

				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Content');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Content('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Content']))
			$model->attributes=$_GET['Content'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Content the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Content::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Content $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='content-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
