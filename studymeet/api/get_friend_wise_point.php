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
	$data['status']=2;

	$result=$obj->getmst_mst_friends($data,"","","","","",$user_id,$user_type,$limit_start,"20");
	if($result){
		$finel_array=array();
		$i=0;
		foreach ($result as $key => $value) {
			$value->entry_date=date("d-m-Y h:iA",strtotime($value->entry_date));
			
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
					$value->school_name = $user_result->school_name;
					$value->medium = $user_result->medium;
					$value->stream = $user_result->stream;
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
					$value->school_name = $user_result->school_name;
					$value->medium = "";
					$value->stream = "";
				}
			}

			$total_campaign_point=$obj->get_user_wise_total_point($u_id,$u_type);
			$total_question=$obj->get_user_wise_answer_question($u_id,$u_type,"1");
			$point = $total_campaign_point->total_point+$total_question->total_point;

			if ($point>0) {
				$value->point=$point;
				$finel_array[$i]=$value;
			}
			$i++;
		}
		$finel_array=sortBy("point",$finel_array,"desc");

		$response['success']=true;
		$response['message']="Data Found.";
		$response["result"] = $finel_array;
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Data Not Available.";
		die(json_encode($response));
	}
	function cmp($a, $b)
    {
        return strcmp($a->point, $b->point);
    }
	function sortBy($field, $array, $direction = 'asc'){
    	usort($array, create_function('$a, $b', '
	        $a = $a->' . $field . ';
	        $b = $b->' . $field . ';

	        if ($a == $b)
	        {
	            return 0;
	        }

	        return ($a ' . ($direction == 'desc' ? '>' : '<') .' $b) ? -1 : 1;
	    '));
    	return $array;
	}
?>
