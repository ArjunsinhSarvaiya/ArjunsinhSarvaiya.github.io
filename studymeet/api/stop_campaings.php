<?php
    require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

  	$campaign_id = isset($_REQUEST['campaign_id'])?$_REQUEST['campaign_id']:"";
	$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";	
		
	if (empty($campaign_id)) {
		$response['success']=false;
		$response['message']="you must include 'campaign_id' in your request";
		die(json_encode($response));
	}
	if (empty($status)) {
		$response['success']=false;
		$response['message']="you must include 'status' in your request";
		die(json_encode($response));
	}
	
	 $data = array(
					'campaign_id' => $campaign_id,
					'status' => $status,
					'update_date'=>date('Y-m-d H:i:s'),
				);

		$result = $obj->addEdit_mst_campaign($data,$campaign_id);

		if($result){
			$response["success"] = true;
			$response["message"] = "Campaign Stop Successfully";
			die(json_encode($response));
		}else{
			$response["success"] = false;
			$response["message"] = "Something Went Wrong,Please Try Again.";
			die(json_encode($response));
		}

?>