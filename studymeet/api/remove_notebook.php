<?php
	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
 			   
	$obj = new StudyMeet();
	$note_id = isset($_REQUEST['note_id'])?$_REQUEST['note_id']:"";
	
	if(empty($note_id)){
		$response["success"] = false;
		$response["message"] = "You must include a 'note_id' var in your request.";
		die(json_encode($response));
	}
			
    $result = $obj->removeNotebook($note_id);
    
	if($result){
		$response["success"] = true;
		$response["message"] = "Notebook Removed Successfully.";
		die(json_encode($response));
	}else{
		$response["success"] = false;
		$response["message"] = "Notebook Not Removed.";
		die(json_encode($response));
	}

?>