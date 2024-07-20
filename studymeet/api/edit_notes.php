<?php
    require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

  	$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$note_id = isset($_REQUEST['note_id'])?$_REQUEST['note_id']:"";
	$notes = isset($_REQUEST['notes'])?$_REQUEST['notes']:"";
	
		
	if (empty($user_id)) {
		$response['success']=false;
		$response['message']="you must include 'user_id' in your request";
		die(json_encode($response));
	}
	if (empty($note_id)) {
		$response['success']=false;
		$response['message']="you must include 'note_id' in your request";
		die(json_encode($response));
	}
	if (empty($notes)) {
		$response['success']=false;
		$response['message']="you must include 'notes' in your request";
		die(json_encode($response));
	}
	
		$data = array(
					'user_id' => $user_id,
					'note_id' => $note_id,
					'notes' => $notes,
					'entry_date'=>date('Y-m-d H:i:s'),
				);

		$result = $obj->addEdit_mst_notes($data,$note_id);

		if($result){
			$response["success"] = true;
			$response["message"] = "Notes Updated Successfully";
			die(json_encode($response));
		}else{
			$response["success"] = false;
			$response["message"] = "Enter all data correctly";
			die(json_encode($response));
		}

?>