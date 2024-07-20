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
	$data['status']="1";
	$data['user_id']=$user_id;
	$data['user_type']=$user_type;

	$result=$obj->getmst_mst_question_answer($data,"",$limit_start,"20");
	if($result){

		$finel_array=array();
		$i=0;
		foreach ($result as $key => $value) {
			$value->entry_date=date("d-m-Y h:iA",strtotime($value->entry_date));

			$question_data=$obj->getmst_mst_question(array('question_id' => $value->question_id, ));

			$u_id = $question_data->user_id;
			$u_type = $question_data->user_type;

			if ($question_data) {
				$value->question_text 	= $question_data->question_text;
				$value->question_Image 	= $question_data->question_Image;
				$value->question_video 	= $question_data->question_video;
				$value->option_type 	= $question_data->option_type;
				$value->post_type 	= $question_data->post_type;
				$value->right_answer 	= $question_data->right_answer;
				$value->timer 	= $question_data->timer;
				$value->option_a 	= $question_data->option_a;
				$value->option_b 	= $question_data->option_b;
				$value->option_c 	= $question_data->option_c;
				$value->option_d 	= $question_data->option_d;
				$value->status 	= $question_data->status;
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

			$total_result=$obj->get_count_of_answer_comment($value->question_id);

			$value->total_answer = $total_result[0]->answer;
			$value->total_comment = $total_result[1]->comment;
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
