<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

 			   
	$obj = new StudyMeet();

	$mobile = isset($_REQUEST['mobile'])?$_REQUEST['mobile']:"";
	$gmail = isset($_REQUEST['gmail'])?$_REQUEST['gmail']:"";
	$student_teacher = isset($_REQUEST['student_teacher'])?$_REQUEST['student_teacher']:"";
    
	if (empty($mobile)) {
		$response['success']=false;
		$response['message']="you must include 'mobile' in your request";
		die(json_encode($response));
	}
	if (empty($gmail)) {
		$response['success']=false;
		$response['message']="you must include 'gmail' in your request";
		die(json_encode($response));
	}
	$error_message="";
	$mobile_check="";
	$email_check="";
	if ($student_teacher=="1") {
		$data_std_mobile = array();
		$data_std_mobile['mobile']=$mobile;
		$check_student_mobile=$obj->getmst_student($data_std_mobile);
		if($check_student_mobile){
			$mobile_check="Mobile Number Already Registered As Student";
		}

		$data_std_email = array();
		$data_std_email['gmail']=$gmail;
		$check_student_email=$obj->getmst_student($data_std_email);
		if($check_student_email){
			$email_check="Email Id Already Registered As Student";
		}
		if (!empty($email_check) && !empty($mobile_check)) {
			$error_message="Mobile Number And Email Id Already Registered As Student";
		}else if (!empty($email_check)) {
			$error_message=$email_check;
		}else if (!empty($mobile_check)) {
			$error_message=$mobile_check;
		}
	}else{
		$data_teacher_mobile = array();
		$data_teacher_mobile['mobile']=$mobile;
		$check_teacher_mobile=$obj->getmst_mst_teacher($data_teacher_mobile);

		if($check_teacher_mobile){
			$mobile_check="Mobile Number Already Registered As Teacher";
		}

		$data_teacher_email = array();
		$data_teacher_email['gmail']=$gmail;
		$check_teacher_email=$obj->getmst_mst_teacher($data_teacher_email);

		if($check_teacher_email){
			$email_check="Email Id Already Registered As Teacher";
		}

		if (!empty($email_check) && !empty($mobile_check)) {
			$error_message="Mobile Number And Email Id Already Registered As Student";
		}else if (!empty($email_check)) {
			$error_message=$email_check;
		}else if (!empty($mobile_check)) {
			$error_message=$mobile_check;
		}
	}
	if (empty($error_message)) {
		$response['success']=true;
		$response['message']="Unique Mobile Number And Email Id.";
		die(json_encode($response));		
	}else {
		$response['success']=false;
		$response['message']=$error_message;
		die(json_encode($response));
	}
?>
