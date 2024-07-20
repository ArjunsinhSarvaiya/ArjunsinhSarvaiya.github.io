<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
	$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";

	if (empty($id)) {
		$response['success']=false;
		$response['message']="you must include 'id' in your request";
		die(json_encode($response));
	}
	if (empty($status)) {
		$response['success']=false;
		$response['message']="you must include 'status' in your request";
		die(json_encode($response));
	}

	$data=array();
	$data['status'] = $status;
	$result=$obj->add_Edit_mst_campaign_comment($data,$id);
	
	if (!empty($result)) {
		$response['success']=true;
		$response['message']="Status Change SuccessFully.";
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Request Failed.";
		die(json_encode($response));
	}
?>
