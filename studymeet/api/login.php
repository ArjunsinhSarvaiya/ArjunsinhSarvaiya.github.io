<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

    
	$obj = new StudyMeet();

	$mobile_no = isset($_REQUEST['mobile_no'])?$_REQUEST['mobile_no']:"";
	$token = isset($_REQUEST['token'])?$_REQUEST['token']:"";
    
	if (empty($mobile_no)) {
		$response['success']=false;
		$response['message']="you must include 'mobile_no' in your request";
		die(json_encode($response));
	}
	$data = array();
	$data['mobile']=$mobile_no;
	$result=$obj->getmst_student($data);
	if($result){
		if ($result[0]->status=="2") {
			$response['success']=false;
			$response['message']="Your Account Is InActive, Contact To Admin.";
			die(json_encode($response));
		}
		
		if (!empty($token)) {
			$d_data=array();
			$d_data['deice_token'] = $token;
			$update_result=$obj->addEdit_mst_student($d_data,$result[0]->student_id);
		}
		
		$response['success']=true;
		$response['message']="Login Successfully.";
		$response["user_id"] = $result[0]->student_id;
		$response["user_type"] = "1";
		$response["name"] = $result[0]->name;
		$response["mobile"] = $result[0]->mobile;
		$response["image"] = $result[0]->image;
		$response["city"] = $result[0]->city;
		$response["state"] = $result[0]->state;		
		$response["gmail"] = $result[0]->gmail;
		$response["class"] = $result[0]->class;

		$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $result[0]->school_name,));
		if ($school_result) {
			$response["school_name"] = $school_result->school_collage_name;
		}else{
			$response["school_name"] = $user_result->school_name;
		}
		$response["medium"] = $result[0]->medium;
		$response["stream"] = $result[0]->stream;
		die(json_encode($response));
	}else{
		$data = array();
		$data['mobile']=$mobile_no;
		$result=$obj->getmst_mst_teacher($data);
		if($result){
			if ($result[0]->status=="2") {
				$response['success']=false;
				$response['message']="Your Account Is InActive, Contact To Admin.";
				die(json_encode($response));
			}

			if (!empty($token)) {
				$d_data=array();
				$d_data['deice_token'] = $token;
				$update_result=$obj->addEdit_mst_teacher($d_data,$result[0]->teacher_id);
			}

			$response['success']=true;
			$response['message']="Login Successfully.";
			$response["user_id"] = $result[0]->teacher_id;
			$response["user_type"] = "2";
			$response["name"] = $result[0]->name;
			$response["mobile"] = $result[0]->mobile;
			$response["image"] = $result[0]->image;
			$response["city"] = $result[0]->city;
		    $response["state"] = $result[0]->state;
			$response["gmail"] = $result[0]->gmail;
			$response["class"] = "";

			$school_result=$obj->getmst_mst_school_collage(array('school_collage_id' => $result[0]->school_name,));
			if ($school_result) {
				$response["school_name"] = $school_result->school_collage_name;
			}else{
				$response["school_name"] = $user_result->school_name;
			}
			$response["medium"] = "";
			$response["stream"] = "";

			die(json_encode($response));
		}else{
			$response['success']=false;
			$response['message']="Login Failed, Please Register Your Self First.";
			die(json_encode($response));
		}
	}
?>
