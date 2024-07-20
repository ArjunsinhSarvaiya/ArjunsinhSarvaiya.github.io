<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

    
	$obj = new StudyMeet();
	
	$language_data=$obj->get_manage_language(array('status' => 1, ));
	if($language_data){
		$finel_array=array();
		foreach ($language_data as $key => $value) {
			$finel_array[] = $value->language_name;
		}
		$response['success']=true;
		$response['message']="Data Found.";
		$response["result"] = $finel_array;
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Data Not Found.";
		die(json_encode($response));
	}
?>
