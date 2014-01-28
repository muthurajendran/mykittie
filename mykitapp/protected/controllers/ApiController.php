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
			var_dump($id);
			var_dump($api);
			die();
		} else{
			// Give all published sliders
			$sliders = Sliders::model()->findAll('is_published=:pub',array(':pub'=>1));
			//die(var_dump($sliders));
			foreach ($sliders as $row) {
				$temp = array();
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