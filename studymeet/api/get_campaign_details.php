<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$campaign_id = isset($_REQUEST['campaign_id'])?$_REQUEST['campaign_id']:"";	
	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";	
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";	

	if (empty($campaign_id)) {
		$response['success']=false;
		$response['message']="you must include 'campaign_id' in your request";
		die(json_encode($response));
	}

	$data = array();
	$data['campaign_id']=$campaign_id;
	$result=$obj->getmst_mst_campaign($data);
	if($result){
		$count_result=$obj->get_count_campaings($campaign_id);
		$result->total_participents=$count_result->total_campaign;
		if ($result->status=="1") {
			$expiry = strtotime($result->to_date);
			if (!empty($result->to_time)){
				$expiry = $expiry+strtotime($result->to_time);
			}
			$current = strtotime(date("d-m-Y H:i:s"));
			if ($expiry<=$current) {
				$data = array();
				$data['status']="2";

				$campaign_update=$obj->addEdit_mst_campaign($data,$result->campaign_id);
				if ($campaign_update) {
					$result->status="2";
				}
			}
		}
		if ($result->user_type=="1") {
			$s_data = array();
			$s_data['student_id']=$result->user_id;
			$user_result=$obj->getmst_student($s_data);
			if ($user_result) {
				$result->user_name = $user_result->name;
				$result->user_mobile = $user_result->mobile;
				$result->user_image = $user_result->image;
				$result->user_city = $user_result->city;
				$result->user_gmail = $user_result->gmail;
				$result->user_class = $user_result->class;
				$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $user_result->school_name,));
				if ($school_result) {
					$result->user_school_name = $school_result->school_collage_name;
				}else{
					$result->user_school_name = $user_result->school_name;
				}
				$result->user_medium = $user_result->medium;
				$result->user_stream = $user_result->stream;
			}
		}else if ($result->user_type=="2") {
			$s_data = array();
			$s_data['teacher_id']=$result->user_id;
			$user_result=$obj->getmst_mst_teacher($s_data);
			if ($user_result) {
				$result->user_name = $user_result->name;
				$result->user_mobile = $user_result->mobile;
				$result->user_image = $user_result->image;
				$result->user_city = $user_result->city;
				$result->user_gmail = $user_result->gmail;
				$result->user_class = "";

				$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $user_result->school_name,));
				if ($school_result) {
					$result->user_school_name = $school_result->school_collage_name;
				}else{
					$result->user_school_name = $user_result->school_name;
				}
				$result->user_medium = "";
				$result->user_user_stream = "";
			}
		}
		$question_result=$obj->getmst_trn_campaign($data,"","Sort By ASC");

		$result->join_status = "";
		$result->point = "";
		$result->join_entry_date = "";
		$result->join_rank = "";
		$result->join_id = "";
		$result->all_question_id="";

		if (!empty($user_id) && !empty($user_type)) {
			$join_result=$obj->get_user_rank($campaign_id, $user_id, $user_type);

			if ($join_result) {
				$result->join_status = $join_result->status;
				$result->point = $join_result->point;
				$result->join_entry_date = $join_result->entry_date;
				$result->join_rank = $join_result->rank;
				$result->join_id = $join_result->join_id;
				if ($join_result->status=="2") {
					$trn_join_result=$obj->getmst_trn_join_campaign(array('join_id' => $join_result->join_id));

        			$all_question_id = implode(",", array_map(function($e) { return is_object($e) ? $e->trn_campaign_id : $e['trn_campaign_id']; }, $trn_join_result));
					$result->all_question_id = $all_question_id;
				}
			}
		}

		$result->question=$question_result;

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
