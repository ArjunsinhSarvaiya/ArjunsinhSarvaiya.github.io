<?php
	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
	
	$obj = new StudyMeet();
	$plan_id=isset($_REQUEST['plan_id'])?$_REQUEST['plan_id']:"";

    if (empty($plan_id)) {
		$response['success']=false;
		$response['message']="Please Add plan_id";
		die(json_encode($response));
	}
	
	$data =array("plan_id"=>$plan_id);
	$filter=array("status"=>1);	
    $result=$obj->getmst_mst_plans($data,$filter);

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
