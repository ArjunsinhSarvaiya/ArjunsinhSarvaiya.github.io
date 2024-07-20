<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$friend_type = isset($_REQUEST['friend_type'])?$_REQUEST['friend_type']:"";
	$limit_start = isset($_REQUEST['limit_start'])?$_REQUEST['limit_start']:"";
	
	//friend_type 1 pending friend, requested friend
	//friend_type 2 Friend LIst

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
	if (empty($friend_type)) {
		$response['success']=false;
		$response['message']="you must include 'friend_type' in your request";
		die(json_encode($response));
	}

	$data = array();
	$data['status']=$friend_type;

	$result=$obj->getmst_mst_friends($data,"","","","","",$user_id,$user_type,$limit_start,"20");
	if($result){
		$finel_array=array();
		$i=0;
		foreach ($result as $key => $value) {
			$u_id="";
			$u_type="";
			if ($value->my_id==$user_id && $value->my_type==$user_type) {
				$u_id=$value->other_user_id;
				$u_type=$value->other_user_type;
			}else if ($value->other_user_id==$user_id && $value->other_user_type==$user_type) {
				$u_id=$value->my_id;
				$u_type=$value->my_type;
			}
			if ($u_type=="1") {
				$data = array();
				$data['student_id']=$u_id;
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
				}else{

					$value->user_id = "";
					$value->user_type = "";
					$value->name = "";
					$value->mobile = "";
					$value->image = "";
					$value->city = "";
					$value->gmail = "";
					$value->class = "";
					$value->school_name = "";
					$value->medium = "";
					$value->stream = "";
				}
			}else if ($u_type=="2") {
				$data = array();
				$data['teacher_id']=$u_id;
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
				}else{
					$value->user_id = "";
					$value->user_type = "";
					$value->name = "";
					$value->mobile = "";
					$value->image = "";
					$value->city = "";
					$value->gmail = "";
					$value->class = "";
					$value->school_name = "";
					$value->medium = "";
					$value->stream = "";
				}
			}

			if ($value->status=="1") {
				if ($value->my_id!=$user_id && $value->my_type!=$user_type) {
					$finel_array[$i]=$value;
				}else{
					$value->status="4";
					$finel_array[$i]=$value;
				}
			}else{
				$finel_array[$i]=$value;
			}
			$i++;
		}
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
	}else{
		$response['success']=false;
		$response['message']="Data Not Available.";
		die(json_encode($response));
	}
?>
