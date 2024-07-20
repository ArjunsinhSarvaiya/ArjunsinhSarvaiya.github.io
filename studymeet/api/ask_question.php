<?php
  	require_once('../config/config.php');
    header("Content-Type: application/json; charset=utf-8");
  	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();

	$question_id 	= isset($_REQUEST['question_id'])?$_REQUEST['question_id']:"";
	$user_id 		= isset($_REQUEST['user_id'])?$_REQUEST['user_id']:"";
	$user_type 		= isset($_REQUEST['user_type'])?$_REQUEST['user_type']:"";
	$question_text 	= isset($_REQUEST['question_text'])?$_REQUEST['question_text']:"";
	$question_Image = isset($_REQUEST['question_Image'])?$_REQUEST['question_Image']:"";
	$old_image 		= isset($_REQUEST['old_image'])?$_REQUEST['old_image']:"";
	$question_video = isset($_REQUEST['question_video'])?$_REQUEST['question_video']:"";
	$video_formate  = isset($_REQUEST['video_formate'])?$_REQUEST['video_formate']:"";
	$old_video 		= isset($_REQUEST['old_video'])?$_REQUEST['old_video']:"";
	$option_type 	= isset($_REQUEST['option_type'])?$_REQUEST['option_type']:"";
	$post_type 		= isset($_REQUEST['post_type'])?$_REQUEST['post_type']:"";
	$right_answer 	= isset($_REQUEST['right_answer'])?$_REQUEST['right_answer']:"";
	$timer 			= isset($_REQUEST['timer'])?$_REQUEST['timer']:"";
	$option_a 		= isset($_REQUEST['option_a'])?$_REQUEST['option_a']:"";
	$option_b 		= isset($_REQUEST['option_b'])?$_REQUEST['option_b']:"";
	$option_c 		= isset($_REQUEST['option_c'])?$_REQUEST['option_c']:"";
	$option_d 		= isset($_REQUEST['option_d'])?$_REQUEST['option_d']:"";
	$status 		= isset($_REQUEST['status'])?$_REQUEST['status']:"";
	$file 		= isset($_REQUEST['file'])?$_REQUEST['file']:"";
	$file_formate 		= isset($_REQUEST['file_formate'])?$_REQUEST['file_formate']:"";
	$old_file 		= isset($_REQUEST['old_file'])?$_REQUEST['old_file']:"";

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
	if (empty($post_type)) {
		$response['success']=false;
		$response['message']="you must include 'post_type' in your request";
		die(json_encode($response));
	}else if ($post_type=="2") {
		if (empty($option_type)) {
			$response['success']=false;
			$response['message']="you must include 'option_type' in your request";
			die(json_encode($response));
		}
		// if (empty($timer)) {
		// 	$response['success']=false;
		// 	$response['message']="you must include 'timer' in your request";
		// 	die(json_encode($response));
		// }
		if ($option_type=="1") {
			if (empty($option_a) && empty($option_b) && empty($option_c) && empty($option_d)) {
				$response['success']=false;
				$response['message']="you must include 'Option' in your request";
				die(json_encode($response));
			}
		}
	}
	if (empty($question_id) && empty($question_text) && empty($question_Image) && empty($question_video)) {
		$response['success']=false;
		$response['message']="you must include Text Or Image Or Video in your request";
		die(json_encode($response));
	}

	if (!empty($question_Image)) {
        if (!file_exists(QUESTION_FILE_IMG_PATH)) {
        	mkdir(QUESTION_FILE_IMG_PATH);
        }
	}

	$img_name = "Image_".time().'.jpg';
	$image_path = QUESTION_FILE_IMG_PATH.$img_name;

	$video_name = "Video_".time().'.mp4';
	if (!empty($video_formate)) {
		$video_name = "Video_".time().'.'.$video_formate;
	}
	$video_path = QUESTION_FILE_IMG_PATH.$video_name;

	$file_name = "File_".time().'.'.$file_formate;
	$file_path = QUESTION_FILE_IMG_PATH.$file_name;

	$data = array();
	$data['user_id']=$user_id;
	$data['user_type']=$user_type;
	$data['post_type']=$post_type;
	if (!empty($option_type)) {
		$data['option_type']=$option_type;
	}
	if (!empty($right_answer)) {
		$data['right_answer']=$right_answer;
	}
	if (!empty($timer)) {
		$data['timer']=$timer;
	}
	if (!empty($option_a)) {
		$data['option_a']=$option_a;
	}
	if (!empty($option_b)) {
		$data['option_b']=$option_b;
	}
	if (!empty($option_c)) {
		$data['option_c']=$option_c;
	}
	if (!empty($option_d)) {
		$data['option_d']=$option_d;
	}
	if (!empty($status)) {
		$data['status']=$status;
	}
	
	if (!empty($question_id)) {
		$data['update_date']=date("Y-m-d H:i:s");
	}else{
		$data['entry_date']=date("Y-m-d H:i:s");
	}
	if (!empty($question_text)) {
		$data['question_text']=$question_text;	
	}
	if (!empty($question_Image)) {
		$data['question_Image']=$img_name;	
	}
	if (!empty($file)) {
		$data['pdf_file']=$file_name;
	}
	$result=$obj->addEdit_mst_question($data,$question_id);
	if($result){

		if (!empty($question_Image)) {
			file_put_contents($image_path, base64_decode($question_Image));
			if (!empty($old_image)) {
				unlink(QUESTION_FILE_IMG_PATH.$old_image);
			}
		}

		if (!empty($question_video)) {
			file_put_contents($video_path, base64_decode($question_video));
			if (!empty($old_video)) {
				unlink(QUESTION_FILE_IMG_PATH.$old_video);
			}
		}

		if (!empty($file)) {
			file_put_contents($file_path, base64_decode($file));
			if (!empty($old_file)) {
				unlink(QUESTION_FILE_IMG_PATH.$old_file);
			}
		}
		
		$response['success']=true;
		$response['message']="Question Added Successfully.";
		die(json_encode($response));
	}else{
		$response['success']=false;
		$response['message']="Something Went Wrong, Please Try Again Later.";
		die(json_encode($response));
	}
?>
