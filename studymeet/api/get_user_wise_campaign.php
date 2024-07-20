<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$limit_start = isset($_REQUEST['limit_start'])?$_REQUEST['limit_start']:"";

	if (empty($user_id)) {
		$response['success']=false;
		$response['message']="you must include 'user_id' in your request";
		die(json_encode($response));
	}
	if (empty($user_type)) {
		$response['success']=false;
		$response['message']="you must include 'user_type' in your request";
		die(json_encode($response));
	}

	$data = array();
	$data['user_id']=$user_id;
	$data['user_type']=$user_type;
	$result=$obj->getmst_mst_campaign($data,"",$limit_start,"20");
	if($result){
		$finel_array=array();
		foreach ($result as $key => $value) {
			if ($value->status=="1") {
				$expiry = strtotime($value->to_date);
				if (!empty($value->to_time)){
					$expiry = $expiry+strtotime($value->to_time);
				}
				$current = strtotime(date("d-m-Y H:i:s"));
				
				if ($expiry<=$current) {
					$data = array();
					$data['status']="2";

					$campaign_update=$obj->addEdit_mst_campaign($data,$value->campaign_id);
					if ($campaign_update) {
						$value->status="2";
					}
				}
			}
			$count_result=$obj->get_count_campaings($value->campaign_id);
			$value->total_participents=$count_result->total_campaign;
			$finel_array[]=$value;
		}
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
