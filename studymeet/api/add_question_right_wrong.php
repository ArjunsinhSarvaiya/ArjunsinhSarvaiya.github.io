<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$q_answer_id = isset($_REQUEST['q_answer_id'])?$_REQUEST['q_answer_id']:"";
	$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";
	
	if (empty($q_answer_id)) {
		$response['success']=false;
		$response['message']="you must include 'q_answer_id' in your request";
		die(json_encode($response));
	}
	if (empty($status)) {
		$response['success']=false;
		$response['message']="you must include 'status' in your request";
		die(json_encode($response));
	}
	$q_data = array();
	$q_data['answer_type']=$status;
	$q_data['update_date']=date("Y-m-d H:i:s");

	$result=$obj->addEdit_mst_question_answer($q_data,$q_answer_id);
	if($result){
		$response['success']=true;
		$response['message']="Status Change Successfully.";
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));
	}
?>
