<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$limit_start = isset($_REQUEST['limit_start'])?$_REQUEST['limit_start']:"";

	$result=$obj->get_city($limit_start,"50");
	
	if($result){
		$response['success']=true;
		$response['message']="Data Found.";
		$response["result"] = $result;
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Data Not Found.";
		die(json_encode($response));
	}
?>
