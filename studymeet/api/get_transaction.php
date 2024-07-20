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

	$result=$obj->getmst_mst_transaction($data,"",$limit_start,"20");
	if($result){
		$i=0;
		foreach ($result as $key => $value) {
			$result[$i]->expiry_date = 	date("d-m-Y h:iA",strtotime($value->expiry_date));
			$result[$i]->entry_date  =	date("d-m-Y h:iA",strtotime($value->entry_date));
			if ($value->status=="1") {
				$expiry = strtotime($value->expiry_date);
				$current = strtotime(date("d-m-Y H:i:s"));
				
				if ($expiry<=$current) {
					$data = array();
					$data['status']="2";

					$trans_update=$obj->addEdit_mst_transaction($data,$value->trans_id);
					if ($trans_update) {
						$result[$i]->status="2";
					}
				}
			}
			$i++;
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
