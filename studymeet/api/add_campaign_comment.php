<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$campaign_id = isset($_REQUEST['campaign_id'])?$_REQUEST['campaign_id']:"";
	$comment = isset($_REQUEST['comment'])?$_REQUEST['comment']:"";
	
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
	if (empty($campaign_id)) {
		$response['success']=false;
		$response['message']="you must include 'campaign_id' in your request";
		die(json_encode($response));
	}
	if (empty($comment)) {
		$response['success']=false;
		$response['message']="you must include 'Comment' in your request";
		die(json_encode($response));
	}

	$data = array();
	$data['comment']=$comment;
	$data['campaign_id']=$campaign_id;
	$data['user_id']=$user_id;
	$data['user_type']=$user_type;
	$data['status']="1";
	$data['entry_date']=date("Y-m-d H:i:s");
	
	$result=$obj->add_Edit_mst_campaign_comment($data);
	if($result){
		$response['success']=true;
		$response['message']="Comment Added Successfully.";
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));
	}
?>
