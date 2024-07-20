<?php
	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
	
	$obj = new StudyMeet();
	$student_id=isset($_REQUEST['student_id'])?$_REQUEST['student_id']:"";

    if (empty($student_id)) {
		$response['success']=false;
		$response['message']="Please Add student_id";
		die(json_encode($response));
	}
	
	$data =array("student_id"=>$student_id);
	$filter=array("status"=>1);	
    $result=$obj->getmst_student($data,$filter);

	if($result){

		$response['success']=true;
		$response['message']="Data Found.";
		$response["result"] = $result;
		die(json_encode($response));
		
	}else{

		$response['success']=false;
		$response['message']="Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));

	}
	
?>
