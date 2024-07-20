<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$notes = isset($_REQUEST['notes'])?$_REQUEST['notes']:"";
	
	if (empty($user_id)) {
		$response['success']=false;
		$response['message']="you must include 'user_id' in your request";
		die(json_encode($response));
	}
	if (empty($user_type)) {
		$response['success']=false;
		$response['message']="you must include 'user_type' in your request";
		die(json_encode($response));
	}
	if (empty($notes)) {
		$response['success']=false;
		$response['message']="you must include 'notes' in your request";
		die(json_encode($response));
	}

	$data = array();
	$data['notes']=$notes;
	$data['user_id']=$user_id;
	$data['user_type']=$user_type;
	$data['entry_date']=date("Y-m-d H:i:s");

	$result=$obj->addEdit_mst_notes($data);
	if($result){
		$response['success']=true;
		$response['message']="Notes Added Successfully.";
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));
	}
?>
