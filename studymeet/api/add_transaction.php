<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$plan_id = isset($_REQUEST['plan_id'])?$_REQUEST['plan_id']:"";
	$plan_name = isset($_REQUEST['plan_name'])?$_REQUEST['plan_name']:"";
	$plan_amount = isset($_REQUEST['plan_amount'])?$_REQUEST['plan_amount']:"";
	$plan_month = isset($_REQUEST['plan_month'])?$_REQUEST['plan_month']:"";
	$discount = isset($_REQUEST['discount'])?$_REQUEST['discount']:"";
	$coupon_id = isset($_REQUEST['coupon_id'])?$_REQUEST['coupon_id']:"";
	$payment_id = isset($_REQUEST['payment_id'])?$_REQUEST['payment_id']:"";
	
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
	if (empty($plan_id)) {
		$response['success']=false;
		$response['message']="you must include 'plan_id' in your request";
		die(json_encode($response));
	}
	if (empty($plan_name)) {
		$response['success']=false;
		$response['message']="you must include 'plan_name' in your request";
		die(json_encode($response));
	}
    if (empty($plan_amount)) {
		$response['success']=false;
		$response['message']="you must include 'plan_amount' in your request";
		die(json_encode($response));
	}
    if (empty($plan_month)) {
		$response['success']=false;
		$response['message']="you must include 'plan_month' in your request";
		die(json_encode($response));
	}
    
	$data = array();
	$data['user_id']=$user_id;
	$data['user_type']=$user_type;
	$data['plan_id']=$plan_id;
	$data['plan_name']=$plan_name;
	$data['plan_amount']=$plan_amount;
	$data['plan_month']=$plan_month;
	$data['status']="1";
	$data['entry_date']=date("Y-m-d H:i:s");
	$data['expiry_date']= date('Y-m-d H:i:s', strtotime('+'.$plan_month.' months'));
	$data['discount']=$discount;

	if (!empty($payment_id)) {
		$data['payment_id']=$payment_id;
	}
	
	$result=$obj->addEdit_mst_transaction($data);
	if($result){
		if (!empty($coupon_id)) {	
			$remove_coupon_result=$obj->remove_mst_coupon_code(array('coupon_id' => $coupon_id, ));
		}
		
		$response['success']=true;
		$response['message']="Notes Added Successfully.";
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));
	}
?>