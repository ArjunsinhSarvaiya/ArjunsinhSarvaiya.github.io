<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$limit_start = isset($_REQUEST['limit_start'])?$_REQUEST['limit_start']:"";

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

	$data = array();
	$data['user_id']=$user_id;
	$data['user_type']=$user_type;

	$result=$obj->getmst_mst_join_campaign($data,"",$limit_start,"20");
	if($result){

		$finel_array=array();
		$i=0;
		foreach ($result as $key => $value) {
			$value->entry_date=date("d-m-Y h:iA",strtotime($value->entry_date));

			$campaign_data=$obj->getmst_mst_campaign(array('campaign_id' => $value->campaign_id, ));
			
			$value->status = $campaign_data->status;
			$value->result = $campaign_data->result;
			if ($campaign_data->status=="1") {
				$expiry = strtotime($campaign_data->to_date);
				if (!empty($campaign_data->to_time)){
					$expiry = $expiry+strtotime($campaign_data->to_time);
				}
				$current = strtotime(date("d-m-Y H:i:s"));
				
				if ($expiry<=$current) {
					$data = array();
					$data['status']="2";

					$campaign_update=$obj->addEdit_mst_campaign($data,$value->campaign_id);
					if ($campaign_update) {
						$value->status = "2";
					}
				}
			}

			$u_id = $campaign_data->user_id;
			$u_type = $campaign_data->user_type;
			$value->creater_id=$u_id;
			$value->creater_type=$u_type;
			if ($campaign_data) {
				$value->campaign_name 	= $campaign_data->campaign_name;
				$value->campaign_image 	= $campaign_data->campaign_image;
			}
			if ($u_type=="1") {
				$data = array();
				$data['student_id']=$u_id;
				$user_result=$obj->getmst_student($data);
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
			}else if ($u_type=="2") {
				$data = array();
				$data['teacher_id']=$u_id;
				$user_result=$obj->getmst_mst_teacher($data);
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

			$join_result=$obj->get_user_rank($value->campaign_id, $user_id, $user_type);

			$value->join_rank = $join_result->rank;

			$count_result=$obj->get_count_campaings($value->campaign_id);
			$value->total_participents=$count_result->total_campaign;

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
