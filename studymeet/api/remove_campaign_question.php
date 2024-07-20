<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$trn_campaign_id = isset($_REQUEST['trn_campaign_id'])?$_REQUEST['trn_campaign_id']:"";

	if (empty($trn_campaign_id)) {
		$response['success']=false;
		$response['message']="you must include 'trn_campaign_id' in your request";
		die(json_encode($response));
	}
	
	$data = array();
	$data['trn_campaign_id']=$trn_campaign_id;

	$result=$obj->remove_trn_campaign($data);
	if($result){
		$response['success']=true;
		$response['message']="Question Deleted Succssfully.";
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Question Deleting Failed.";
		die(json_encode($response));
	}
?>
