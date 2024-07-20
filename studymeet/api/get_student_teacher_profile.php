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
	
	$filter=array("status"=>1);	
	if ($user_type=="1") {
		$data = array("student_id"=>$user_id);
		$result=$obj->getmst_student($data,$filter);
	}
	if($user_type=="2"){
		$data = array("teacher_id"=>$user_id);
		$result=$obj->getmst_mst_teacher($data,$filter);
		$result->class="";
		$result->medium="";
		$result->stream="";
	}

	if($result){

	    $finel_array['name'] = $result->name;
	    $finel_array['mobile'] = $result->mobile;
	    $finel_array['image'] = $result->image;
	    $finel_array['city'] = $result->city;
	    $finel_array['state'] = $result->state;
	    $finel_array['gmail'] = $result->gmail;
	    $finel_array['status'] = $result->status;
	    $finel_array['entry_Date'] = $result->entry_Date;
	    $finel_array['class'] = $result->class;

	    if (!empty($result->school_name)) {
			$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $result->school_name,));
			if ($school_result) {
				$finel_array['school_name'] = $school_result->school_collage_name;
			}else{
				$finel_array['school_name'] = $user_result->school_name;
			}
	    }else{
			$finel_array['school_name'] = "";
	    }
	    $finel_array['medium'] = $result->medium;	   
	    $finel_array['stream'] =$result->stream;

		$data = array();
		$data['status']=2;
		$friend_result=$obj->get_count_friends($data,"","","","","",$user_id,$user_type);

	    $finel_array['total_Friend'] =$friend_result->total_Friend;

		$data = array();
		$data['status']=1;
		$request_result=$obj->get_count_friends($data,"","","","","",$user_id,$user_type);

	    $finel_array['total_request'] =$request_result->total_Friend;
		$finel_array['friend']="0";
	    if ($user_id!=$u_id || $user_type!=$u_type) {
			$friend_check=$obj->getmst_mst_friends(array(),"",$user_id,$user_type,$u_id,$u_type);
			if ($friend_check) {
				$finel_array['friend']=$friend_check[0]->status;
			}
			if ($friend_check[0]->status=="1") {
				if ($friend_check[0]->my_id==$u_id && $friend_check[0]->my_type==$u_type) {
					$finel_array['friend']="4";
				}else{
					$finel_array['friend']=$friend_check[0]->status;
				}
			}else if ($friend_check[0]->status=="1"){
				$result[$i]['friend']=$friend_check[0]->status;
			}
	    }

		$today_campaign_point=$obj->get_user_wise_total_point($u_id,$u_type,date("Y-m-d"),date("Y-m-d"));
		$today_question=$obj->get_user_wise_answer_question($u_id,$u_type,"1",date("Y-m-d"),date("Y-m-d"));
		$response['success']=true;
		$response['message']="Data Found.";
		$response["today"] = $today_campaign_point->total_point+$today_question->total_point;
		$response["result"] = $finel_array;
		die(json_encode($response));
		
	}else{

		$response['success']=false;
		$response['message']="Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));

	}
?>
