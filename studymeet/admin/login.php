<?php
	include('../config/config.php');
	include(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$error = $success = array();
	$obj = new StudyMeet();
	$user_id = $role_id = $admin_id ="";
	
	$username = isset($_REQUEST['username'])?$_REQUEST['username']:"";
	$password = isset($_REQUEST['password'])?$_REQUEST['password']:"";
	$device_token  = isset($_REQUEST['device_token'])?$_REQUEST['device_token']:"";
	
	if(empty($username)){
		$response['success']=false;
		$response['message']="You must include a username var in your request.";
		die(json_encode($response));
	}
	if(empty($password)){
		$response['success']=false;
		$response['message']="You must include a password var in your request.";
		die(json_encode($response));
	}
	if(empty($device_token)){
		$response['success']=false;
		$response['message']="You must include a device_token var in your request.";
		die(json_encode($device_token));
	}
    
    $result = $obj->CheckAuthentication($username,$password,$role_id);

    if(!empty($result) && isset($result->error)){
	    $response['success'] = false;
		$response['message'] = $result->error;
		die(json_encode($response));
	}
	if(!empty($result)){

		$add_result=$obj->addEdit_emp(array('device_token' => $device_token,),$result->emp_id);
		

		$return_array["emp_name"]=$result->emp_name;
		$return_array["role_id"]=$result->role_id;
		$return_array["emp_id"]=$result->emp_id;

		$response['success']=true;
		$response['message']="Login Successfully";
		$response['result']=$return_array;
	    die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Email Id Or Password Incorrect";
		die(json_encode($response));
	} 
    
?>