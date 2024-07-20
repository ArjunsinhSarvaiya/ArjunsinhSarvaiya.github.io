<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$question_id = isset($_REQUEST['question_id'])?$_REQUEST['question_id']:"";

	if (empty($question_id)) {
		$response['success']=false;
		$response['message']="you must include 'question_id' in your request";
		die(json_encode($response));
	}

	$data = array();
	$data['question_id']=$question_id;
	$result=$obj->getmst_mst_question($data);
	if($result){

		if ($result->user_type=="1") {
			$data = array();
			$data['student_id']=$result->user_id;
			$user_result=$obj->getmst_student($data);
			if ($user_result) {
				$result->name = $user_result->name;
				$result->mobile = $user_result->mobile;
				$result->image = $user_result->image;
				$result->city = $user_result->city;
				$result->gmail = $user_result->gmail;
				$result->class = $user_result->class;

				$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $user_result->school_name,));
				if ($school_result) {
					$result->school_name = $school_result->school_collage_name;
				}else{
					$result->school_name = $user_result->school_name;
				}
				$result->medium = $user_result->medium;
				$result->stream = $user_result->stream;
			}
		}else if ($result->user_type=="2") {
			$data = array();
			$data['teacher_id']=$result->user_id;
			$user_result=$obj->getmst_mst_teacher($data);
			if ($user_result) {
				$result->name = $user_result->name;
				$result->mobile = $user_result->mobile;
				$result->image = $user_result->image;
				$result->city = $user_result->city;
				$result->gmail = $user_result->gmail;
				$result->class = "";

				$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $user_result->school_name,));
				if ($school_result) {
					$result->school_name = $school_result->school_collage_name;
				}else{
					$result->school_name = $user_result->school_name;
				}
				$result->medium = "";
				$result->stream = "";
			}
		}

		$already_answer=false;
		$my_answer="";
		$status="";
		if (!empty($user_id) && !empty($user_type)) {
			$answer_filter = array(
						'question_id' => $question_id,
						'user_id' => $user_id,
						'user_type' => $user_type, );

			$already_answer_result=$obj->getmst_mst_question_answer($answer_filter);
			if ($already_answer_result) {
				$already_answer=true;
				$my_answer=$already_answer_result[0]->answer;
				$status=$already_answer_result[0]->status;
			}
		}

		$total_result=$obj->get_count_of_answer_comment($question_id);

		$response['success']=true;
		$response['message']="Data Found.";
		$response["total_answer"] = $total_result[0]->answer;
		$response["total_comment"] = $total_result[1]->comment;
		$response["already_answer"] = $already_answer;
		$response["my_answer"] = $my_answer;
		$response["status"] = $status;
		$response["result"] = $result;
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Data Not Available.";
		die(json_encode($response));
	}
?>
