<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$trn_join_id = isset($_REQUEST['trn_join_id'])?$_REQUEST['trn_join_id']:"";
	$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";
	
	if (empty($trn_join_id)) {
		$response['success']=false;
		$response['message']="you must include 'trn_join_id' in your request";
		die(json_encode($response));
	}
	if (empty($status)) {
		$response['success']=false;
		$response['message']="you must include 'status' in your request";
		die(json_encode($response));
	}

	$trn_data=$obj->getmst_trn_join_campaign(array('trn_join_id' => $trn_join_id, ));
	$q_data = array();
	$q_data['answer_status']=$status;
	$q_data['update_date']=date("Y-m-d H:i:s");

	$result=$obj->addEdit_trn_join_campaign($q_data,$trn_join_id);
	if($result){

		$point=0;
		$join_result=$obj->getmst_mst_join_campaign(array('join_id' => $trn_data->join_id, ));

		if ($join_result) {
			$point=$join_result->point;
		}
		if ($status=="1") {
			if ($trn_data->answer_status!="1") {
				$point=$point+5;
			}
		}else if ($status=="2") {

			if (!empty($point) && $trn_data->answer_status=="1") {
				$point=$point-5;
			}
		}
		if ($point<0) {
			$point=0;
		}
		$data = array();
		$data['update_date']=date("Y-m-d H:i:s");
		$data['point']=$point;
		
		$result=$obj->addEdit_mst_join_campaign($data,$trn_data->join_id);
		$response['success']=true;
		$response['message']="Status Change Successfully.";
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));
	}
?>
