<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
	$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";
	$type = isset($_REQUEST['type'])?$_REQUEST['type']:"";

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
	if (empty($type)) {
		$response['success']=false;
		$response['message']="you must include 'type' in your request";
		die(json_encode($response));
	}
	if ($type=="1") {
		$data=array();
		$data['status'] = $status;
		$result=$obj->addEdit_mst_question_answer($data,$id);
	}else if ($type=="2") {
		$data=array();
		$data['status'] = $status;
		$result=$obj->addEdit_mst_question_comment($data,$id);
	}
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
