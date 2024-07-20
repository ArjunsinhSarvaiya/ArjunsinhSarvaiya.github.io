<?php
	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
	
	$obj = new StudyMeet();

    $result=$obj->getStates();

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

