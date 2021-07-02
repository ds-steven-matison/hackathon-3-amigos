<?php header("Access-Control-Allow-Origin: *");

include "/usr/share/nginx/html/env.php";

if($ASTRA_TOKEN == '') {
    require_once('AuthDb.php');
    $ASTRA_TOKEN = AuthDb::getInstance()->getAuthToken();
    putenv("ASTRA_TOKEN=$ASTRA_TOKEN");
}
function uuid() {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

if($_SERVER['REQUEST_METHOD']=="POST") {
	if(isset($_POST["action"]) && $_POST["action"]=='showCard') {
		// handle ui event 	
		$table_name = 'biometrics_by_voter';
		$request = curl_init();
		$url = $STARGATE_URL . 'keyspaces/' . $KEYSPACE . '/' . $table_name . '/rows';
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
		$request = curl_init();
			//$url = $STARGATE_URL."/api/path/here/";
			$url = 'http://143.198.122.36:8081/pulsar-producer';
			$data_array = array(
				'voter_uuid' => uuid(),
				'face_photo_1' => 'data:image/jpg;base64,'.base64_encode(file_get_contents('/usr/share/nginx/html/images/'.$image1)),
				'face_photo_2' => 'data:image/jpg;base64,'.base64_encode(file_get_contents('/usr/share/nginx/html/images/'.$image2)),
				'face_photo_3' => 'data:image/jpg;base64,'.base64_encode(file_get_contents('/usr/share/nginx/html/images/'.$image3)),
				'fingerprint_left_index' => 'data:image/jpg;base64,'.base64_encode(file_get_contents('/usr/share/nginx/html/images/'.$image4)),
				'fingerprint_left_middle' => '',
				'fingerprint_left_pinky' => '',
				'fingerprint_left_ring' => '',
				'fingerprint_left_thumb' => '',
				'fingerprint_right_index' => '',
				'fingerprint_right_middle' => '',
				'fingerprint_right_pinky' => '',
				'fingerprint_right_ring' => '',
				'fingerprint_right_thumb' => '',
				'signature' => 'data:image/jpg;base64,'.base64_encode(file_get_contents('/usr/share/nginx/html/images/'.$image5))
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
	} else { // this was the original test for pulsar-producer

		$source_images = array('assinatura_machado_de_assis-dominio-publico-14kb.jpg','machado_de_assis_dominio-publico-84kb.jpg','machado_de_assis_dominio-publico-9kb.jpg','machado_de_assis_dominio-publico-12kb.jpg','fingerprint-22kb.png');

		foreach($source_images as $image) { 
			$image_data = 'data:image/jpg;base64,'.base64_encode(file_get_contents('/usr/share/nginx/html/images/'.$image));
			$request = curl_init();
			$url = 'http://143.198.122.36:8081/pulsar-producer';
			$data_array = array();
			$data_array['image_name'] = $image;
			$data_array['image_data'] = $image_data;
			$data_json = json_encode($data_array);
			curl_setopt($request, CURLOPT_URL, $url);
			curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json)));
			curl_setopt($request, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($request, CURLOPT_POSTFIELDS,$data_json);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
			$response  = curl_exec($request);
			curl_close($request);
			echo $response;
		}

	}

} else {
	echo "nothing to see here"; 
}
?>