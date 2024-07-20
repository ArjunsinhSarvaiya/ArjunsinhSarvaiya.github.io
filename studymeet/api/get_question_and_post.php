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
	$data['status']="2";

	$result=$obj->getmst_mst_friends($data,"","","","","",$user_id,$user_type);
	if($result){
		$admin_data->friend_id="";
		$admin_data->my_id=$user_id;
		$admin_data->my_type=$user_type;
		$admin_data->other_user_id="1";
		$admin_data->other_user_type="1";
		$admin_data->sender_id="";
		$admin_data->sender_type="";
		$admin_data->status="2";
		$admin_data->entry_Date="";
		$result[]=$admin_data;
		
		$question_post_result=$obj->getmst_mst_question(array(),"",$user_id,$user_type,$result,$limit_start,"20");

		$finel_array=array();
		$i=0;
		foreach ($question_post_result as $key => $value) {
			$value->entry_date=$value->entry_date;
			if ($value->user_type=="1") {
				$data = array();
				$data['student_id']=$value->user_id;
				$user_result=$obj->getmst_student($data);
				if ($user_result) {
					$value->user_id 	= $user_result->student_id;
					$value->user_type 	= "1";
					$value->name 		= $user_result->name;
					$value->mobile 		= $user_result->mobile;
					$value->image 		= $user_result->image;
					$value->city 		= $user_result->city;
					$value->gmail 		= $user_result->gmail;
					$value->class 		= $user_result->class;

					$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $user_result->school_name,));
					if ($school_result) {
						$value->school_name = $school_result->school_collage_name;
					}else{
						$value->school_name = $user_result->school_name;
					}
					$value->medium 		= $user_result->medium;
					$value->stream 		= $user_result->stream;
				}
			}else if ($value->user_type=="2") {
				$data = array();
				$data['teacher_id']=$value->user_id;
				$user_result=$obj->getmst_mst_teacher($data);
				if ($user_result) {
					$value->user_id 	= $user_result->teacher_id;
					$value->user_type 	= "2";
					$value->name 		= $user_result->name;
					$value->mobile 		= $user_result->mobile;
					$value->image 		= $user_result->image;
					$value->city 		= $user_result->city;
					$value->gmail 		= $user_result->gmail;
					$value->class 		= "";

					$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $user_result->school_name,));
					if ($school_result) {
						$value->school_name = $school_result->school_collage_name;
					}else{
						$value->school_name = $user_result->school_name;
					}
					$value->medium 		= "";
					$value->stream 		= "";
				}
			}

			$total_result=$obj->get_count_of_answer_comment($value->question_id);

			$value->total_answer = $total_result[0]->answer;
			$value->total_comment = $total_result[1]->comment;
			if ($value->post_type=="2") {
				$attempt_data=array();
				$attempt_data['user_id']=$user_id;
				$attempt_data['user_type']=$user_type;
				$attempt_data['question_id']=$value->question_id;
				$attempt_check=$obj->getmst_mst_question_answer($attempt_data);
				if ($attempt_check) {
					$value->attempt_type="1";
					$value->attempt_answer=$attempt_check[0]->answer;

				}else{
					$value->attempt_type="2";
					$value->attempt_answer="";
				}
			}else{
				$value->attempt_type="2";
				$value->attempt_answer="";
			}
			//attempt_type = 1 means attempted
			//attempt_type = 2 means Not attempted

			$finel_array[$i]=$value;
			$i++;
		}

		if ($user_type=="1") {
			$data = array();
			$data['student_id']=$user_id;
			$user_result=$obj->getmst_student($data);
		}else if ($user_type=="2") {
			$data = array();
			$data['teacher_id']=$user_id;
			$user_result=$obj->getmst_mst_teacher($data);
		}
		$admin_post_result=array();
		if ($user_result) {
			$post_filter=array('status' => 1,);
			if (!empty($user_result->city)) {
				$post_filter['city'] = $user_result->city;
			}
			if (!empty($user_result->state)) {
				$post_filter['state'] = $user_result->state;
			}
			$admin_post_result=$obj->getmst_admin_post($post_filter,"","ASC");	
		}
		$response['success']=true;
		$response['message']="Data Found.";
		$response["result"] = $finel_array;
		$response["admin_post"] = $admin_post_result;
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Data Not Available.";
		die(json_encode($response));
	}
?>
