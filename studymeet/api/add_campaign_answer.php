<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$point=0;
	$join_id="";
	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$campaign_id = isset($_REQUEST['campaign_id'])?$_REQUEST['campaign_id']:"";
	$answer_type = isset($_REQUEST['answer_type'])?$_REQUEST['answer_type']:"";
	$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";

	$trn_campaign_id = isset($_REQUEST['trn_campaign_id'])?$_REQUEST['trn_campaign_id']:"";
	$user_answer = isset($_REQUEST['user_answer'])?$_REQUEST['user_answer']:"";

	$file = isset($_REQUEST['file'])?$_REQUEST['file']:"";
	$file_formate = isset($_REQUEST['file_formate'])?$_REQUEST['file_formate']:"";
	$complate_timer = isset($_REQUEST['complate_timer'])?$_REQUEST['complate_timer']:"";
	
	//answer_type = 1 Means  Answer Is True
	//answer_type = 2 Means  Answer Is Wrong

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
	if (empty($status)) {
		$response['success']=false;
		$response['message']="you must include 'status' in your request";
		die(json_encode($response));
	}
	if (empty($trn_campaign_id)) {
		$response['success']=false;
		$response['message']="you must include 'trn_campaign_id' in your request";
		die(json_encode($response));
	}

	$data_check = array();
	$data_check['campaign_id']=$campaign_id;
	$data_check['user_id']=$user_id;
	$data_check['user_type']=$user_type;

	$join_result=$obj->getmst_mst_join_campaign($data_check);
	if ($join_result) {
		$join_id=$join_result[0]->join_id;
		$point=$join_result[0]->point;	
	}
	$point=$point+5;

	$data = array();
	$data['campaign_id']=$campaign_id;
	$data['user_id']=$user_id;
	$data['user_type']=$user_type;
	$data['status']=$status;
	if ($status=="1") {
		$data['complate_timer']=$complate_timer;	
	}

	if (!empty($join_id)) {
		$data['update_date']=date("Y-m-d H:i:s");
	}else{
		$data['entry_date']=date("Y-m-d H:i:s");
	}

	if ($answer_type=="1") {
		$data['point']=$point;
	}
	
	//echo $join_id." = ".$point." <pre>";print_r($data);die();
	$result=$obj->addEdit_mst_join_campaign($data,$join_id);
	if($result){

	    if (!file_exists(CAMPAIGN_FILE_IMG_PATH)) {
	    	mkdir(CAMPAIGN_FILE_IMG_PATH);
	    }
		$file_name = "File_".time().'.pdf';
		if (!empty($file_formate)) {
			$file_name = "File_".time().'.'.$file_formate;
		}
		$file_path = CAMPAIGN_FILE_IMG_PATH.$file_name;


		$question_data=$obj->getmst_trn_campaign(array('trn_campaign_id' => $trn_campaign_id,));
		if (empty($join_id)) {
			$join_id=$result;
		}
		$q_data = array();
		$q_data['join_id']=$join_id;
		$q_data['trn_campaign_id']=$trn_campaign_id;
		$q_data['user_answer']=$user_answer;
		$q_data['answer_status']=$answer_type;
		$q_data['question_title']=$question_data->question_title;
		$q_data['option_type']=$question_data->option_type;
		$q_data['right_answer']=$question_data->right_answer;
		$q_data['option_a']=$question_data->option_a;
		$q_data['option_b']=$question_data->option_b;
		$q_data['option_c']=$question_data->option_c;
		$q_data['option_d']=$question_data->option_d;
		$q_data['entry_date']=date("Y-m-d H:i:s");

		if (!empty($file)) {
			$q_data['file']=$file_name;
		}
		$question_result=$obj->addEdit_trn_join_campaign($q_data);
		if ($question_result) {
			if (!empty($file)) {
				file_put_contents($file_path, base64_decode($file));
			}	
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
