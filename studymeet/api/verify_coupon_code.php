<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
	$obj = new StudyMeet();

	$coupon_code = isset($_REQUEST['coupon_code'])?$_REQUEST['coupon_code']:"";
	    
	if (empty($coupon_code)) {
		$response['success']=false;
		$response['message']="you must include 'coupon_code' in your request";
		die(json_encode($response));
	}

	
	$cuopon_check="";
	$data =array("coupon_code"=>$coupon_code);
    $filter=array("status"=>1);	
    
	$check_code=$obj->getmst_coupon($data,$filter);
   	if($check_code){

		$response['success']=true;
		$response['message']="Coupon Code Applied Successfully";
		$response['coupon_id']=$check_code->coupon_id;
		$response['amount']=$check_code->amount;
		die(json_encode($response));
		
	}else{

		$response['success']=false;
		$response['message']="Coupon Expired.";
		die(json_encode($response));
	}
?>
