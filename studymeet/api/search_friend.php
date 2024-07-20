<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type = isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$search_text = isset($_REQUEST['search_text'])?$_REQUEST['search_text']:"";
	$limit_start = isset($_REQUEST['limit_start'])?$_REQUEST['limit_start']:"";

	if (empty($search_text)) {
		$response['success']=false;
		$response['message']="you must include 'search_text' in your request";
		die(json_encode($response));
	}

	$result=$obj->search_friend(array(),$search_text,$limit_start,"20");
	
	if($result){
		if (!empty($user_id) && !empty($user_type)) {
			$i=0;
			foreach ($result as $key => $value) {
				$friend_check=$obj->getmst_mst_friends(array(),"",$value->user_id,$value->user_type,$user_id,$user_type);
				if ($friend_check) {
					if ($friend_check[0]->status=="1") {
						if ($friend_check[0]->my_id==$user_id && $friend_check[0]->my_type==$user_type) {
							$result[$i]->friend="4";
						}else{
							$result[$i]->friend=$friend_check[0]->status;
						}
					}else {
						$result[$i]->friend=$friend_check[0]->status;
					}
				}
				$i++;
			}
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
