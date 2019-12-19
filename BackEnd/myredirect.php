<?php
	$myclient_id = "db6950e9-dd30-48f0-ba9d-6d250724b04b";
	$client_secret = "ENm/Z3dPv6B/PCbi?Nx3W.PfYLsKoS4=";
	$redirect_uri = "http://localhost/event/myredirect.php";
	//$_GET["code"] is the authorization code 
	if(isset($_GET["code"])) {
		//user is granted permission //get access token using the authorization code
		$url = "https://login.live.com/oauth20_token.srf";
		$fields = array("client_id" => $myclient_id, "redirect_uri" => $myredirect_uri, "client_secret" => $myclient_secret, "code" => $_GET["code"], "grant_type" => "myauthorization_code");
		foreach($fields as $key=>$value) {
			$fields_string .= $key."=".$value."&";
		}
		rtrim($fields_string, "&");
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_HTTPHEADER,
		array("Content-Type: application/x-www-form-urlencoded"));
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);
		$result = json_decode($result);
		curl_close($ch);
		//this is the refresh token used to access Microsoft Live REST APIs
		$myaccess_token = $result->access_token;
		//tokens expire every one hour so the below code is used to get new tokens then
		$myrefresh_token = $result->refresh_token;
	} else {
		echo "An error occured";
	}


	function new_access_token($refresh_token)
	{
		$myurl = "https://login.live.com/oauth20_token.srf";
		$myfields = array("client_id" => $myclient_id, "redirect_uri" => $my_uri, "client_secret" => $myclient_secret, "grant_type" => "refresh_token", "refresh_token" => $myrefresh_token);
		foreach($myfields as $mykey=>$myvalue) {
			$my_string .= $mykey."=".$myvalue."&";
		}
		rtrim($my_string, "&");
		$chcurling = curl_init();
		curl_setopt($chcurling,CURLOPT_URL, $myurl);
		curl_setopt($chcurling,CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
		curl_setopt($chcurling,CURLOPT_POST, count($myfields));
		curl_setopt($chcurling,CURLOPT_POSTFIELDS, $my_string);
		curl_setopt($chcurling,CURLOPT_RETURNTRANSFER,1);
		$myresult = curl_exec($chcurling);
		$myresult = json_decode($result);
		curl_close($chcurling);
		$myaccess_token = $result->access_token;
		return $myaccess_token;
	}
?>