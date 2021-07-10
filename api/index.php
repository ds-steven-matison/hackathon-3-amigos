<?php header("Access-Control-Allow-Origin: *");

include dirname(realpath('.'))."/env.php";

if($NIFI_URL == '' && $ASTRA_TOKEN == '') {
	class AuthDb {
	  private static $instance = null;
	  private $auth_token;
	   
	  private function __construct()
	  {
	  	include dirname(realpath('.'))."/env.php";
	    $auth_data = '{"username": "' . $K8S_USERNAME . '","password": "' . $K8S_PASSWORD . '"}';
	    $url = $K8S_AUTH_URL;
	    $request = curl_init($url);
	    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($request, CURLOPT_HTTPHEADER, array(
	    	'Accept: application/json',
	    	'Content-type: application/json'
	    ));
	    curl_setopt($request, CURLOPT_POST, 1);
	    curl_setopt($request, CURLOPT_POSTFIELDS, $auth_data);
	    $response = curl_exec($request);
	    $obj = json_decode($response,true);
	    if (is_null($obj)) {
	    	echo "error authenticating:";
	    	echo $response;
	    } else {
	    	$this->auth_token = $obj['authToken'];
	    }
	  }
	  
	  public static function getInstance()
	  {
	    if(!self::$instance)
	    {
	      self::$instance = new AuthDb();
	    }
	   
	    return self::$instance;
	  }
	  
	  public function getAuthToken()
	  {
	    return $this->auth_token;
	  }
	}

    $ASTRA_TOKEN = AuthDb::getInstance()->getAuthToken();
    putenv("ASTRA_TOKEN=$ASTRA_TOKEN");
}


function uuid() {
    $data = openssl_random_pseudo_bytes(16);
    assert(strlen($data) == 16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function tintTheImage($image,$color) {
	$im = new imagick(dirname(realpath('.'))."/images/".$image);
	$opacityColor = new \ImagickPixel("rgba(255, 0, 0, 0.5)");
	$im->colorizeImage($color, $opacityColor, true);
	$im->setImageFormat("jpg");
	ob_start();
	$newImage = $im->getImageBlob();
	$contents =  ob_get_contents();
	ob_end_clean();
	return base64_encode($newImage);
}

if($_SERVER['REQUEST_METHOD']=="POST") {
	if(isset($_POST["action"]) && $_POST["action"]=='showCard') {
		// handle ui event 	
		$table_name = 'biometrics_by_voter';
		$request = curl_init();
		$url = $STARGATE_URL . 'keyspaces/' . $KEYSPACE . '/' . $table_name . '/rows?page-size=1';
		if(isset($_POST['pagestate'])) { $url .= "&page-state=".$_POST['pagestate']; }
		curl_setopt($request, CURLOPT_URL, $url);
		curl_setopt($request, CURLOPT_HTTPHEADER, array('X-Cassandra-Token: ' . $ASTRA_TOKEN, 'Content-Type: application/json'));
		curl_setopt($request, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
		$response  = curl_exec($request);
		curl_close($request);
		echo stripslashes($response); // try fix this later
	}
	else if(isset($_POST["action"]) && $_POST["action"]=='saveVoter') { 
		// handle ui event saveVoter
		$errorMSG = "";
		$image1 = 'machado_de_assis_dominio-publico-84kb.jpg';
		$image2 = 'machado_de_assis_dominio-publico-12kb.jpg';
		$image3 = 'machado_de_assis_dominio-publico-9kb.jpg';
		$image4 = 'fingerprint-22kb.png';
		$image5 = 'assinatura_machado_de_assis-dominio-publico-14kb.jpg';
		$table_name = 'biometrics_by_voter';
		$request = curl_init();

			$url = $STARGATE_URL.'keyspaces/' . $KEYSPACE . '/' . $table_name;
			$data_array = array(
				'voter_uuid' => uuid(),
				'face_photo_1' => 'data:image/jpg;base64,'.tintTheImage($image1,'rgb('.$APP_R.', '.$APP_B.', '.$APP_G.')'),
				'face_photo_2' => 'data:image/jpg;base64,'.tintTheImage($image2,'rgb('.$APP_R.', '.$APP_B.', '.$APP_G.')'),
				'face_photo_3' => 'data:image/jpg;base64,'.tintTheImage($image3,'rgb('.$APP_R.', '.$APP_B.', '.$APP_G.')'),
				'fingerprint_left_index' => 'data:image/jpg;base64,'.tintTheImage($image4,'rgb('.$APP_R.', '.$APP_B.', '.$APP_G.')'),
				'fingerprint_left_middle' => '',
				'fingerprint_left_pinky' => '',
				'fingerprint_left_ring' => '',
				'fingerprint_left_thumb' => '',
				'fingerprint_right_index' => '',
				'fingerprint_right_middle' => '',
				'fingerprint_right_pinky' => '',
				'fingerprint_right_ring' => '',
				'fingerprint_right_thumb' => '',
				'signature' => 'data:image/jpg;base64,'.tintTheImage($image5,'rgb('.$APP_R.', '.$APP_B.', '.$APP_G.')'),
				'updated_ts' => '2011-02-03 04:05:00+0000'
			);
			
			$data_json = json_encode($data_array);
			curl_setopt($request, CURLOPT_URL, $url);
			curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json)));
			curl_setopt($request, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($request, CURLOPT_POSTFIELDS,$data_json);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
			$response  = curl_exec($request);
			curl_close($request);
			//echo $response;

		if(empty($errorMSG)){
			$msg = "Voter Saved Successfully!!";
			echo json_encode(['code'=>200, 'msg'=>$msg]);
			exit;
		}
		else {
			echo json_encode(['code'=>404, 'msg'=>$errorMSG]);
		}
	}

} else {
	echo "nothing to see here"; 
}
?>