<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$type = isset($_REQUEST['type'])?$_REQUEST['type']:"";

	$data = array();
	$data['status']="1";
	if (!empty($type)) {
		$data['type']=$type;	
	}
	$result=$obj->getmst_mst_school_collage($data);
	if($result){
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
