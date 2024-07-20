<?php
    require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

  	$campaign_id = isset($_REQUEST['campaign_id'])?$_REQUEST['campaign_id']:"";
		
	if (empty($campaign_id)) {
		$response['success']=false;
		$response['message']="you must include 'campaign_id' in your request";
		die(json_encode($response));
	}
	
	$data = array(
		'campaign_id' => $campaign_id,
		'result' => "1",
		'update_date'=>date('Y-m-d H:i:s'),
	);

	$result = $obj->addEdit_mst_campaign($data,$campaign_id);
	if($result){
		$response["success"] = true;
		$response["message"] = "Result Release Successfully.";
		die(json_encode($response));
	}else{
		$response["success"] = false;
		$response["message"] = "Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));
	}
?>