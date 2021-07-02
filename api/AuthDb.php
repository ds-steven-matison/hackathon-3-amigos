<?php
class AuthDb {
  private static $instance = null;
  private $auth_token;
   
  private function __construct()
  {
	include('common.php');
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
?>