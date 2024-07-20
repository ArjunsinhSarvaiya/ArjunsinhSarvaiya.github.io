<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$my_id = isset($_REQUEST['my_id'])?$_REQUEST['my_id']:"";
	$my_type = isset($_REQUEST['my_type'])?$_REQUEST['my_type']:"";
	$other_user_id = isset($_REQUEST['other_user_id'])?$_REQUEST['other_user_id']:"";
	$other_user_type = isset($_REQUEST['other_user_type'])?$_REQUEST['other_user_type']:"";
	$status = isset($_REQUEST['status'])?$_REQUEST['status']:"";
	
	//status = 1 Add Request
	//status = 2 Add Friend 
	//status = 3 Delete

	if ($my_id==$other_user_id && $my_type==$other_user_type) {
		
		$response['success']=false;
		$response['message']="You Can Not Send Friend Request To Your Self.";
		die(json_encode($response));
	}
	if (empty($my_id)) {
		$response['success']=false;
		$response['message']="you must include 'my_id' in your request";
		die(json_encode($response));
	}
	if (empty($my_type)) {
		$response['success']=false;
		$response['message']="you must include 'my_type' in your request";
		die(json_encode($response));
	}
	if (empty($other_user_id)) {
		$response['success']=false;
		$response['message']="you must include 'other_user_id' in your request";
		die(json_encode($response));
	}
	if (empty($other_user_type)) {
		$response['success']=false;
		$response['message']="you must include 'other_user_type' in your request";
		die(json_encode($response));
	}
	if (empty($status)) {
		$response['success']=false;
		$response['message']="you must include 'status' in your request";
		die(json_encode($response));
	}

	if ($status=="1" || $status=="2") {

		$friend_result=$obj->getmst_mst_friends(array(),"",$my_id,$my_type,$other_user_id,$other_user_type);
		
		if ($friend_result) {
			$data = array();
			$data['status']=$status;
			$data['entry_date']=date("Y-m-d H:i:s");

			$result=$obj->addEdit_mst_friends($data,$friend_result[0]->friend_id);
			if($result){
				$response['success']=true;
				if ($status=="1") {
					$response['message']="Request Added Succssfully.";
				}else if ($status=="2") {
					$response['message']="Request Accepted Succssfully.";
				}
				die(json_encode($response));
			}else{
				$response['success']=false;
				$response['message']="Request Failed.";
				die(json_encode($response));
			}
		}else{
			$data = array();
			$data['status']=$status;
			$data['my_id'] = $my_id;
			$data['my_type'] = $my_type;
			$data['other_user_id'] = $other_user_id;
			$data['other_user_type'] = $other_user_type;
			$data['entry_date']=date("Y-m-d H:i:s");

			$result=$obj->addEdit_mst_friends($data);
			if($result){
				$response['success']=true;
				if ($status=="1") {
					$response['message']="Request Added Succssfully.";
				}else if ($status=="2") {
					$response['message']="Request Accepted Succssfully.";
				}
				die(json_encode($response));
			}else{
				$response['success']=false;
				$response['message']="Request Failed.";
				die(json_encode($response));
			}
		}
	}else if ($status=="3") {

		$data = array();

		$friend_result=$obj->getmst_mst_friends(array(),"",$my_id,$my_type,$other_user_id,$other_user_type);
		
		if ($friend_result) {
			$friend_delete=$obj->remove_mst_friends(array('friend_id' => $friend_result[0]->friend_id, ));
			if($friend_delete){
				$response['success']=true;
				$response['message']="Data Remove Successfully.";
				die(json_encode($response));
			}else{
				$response['success']=false;
				$response['message']="Something Went Wrong, Try Again Later.";
				die(json_encode($response));
			}
		}else{
			$response['success']=trur;
			$response['message']="Data Remove Successfully.";
			die(json_encode($response));
		}
	}
?>
