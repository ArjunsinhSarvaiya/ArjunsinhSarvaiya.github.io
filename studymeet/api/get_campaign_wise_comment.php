<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$campaign_id = isset($_REQUEST['campaign_id'])?$_REQUEST['campaign_id']:"";
	$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";
	$limit_start = isset($_REQUEST['limit_start'])?$_REQUEST['limit_start']:"";

	if (empty($campaign_id)) {
		$response['success']=false;
		$response['message']="you must include 'campaign_id' in your request";
		die(json_encode($response));
	}

	$data = array();
	$data['campaign_id']=$campaign_id;
	if (!empty($status)) {
		$data['status']=$status;
	}

	$result=$obj->get_mst_campaign_comment($data,"",$limit_start,"20");
	if($result){
		$finel_array=array();
		$i=0;
		foreach ($result as $key => $value) {
			$value->entry_date=date("d-m-Y h:iA",strtotime($value->entry_date));
			
			if ($value->user_type=="1") {
				$s_data = array();
				$s_data['student_id']=$value->user_id;
				$user_result=$obj->getmst_student($s_data);
				if ($user_result) {
					$value->name = $user_result->name;
					$value->mobile = $user_result->mobile;
					$value->image = $user_result->image;
					$value->city = $user_result->city;
					$value->gmail = $user_result->gmail;
					$value->class = $user_result->class;

					$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $user_result->school_name,));
					if ($school_result) {
						$value->school_name = $school_result->school_collage_name;
					}else{
						$value->school_name = $user_result->school_name;
					}
					$value->medium = $user_result->medium;
					$value->stream = $user_result->stream;
				}
			}else if ($value->user_type=="2") {
				$s_data = array();
				$s_data['teacher_id']=$value->user_id;
				$user_result=$obj->getmst_mst_teacher($s_data);
				if ($user_result) {
					$value->name = $user_result->name;
					$value->mobile = $user_result->mobile;
					$value->image = $user_result->image;
					$value->city = $user_result->city;
					$value->gmail = $user_result->gmail;
					$value->class = "";
					$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $user_result->school_name,));
					if ($school_result) {
						$value->school_name = $school_result->school_collage_name;
					}else{
						$value->school_name = $user_result->school_name;
					}
					$value->medium = "";
					$value->stream = "";
				}
			}
			$finel_array[$i]=$value;
			$i++;
		}
		$response['success']=true;
		$response['message']="Data Found.";
		$response["result"] = $finel_array;
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Data Not Available.";
		die(json_encode($response));
	}
?>
