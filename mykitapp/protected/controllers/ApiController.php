<?php

class ApiController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	//Function to autoregister the api's when wordpress plugin is installed returns apikey
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
		echo json_encode($data);
		die();
	}

	//Action to preview slide when Preview slide is clicked either in Website or the WPplugin
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

	//Function to validate the api's and the id. Helper for functions
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

	//Api to feed the video ads to the publishers
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
			$temp['vast_tag'] = $row->vast_tag;
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
	
	//Function to serve the feed of an Slideshow or serve all the availaible slideshows.
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
			$data = Content::model()->search_by_slider($slider->id)->getData();

    		$res = array();
    		foreach ($data as $row) {
				$res[] = array('id'=>$row->id,'url'=>$row->image,'title'=>$row->title,'caption'=>$row->caption);
			}
    		die(json_encode($res));
		} else{
			// Give all published sliders
			$sliders = Sliders::model()->findAll('is_published=:pub',array(':pub'=>1));
			if($sliders===null){
				$data['status'] = 0;
				$data['msg']['error'] = "No Slideshows published";
				echo json_encode($data);
				die();
			}
			foreach ($sliders as $row) {
				$content[] = array('id'=>$row->id,'name'=>$row->name,'description'=>$row->description,
					'category'=>$row->category->name,'category_id'=>$row->category_id);
			}
			echo json_encode($content);
			die();
		}
	}

	//Create feed for slidedeck
	public function actionCreateFeed($id=""){
		
		if(!$id){
			echo json_encode(array('Error'=>'No Slideshow specified'));
			die();
		}

		$slider=Sliders::model()->findByPk($id);
		if($slider===null){
			echo json_encode(array('Error'=>'No Slideshow found with that id'));
			die();
		}
		$content = Content::model()->search_by_slider($slider->id)->getData();
		
		//Custom feed created to clear the eroors in xml
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
    	// get RSS channel items
	    $i=0;
	    foreach ($content as $row) {
	   		$xml .= '<item>' . "\n";
	     	$xml .= '<title>' . $row->title . '</title>' . "\n";
	      	$xml .= '<description>' . $row->caption. '</description>' . "\n";
	    	$xml .= '<pubDate>Mon, 27 Jan 2014 08:32:01 +0100</pubDate>'. "\n";
	 		$xml .= '<enclosure url="'.str_replace('https', 'http', $row->image).'" length="1280" type="image/jpeg">'. "\n";
	      	$xml .= '</enclosure>'."\n";
	      	$xml .= '<guid>'.Yii::app()->getBaseUrl('true').'/'.$i.'</guid>'."\n";
	      	$xml .= '</item>' . "\n";
	      	$i++;
	    }
	    $xml .= '</channel>';	 
	    $xml .= '</rss>';
	    header('Content-Type: application/xml; charset=utf-8');
	    echo $xml;
	    Yii::app()->end();	
	}
}