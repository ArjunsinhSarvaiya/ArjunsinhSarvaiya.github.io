<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";

	$data = array();
	$data['status']="1";

	$result=$obj->getmst_mst_plans($data);
	if($result){
		$plan_id = "";
		$plan_name = "";
		$plan_amount = "";
		$plan_month = "";
		$status = "";
		$expiry_date = "";
		$entry_date = "";
		if (!empty($user_id) && !empty($user_type)) {
			$data = array();
			$data['user_id']=$user_id;
			$data['user_type']=$user_type;
			$data['status']="1";

			$active_plan=$obj->getmst_mst_transaction($data,"","0","1");
			if($active_plan){
				if ($active_plan[0]->status=="1") {
					$expiry = strtotime($active_plan[0]->expiry_date);
					$current = strtotime(date("d-m-Y H:i:s"));

					if ($expiry<=$current) {
						$data = array();
						$data['status']="2";

						$trans_update=$obj->addEdit_mst_transaction($data,$active_plan[0]->trans_id);
						if ($trans_update) {
							$result[$i]->status="2";
						}
					}else{
            			$plan_id = $active_plan[0]->plan_id;
            			$plan_name = $active_plan[0]->plan_name;
            			$plan_amount = $active_plan[0]->plan_amount;
            			$plan_month = $active_plan[0]->plan_month;
            			$status = $active_plan[0]->status;
            			$expiry_date = date("d-m-Y h:iA",strtotime($active_plan[0]->expiry_date));
            			$entry_date = date("d-m-Y h:iA",strtotime($active_plan[0]->entry_date));
					}
				}
			}	
		}
		$response['success']=true;
		$response['message']="Data Found.";
		$response["plan_id"]=$plan_id;
		$response["plan_name"]=$plan_name;
		$response["plan_amount"]=$plan_amount;
		$response["plan_month"]=$plan_month;
		$response["status"]=$status;
		$response["expiry_date"]=$expiry_date;
		$response["entry_date"]=$entry_date;
		$response["result"] = $result;
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Data Not Available.";
		die(json_encode($response));
	}
?>
