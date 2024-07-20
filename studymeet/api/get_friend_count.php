<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$my_id = isset($_REQUEST['my_id'])?$_REQUEST['my_id']:"";
	$my_id = isset($_REQUEST['my_id'])?$_REQUEST['my_id']:"";

	if (empty($my_id)) {
		$response['success']=false;
		$response['message']="you must include 'my_id' in your request";
		die(json_encode($response));
	}

	$result=$obj->get_count_friends($my_id);
	//echo "<pre>";print_r($result);die();
	if($result){
		$response['success']=true;
		$response['message']="Data Found.";
		$response["result"] = $result;
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Data Not Available.";
		die(json_encode($response));
	}
?>
