<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

		$logoutUrl = "";
		$loginUrl = "";
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
/*
		$this->layout = "kit";

		Yii::import('application.vendor.*');
		require_once('facebook/src/facebook.php');

		$facebook = new Facebook(array(
		  'appId'  => '1430479310519409',
		  'secret' => 'd4e192fdc9b0f1afe027702ca5ef3c73',
		));

		$user = $facebook->getUser();
		if ($user) {
		  try {
		    // Proceed knowing you have a logged in user who's authenticated.
		    $user_profile = $facebook->api('/me');
		    die(var_dump($user_profile));

		  } catch (FacebookApiException $e) {
		    error_log($e);
		    $user = null;
		  }
		}

		$logoutUrl = "";
		$loginUrl = "";

		if ($user) {
		  $logoutUrl = $facebook->getLogoutUrl();
		}else{
		  $statusUrl = $facebook->getLoginStatusUrl();
		  $loginUrl = $facebook->getLoginUrl(array(
			'scope'		=> 'email,publish_actions', // Permissions to request from the user
			'redirect_uri'	=> 'http://www.mykit.com/index.php', // URL to redirect the user to once the login/authorization process is complete.
			));
		}
		*/

		//$naitik = $facebook->api('/naitik');

		//die(var_dump($loginUrl));


		$this->render('index',array('loginUrl'=>$loginUrl,'logoutUrl'=>$logoutUrl));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				if(Yii::app()->user->isAdmin())
					$this->redirect(Yii::app()->getBaseUrl('true')."/admin/dashboard");
				else
					$this->redirect(Yii::app()->user->returnUrl);
			}
				
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}