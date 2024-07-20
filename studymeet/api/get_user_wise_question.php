<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";

	$u_id = isset($_REQUEST['u_id'])?$_REQUEST['u_id']:"";
	$u_type = isset($_REQUEST['u_type'])?$_REQUEST['u_type']:"";

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
	$data['post_type']="2";
	$result=$obj->getmst_mst_question($data);
	if($result){
		$i=0;
		foreach ($result as $key => $value) {
			$all_entry="";
			if ($user_id==$u_id && $user_type==$u_type) {
				$all_entry="All";
			}
			$total_result=$obj->get_count_of_answer_comment($value->question_id,$all_entry);
			$result[$i]->total_answer = $total_result[0]->answer;
			$result[$i]->total_comment = $total_result[1]->comment;
			if ($value->post_type=="2") {
				$attempt_data=array();
				$attempt_data['user_id']=$u_id;
				$attempt_data['user_type']=$u_type;
				$attempt_data['question_id']=$value->question_id;
				$attempt_check=$obj->getmst_mst_question_answer($attempt_data);
				if ($attempt_check) {
					$result[$i]->attempt_type="1";
					$result[$i]->attempt_answer=$attempt_check[0]->answer;
				}else{
					$result[$i]->attempt_type="2";
					$result[$i]->attempt_answer="";
				}
			}else{
				$result[$i]->attempt_type="2";
				$result[$i]->attempt_answer="";
			}
			$i++;
		}

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
