<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();
	$campaign_id 		= isset($_REQUEST['campaign_id'])?$_REQUEST['campaign_id']:"";
	$user_id 			= isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type 			= isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$campaign_name 		= isset($_REQUEST['campaign_name'])?$_REQUEST['campaign_name']:"";
	$campaign_image 	= isset($_REQUEST['campaign_image'])?$_REQUEST['campaign_image']:"";
	$campaign_old_image_name 	= isset($_REQUEST['campaign_old_image_name'])?$_REQUEST['campaign_old_image_name']:"";
	$timer_for_campaign = isset($_REQUEST['timer_for_campaign'])?$_REQUEST['timer_for_campaign']:"";
	$from_date 			= isset($_REQUEST['from_date'])?$_REQUEST['from_date']:"";
	$to_date  			= isset($_REQUEST['to_date'])?$_REQUEST['to_date']:"";
	$from_time 			= isset($_REQUEST['from_time'])?$_REQUEST['from_time']:"";
	$to_time  			= isset($_REQUEST['to_time'])?$_REQUEST['to_time']:"";
	$school_collage 	= isset($_REQUEST['school_collage'])?$_REQUEST['school_collage']:"";
	$class 				= isset($_REQUEST['class'])?$_REQUEST['class']:"";
	$all_friends 		= isset($_REQUEST['all_friends'])?$_REQUEST['all_friends']:"";
	$question_data 		= isset($_REQUEST['question_data'])?$_REQUEST['question_data']:"";

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
	if (empty($campaign_name)) {
		$response['success']=false;
		$response['message']="you must include 'campaign_name' in your request";
		die(json_encode($response));
	}
	if (empty($campaign_image) && empty($campaign_id)) {
		$response['success']=false;
		$response['message']="you must include 'campaign_image' in your request";
		die(json_encode($response));
	}
	if (empty($from_date)) {
		$response['success']=false;
		$response['message']="you must include 'from_date' in your request";
		die(json_encode($response));
	}
	if (empty($to_date)) {
		$response['success']=false;
		$response['message']="you must include 'to_date' in your request";
		die(json_encode($response));
	}
	if (empty($from_time)) {
		$response['success']=false;
		$response['message']="you must include 'from_time' in your request";
		die(json_encode($response));
	}
	if (empty($to_time)) {
		$response['success']=false;
		$response['message']="you must include 'to_time' in your request";
		die(json_encode($response));
	}

	if (!empty($campaign_image)) {
        if (!file_exists(CAMPAIGN_FILE_IMG_PATH)) {
        	mkdir(CAMPAIGN_FILE_IMG_PATH);
        }
	}

	$img_name = "Image_".time().'.jpg';
	$image_path = CAMPAIGN_FILE_IMG_PATH.$img_name;

	$data = array();
	$data['user_id']			= $user_id;
	$data['user_type']			= $user_type;
	$data['campaign_name']		= $campaign_name;
	$data['timer']				= $timer_for_campaign;
	$data['from_date']			= $from_date;
	$data['to_date']			= $to_date;
	$data['from_time']			= $from_time;
	$data['to_time']			= $to_time;
	$data['school_collage']		= $school_collage;
	$data['class']				= $class;
	$data['all_friends']		= $all_friends;

	$data['status']			= "1";
	if (!empty($campaign_image)) {
		$data['campaign_image']		= $img_name;
	}
	if (!empty($campaign_id)) {
		$data['update_date']		= date("Y-m-d H:i:s");
	}else {
		$data['entry_date']		= date("Y-m-d H:i:s");
	}

	$result=$obj->addEdit_mst_campaign($data,$campaign_id);
	if($result){
		if (!empty($campaign_image)) {
			file_put_contents($image_path, base64_decode($campaign_image));
			if (!empty($campaign_old_image_name)) {
				unlink(CAMPAIGN_FILE_IMG_PATH.$campaign_old_image_name);
			}
		}
		if (!empty($campaign_id)) {
			$result = $campaign_id;
		}

		foreach (json_decode($question_data) as $value) {
			$q_data = array();
			$q_data['campaign_id'] = $result;
			$q_data['question_title'] = $value->question_title;
			$q_data['time_for_question'] = $value->time_for_question;
			$q_data['option_type'] = $value->option_type;
			$q_data['right_answer'] = $value->right_answer;
			$q_data['option_a'] = $value->option_a;
			$q_data['option_b'] = $value->option_b;
			$q_data['option_c'] = $value->option_c;
			$q_data['option_d'] = $value->option_d;
			$q_data['entry_date'] = date("Y-m-d H:i:s");

			$q_result=$obj->addEdit_trn_campaign($q_data);
		}

		$response['success']=true;
		$response['message']="Campaign Added Successfully.";
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));
	}
?>
