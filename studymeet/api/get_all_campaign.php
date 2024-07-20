<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$limit_start = isset($_REQUEST['limit_start'])?$_REQUEST['limit_start']:"";
	$search_text = isset($_REQUEST['search_text'])?$_REQUEST['search_text']:"";

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
	$class_name = "";
	$school_name = "";
	if ($user_type=="1") {
		$data = array();
		$data['student_id']=$user_id;
		$user_result=$obj->getmst_student($data);
		if ($user_result) {
			$class_name = $user_result->class;
			$school_name = $user_result->school_name;
		}
	}else if ($user_type=="2") {
		$data = array();
		$data['teacher_id']=$user_id;
		$user_result=$obj->getmst_mst_teacher($data);
		if ($user_result) {
			$school_name = $user_result->school_name;
		}
	}

	$friend_list=array();
	$data = array();
	$data['status']="2";
	$friend_data=$obj->getmst_mst_friends($data,"","","","","",$user_id,$user_type);
	if ($friend_data) {
		$i=0;
		foreach ($friend_data as $key => $value) {
			if ($value->my_type==$user_type && $value->my_id==$user_id) {
				$friend_list[$i]['user_id']=$value->other_user_id;
				$friend_list[$i]['user_type']=$value->other_user_type;
				$i++;
			}else if ($value->other_user_type==$user_type && $value->other_user_id==$user_id) {
				$friend_list[$i]['user_id']=$value->my_id;
				$friend_list[$i]['user_type']=$value->my_type;
				$i++;
			}
		}
	}

	$data = array();
	$data['status']="1";
	if (!empty($search_text)) {
		$result=$obj->getmst_mst_campaign($data,"",$limit_start,"20",$search_text,"","",array());	
	}else if (!empty($school_name) || !empty($class_name) || !empty($friend_list)) {
		
		$result=$obj->getmst_mst_campaign($data,"",$limit_start,"20",$search_text,$school_name,$class_name,$friend_list);	
	}
	$finel_array=array();
	if ($limit_start==0) {
		$friend_list_for_admin_campaign[0]['user_id']="1";
		$friend_list_for_admin_campaign[0]['user_type']="1";
		$admin_campaign_result=$obj->getmst_mst_campaign($data,"",$limit_start,"20",$search_text,$school_name,$class_name,$friend_list_for_admin_campaign);

		$data = array();
		$data['student_id']="1";
		$admin_user_result=$obj->getmst_student($data);

		foreach ($admin_campaign_result as $key => $value) {
			$count_result=$obj->get_count_campaings($value->campaign_id);
			$value->total_participents=$count_result->total_campaign;

			$value->user_name = $admin_user_result->name;
			$value->user_mobile = $admin_user_result->mobile;
			$value->user_image = $admin_user_result->image;
			$value->user_city = "";
			$value->user_gmail = "";
			$value->user_class = "";
			$value->user_school_name = "";
			$value->user_medium = "";
			$value->user_stream = "";
			
			if ($value->status=="1") {
				$expiry = strtotime($value->to_date);
				if (!empty($value->to_time)) {
					$expiry = $expiry+strtotime($value->to_time);
				}
				$current = strtotime(date("d-m-Y H:i:s"));
				if ($expiry<=$current) {
					$data = array();
					$data['status']="2";

					$campaign_update=$obj->addEdit_mst_campaign($data,$value->campaign_id);
					if ($campaign_update) {
						$value->status="2";
					}
				}else{
					$finel_array[]=$value;
				}
			}
		}
	}
	if(isset($result) && !empty($result)){
		foreach ($result as $key => $value) {
			$count_result=$obj->get_count_campaings($value->campaign_id);
			$value->total_participents=$count_result->total_campaign;
			if ($value->user_type=="1") {
				$data = array();
				$data['student_id']=$value->user_id;
				$user_result=$obj->getmst_student($data);
				if ($user_result) {
					$value->user_name = $user_result->name;
					$value->user_mobile = $user_result->mobile;
					$value->user_image = $user_result->image;
					$value->user_city = $user_result->city;
					$value->user_gmail = $user_result->gmail;
					$value->user_class = $user_result->class;
					$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $user_result->school_name,));
					if ($school_result) {
						$value->user_school_name = $school_result->school_collage_name;
					}else{
						$value->user_school_name = $user_result->school_name;
					}
					$value->user_medium = $user_result->medium;
					$value->user_stream = $user_result->stream;
				}
			}else if ($value->user_type=="2") {
				$data = array();
				$data['teacher_id']=$value->user_id;
				$user_result=$obj->getmst_mst_teacher($data);
				if ($user_result) {
					$value->user_name = $user_result->name;
					$value->user_mobile = $user_result->mobile;
					$value->user_image = $user_result->image;
					$value->user_city = $user_result->city;
					$value->user_gmail = $user_result->gmail;
					$value->user_class = "";

					$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $user_result->school_name,));
					if ($school_result) {
						$value->user_school_name = $school_result->school_collage_name;
					}else{
						$value->user_school_name = $user_result->school_name;
					}
					$value->user_medium = "";
					$value->user_stream = "";
				}
			}
			if ($value->status=="1") {
				$expiry = strtotime($value->to_date);
				if (!empty($value->to_time)){
					$expiry = $expiry+strtotime($value->to_time);
				}
				$current = strtotime(date("d-m-Y H:i:s"));
				if ($expiry<=$current) {
					$data = array();
					$data['status']="2";

					$campaign_update=$obj->addEdit_mst_campaign($data,$value->campaign_id);
					if ($campaign_update) {
						$value->status="2";
					}
				}else{
					$finel_array[]=$value;
				}
			}
		}
		$response['success']=true;
		$response['message']="Data Found.";
		$response["result"] = $finel_array;
		die(json_encode($response));
	}else{
		if ($finel_array) {
			$response['success']=true;
			$response['message']="Data Found.";
			$response["result"] = $finel_array;
			die(json_encode($response));	
		}else{
			$response['success']=false;
			$response['message']="Data Not Available.";
			die(json_encode($response));	
		}
	}
?>
