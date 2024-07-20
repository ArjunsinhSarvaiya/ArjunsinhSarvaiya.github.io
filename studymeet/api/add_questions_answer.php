<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$question_id = isset($_REQUEST['question_id'])?$_REQUEST['question_id']:"";
	$answer = isset($_REQUEST['answer'])?$_REQUEST['answer']:"";
	$file = isset($_REQUEST['file'])?$_REQUEST['file']:"";
	$file_formate = isset($_REQUEST['file_formate'])?$_REQUEST['file_formate']:"";
	$right_answer = isset($_REQUEST['right_answer'])?$_REQUEST['right_answer']:"";
	$option_type = isset($_REQUEST['option_type'])?$_REQUEST['option_type']:"";
	
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
	if (empty($question_id)) {
		$response['success']=false;
		$response['message']="you must include 'question_id' in your request";
		die(json_encode($response));
	}

    if (!file_exists(QUESTION_FILE_IMG_PATH)) {
    	mkdir(QUESTION_FILE_IMG_PATH);
    }
	
	$file_name = "File_".time().'.pdf';
	if (!empty($file_formate)) {
		$file_name = "File_".time().'.'.$file_formate;
	}
	$file_path = QUESTION_FILE_IMG_PATH.$file_name;

	$data = array();
	$data['answer']=$answer;
	$data['question_id']=$question_id;
	$data['user_id']=$user_id;
	$data['user_type']=$user_type;
	$data['status']="1";
	$data['entry_date']=date("Y-m-d H:i:s");

	if (!empty($file)) {
		$data['file']=$file_name;
	}

	if ($option_type=="1") {
		if ($answer==$right_answer) {
			$data['answer_type']=1;
		}else{
			$data['answer_type']=2;
		}
	}
	
	$result=$obj->addEdit_mst_question_answer($data);
	if($result){

		if (!empty($file)) {
			file_put_contents($file_path, base64_decode($file));
		}
		$response['success']=true;
		$response['message']="Answer Added Successfully.";
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));
	}
?>
