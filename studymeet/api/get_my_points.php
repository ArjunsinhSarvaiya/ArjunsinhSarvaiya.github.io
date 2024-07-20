<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";

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
	$today_date=date("Y-m-d");
	$yesterday_date=date("Y-m-d",strtotime("-1 days"));
	$week_before_date="";

	if(date('D')!='Mon')
	{
	  $week_before_date = date('Y-m-d',strtotime('last Monday'));
	}else{
	    $week_before_date = date('Y-m-d');
	}

	$month_before_date=date("Y-m")."-1";

	$today_campaign_point=$obj->get_user_wise_total_point($user_id,$user_type,$today_date,$today_date);
	$today_question=$obj->get_user_wise_answer_question($user_id,$user_type,"1",$today_date,$today_date);

	$yesterday_campaign_point=$obj->get_user_wise_total_point($user_id,$user_type,$yesterday_date,$yesterday_date);
	$yesterday_question=$obj->get_user_wise_answer_question($user_id,$user_type,"1",$yesterday_date,$yesterday_date);

	$week_campaign_point=$obj->get_user_wise_total_point($user_id,$user_type,$week_before_date,$today_date);
	$week_question=$obj->get_user_wise_answer_question($user_id,$user_type,"1",$week_before_date,$today_date);

	$month_campaign_point=$obj->get_user_wise_total_point($user_id,$user_type,$month_before_date,$today_date);
	$month_question=$obj->get_user_wise_answer_question($user_id,$user_type,"1",$month_before_date,$today_date);

	$response['success']=true;
	$response['message']="Data Found.";
	$response["today"] = $today_campaign_point->total_point+$today_question->total_point;
	$response["yesterday"] = $yesterday_campaign_point->total_point+$yesterday_question->total_point;
	$response["this_week"] = $week_campaign_point->total_point+$week_question->total_point;
	$response["this_month"] = $month_campaign_point->total_point+$month_question->total_point;
	die(json_encode($response));
?>
