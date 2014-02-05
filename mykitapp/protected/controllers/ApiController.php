<?php

class ApiController extends Controller
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

	public function actionRegister(){
		$data['status'] = 0;
		$data['msg'] = "no data";
		if(isset($_POST['url']) && isset($_POST['email'])){
			//create api key
			$data = array();
			$user = Users::model()->find('email = :em and site_url =:site',array(':em'=>$_POST['email'],':site'=>$_POST['url']));
			if($user){
				$data['api_key'] = $user->api_key;
				$data['status'] = 1;
			} else {
				$user = new Users;
				$user->email = $_POST['email'];
				$user->api_key = mt_rand();
				$user->role = 0;
				$user->site_url = $_POST['url'];
				$ph=new PasswordHash(Yii::app()->params['phpass']['iteration_count_log2'], Yii::app()->params['phpass']['portable_hashes']);
		      	$password_hash=$ph->HashPassword($user->api_key);
		      	$user->password = $password_hash;
		      	$user->password_confirmation = $password_hash;
				if($user->save())
				{
					$data['api_key'] = $user->api_key;
					$data['status'] = 1;
				} else{
					$data['status'] = 0;
					$data['msg'] = "db error";
				}
			}
		}
		//$content['data'] = $data;
		echo json_encode($data);
		die();
	}

	public function actionViewSlide($id="",$api=""){
		$this->checkApiValid($id,$api);
		if(!$id){
			$data['status'] = 0;
			$data['msg']['error'] = "No slide key";
			echo json_encode($data);
			die();
		}

		$slider=Sliders::model()->findByPk($id);
		if($slider===null)
			throw new CHttpException(404,'The requested page does not exist.');
		$model = new Content();

		$this->render('index',array(
			'model'=>$model,'slider'=>$slider
		));


	}


	public function checkApiValid($id,$api){
		$user = "";
		$data = array();
		$data['status'] = 1;
		//If no api key than return
		if(!$api){
			$data['status'] = 0;
			$data['msg']['error'] = "No api key";
			echo json_encode($data);
			die();
		}

		$user = Users::model()->find('api_key=:api',array(':api'=>$api));
		//If no user send corresponding error message
		if(!$user){
			$data['status'] = 0;
			$data['msg']['error'] = "Api key not valid";
			echo json_encode($data);
			die();
		}
	}

	public function actionGetVideoAds($id="",$api=""){
		$this->checkApiValid($id,$api);
		$content = array();
		$ads = VideoAds::model()->findAll();
		foreach ($ads as $row) {
			$temp = array();
			$temp['title'] = $row->title;
			$temp['description'] = $row->description;
			$temp['content'] = $row->content;
			$temp['type'] = $row->type;
			$content[] = $temp;
		}
		if($content)
			die(json_encode($content));
		else{
			$data['status'] = 0;
			$data['msg']['error'] = "No Ads found";
			echo json_encode($data);
			die();
		}
	}
	

	public function actionGetFeed($id="",$api=""){
		$this->checkApiValid($id,$api);

		if($id && $api){
			//return a particular data
			$slider=Sliders::model()->findByPk($id);
			if($slider===null){
				$data['status'] = 0;
				$data['msg']['error'] = "No slider found";
				echo json_encode($data);
				die();
			}
			$model = new Content();
			$content = $model->search_by_slider($slider->id);
    		$data = $content->getData();
    		//die(var_dump($data));

    		$res = array();
    		foreach ($data as $row) {
				$temp = array();
				$temp['id'] = $row->id; 
				$temp['url'] = $row->image;
				$temp['caption'] = $row->caption;
				$res[] = $temp;
				# code...
			}
    		die(json_encode($res));
		} else{
			// Give all published sliders
			$sliders = Sliders::model()->findAll('is_published=:pub',array(':pub'=>1));
			//die(var_dump($sliders));
			foreach ($sliders as $row) {
				$temp = array();
				$temp['id'] = $row->id; 
				$temp['name'] = $row->name;
				$temp['description'] = $row->description;
				$temp['category'] = $row->category->name;
				$temp['category_id'] = $row->category_id;
				$content[] = $temp;
				# code...
			}
			die(json_encode($content));
		}
	}


}