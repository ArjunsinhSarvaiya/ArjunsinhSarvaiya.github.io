<?php
    require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$name = isset($_REQUEST['name'])?$_REQUEST['name']:"";
	$mobile = isset($_REQUEST['mobile'])?$_REQUEST['mobile']:"";
	$image= isset($_REQUEST['image'])?$_REQUEST['image']:"";
	$old_image=isset($_REQUEST['old_image'])?$_REQUEST['old_image']:"";
	$city = isset($_REQUEST['city'])?$_REQUEST['city']:"";
	$state = isset($_REQUEST['state'])?$_REQUEST['state']:"";
	$gmail = isset($_REQUEST['gmail'])?$_REQUEST['gmail']:"";
    $school_name = isset($_REQUEST['school_name'])?$_REQUEST['school_name']:"";
	$teacher_id= isset($_REQUEST['teacher_id'])?$_REQUEST['teacher_id']:"";
	$school_name_other= isset($_REQUEST['school_name_other'])?$_REQUEST['school_name_other']:"";
	
	$obj = new StudyMeet();
	$return_array = array();

	if(empty($name)){
		$response['success']=false;
		$response['message']="You must include a 'name' var in your request.";
		die(json_encode($response));
	}

	if(empty($mobile) && empty($teacher_id)){
		$response['success']=false;
		$response['message']="You must include a 'mobile' var in your request.";
		die(json_encode($response));
	}else if(empty($teacher_id)){
		$data=array(
			"mobile"=>$mobile,
		);
		$mobile_check=$obj->getmst_mst_teacher($data);
		if ($mobile_check) {
			$response['success']=false;
			$response['message']="This Mobile Number Is Already Registered, Try With Another Mobile Number.";
			die(json_encode($response));			
		}
	}


	if (empty($image) && empty($teacher_id)) {
		$response['success']=false;
		$response['message']="You must include a 'image' var in your request.";
		die(json_encode($response));
	}

    if(empty($city)){
		$response['success']=false;
		$response['message']="You must include a 'city' var in your request.";
		die(json_encode($response));
	}
	if(empty($state)){
		$response['success']=false;
		$response['message']="You must include a 'state' var in your request.";
		die(json_encode($response));
	}

	if(empty($gmail) && empty($teacher_id)){
		$response['success']=false;
		$response['message']="You must include a 'gmail' var in your request.";
		die(json_encode($response));
	}else if(empty($teacher_id)){
		$data=array(
			"gmail"=>$gmail,
		);
		$email_check=$obj->getmst_mst_teacher($data);
		if($email_check) {
			$response['success']=false;
			$response['message']="This Email Id Is Already Registered, Try With Another Email Id.";
			die(json_encode($response));			
		}
	}
	
	if (!file_exists(PROFILE_IMG_PATH)) {
		mkdir(PROFILE_IMG_PATH);
	}
	
	$img_name = time().'.jpg';
	$image_path = PROFILE_IMG_PATH.$img_name;
	
	if ($school_name=="Other") {

		$school_data = array(
				'school_collage_name' => $school_name_other,
				'status' => 2,
				'entry_date' => date("Y-m-d H:i:s"),
				'type' => 1, );

		$school_name=$obj->addEdit_mst_school_collage($school_data);
	}
	$data=array(
		"name"=>$name,
		"city"=>$city,
		"state"=>$state,		
		"school_name"=>$school_name);

    if (!empty($teacher_id)) {
		$data['update_date']=date("Y-m-d H:i:s");
	}else{
		$data['entry_date']=date("Y-m-d H:i:s");
		$data['status']=1;		
		$data['mobile']=$mobile;
		$data['gmail']=$gmail;
	}
	if (!empty($image)) {
		$data['image']=$img_name;
	}
	
	$result=$obj->addEdit_mst_teacher($data,$teacher_id);

	if($result){
	    	    
		if (!empty($image)) {
			file_put_contents($image_path, base64_decode($image));
			if (!empty($old_image)) {
				unlink(PROFILE_IMG_PATH.$old_image);
			}
		}
		
	    $response['success']=true;
		$response['message']="Successfully.";
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));
	}
?>
