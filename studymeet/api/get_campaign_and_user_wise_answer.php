<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$join_id = isset($_REQUEST['join_id'])?$_REQUEST['join_id']:"";
	$limit_start = isset($_REQUEST['limit_start'])?$_REQUEST['limit_start']:"";

	if (empty($join_id)) {
		$response['success']=false;
		$response['message']="you must include 'join_id' in your request";
		die(json_encode($response));
	}

	$data = array();
	$data['join_id']=$join_id;

	$result=$obj->getmst_trn_join_campaign($data,"",$limit_start,"20");
	if($result){

		$finel_array=array();
		$i=0;
		foreach ($result as $key => $value) {
			$value->entry_date=date("d-m-Y h:iA",strtotime($value->entry_date));
			
			$join_result=$obj->getmst_mst_join_campaign(array('join_id' => $value->join_id, ));
				
			if ($join_result->user_type=="1") {
				$data = array();
				$data['student_id']=$join_result->user_id;
				$user_result=$obj->getmst_student($data);
				
				if ($user_result) {
					$value->user_id = $user_result->student_id;
					$value->user_type = "1";
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
			}else if ($join_result->user_type=="2") {
				$data = array();
				$data['teacher_id']=$join_result->user_id;
				$user_result=$obj->getmst_mst_teacher($data);

				if ($user_result) {
					$value->user_id = $user_result->teacher_id;
					$value->user_type = "2";
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
		//echo "<pre>";print_r($result);die();
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
