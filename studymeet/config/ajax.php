<?php 
	require_once('../config/config.php');
	require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');

	$obj = new StudyMeet();
	
    if(isset($_POST["block_plan_id"]) && isset($_POST['status'])){

        $plan_id = $_POST['block_plan_id'];
        $status = $_POST['status'];

        if(empty($plan_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("plan_id"=>$plan_id);
        $plans = $obj->getmst_mst_plans($filter);

        if(empty($plans)){
            $response["success"] = false;
            $response["message"] = "plan no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_plans($data,$plan_id);
       	
        if(!empty($result)){
            $response["success"] = true;
		        $response["message"] ="Plan are Block Successfully.";
		        die(json_encode($response));
        }else{
            $response["success"] = fasle;
			      $response["message"] ="Something Went Wrong";
			      die(json_encode($response));
        }
    }

    if(isset($_POST["unblock_plan_id"]) && isset($_POST['status'])){

        $plan_id = $_POST['unblock_plan_id'];
        $status = $_POST['status'];

        if(empty($plan_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("plan_id"=>$plan_id);
        $plans = $obj->getmst_mst_plans($filter);

        if(empty($plans)){
            $response["success"] = false;
            $response["message"] = "plan no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_plans($data,$plan_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Plan are UnBlock Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }

    if(isset($_POST["block_student_id"]) && isset($_POST['status'])){
        $student_id = $_POST['block_student_id'];
        $status = $_POST['status'];
        if(empty($student_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("student_id"=>$student_id);
        $plans = $obj->getmst_student($filter);

        if(empty($plans)){
            $response["success"] = false;
            $response["message"] = "student no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_student($data,$student_id);

        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="student are Block Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }
  
    if(isset($_POST["block_teacher_id"]) && isset($_POST['status'])){

        $teacher_id = $_POST['block_teacher_id'];
        $status = $_POST['status'];        

        if(empty($teacher_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("teacher_id"=>$teacher_id);
        $Teacher = $obj->getmst_mst_teacher($filter);

        if(empty($Teacher)){
            $response["success"] = false;
            $response["message"] = "Teacher no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_teacher($data,$teacher_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Teacher are Block Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }
    
    if(isset($_POST["Block_Question_id"]) && isset($_POST['status'])){

        $question_id = $_POST['Block_Question_id'];
        $status = $_POST['status'];        

        if(empty($question_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("question_id"=>$question_id);
        $Que = $obj->getmst_mst_question($filter);

        if(empty($Que)){
            $response["success"] = false;
            $response["message"] = "Teacher no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_question($data,$question_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Teacher are Block Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }

    if(isset($_POST["Unblock_Question_id"]) && isset($_POST['status'])){

        $question_id = $_POST['Unblock_Question_id'];
        $status = $_POST['status'];        

        if(empty($question_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("question_id"=>$question_id);
        $Que = $obj->getmst_mst_question($filter);

        if(empty($Que)){
            $response["success"] = false;
            $response["message"] = "Teacher no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_question($data,$question_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Teacher are UnBlock Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }
  
    if(isset($_POST["block_campaign_id"]) && isset($_POST['status'])){

        $campaign_id = $_POST['block_campaign_id'];
        $status = $_POST['status'];        

        if(empty($campaign_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("campaign_id"=>$campaign_id);
        $Que = $obj->getmst_mst_campaign($filter);

        if(empty($Que)){
            $response["success"] = false;
            $response["message"] = "Campaign no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_campaign($data,$campaign_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="campaign are Block Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }

    if(isset($_POST["unblock_campaign_id"]) && isset($_POST['status'])){

        $campaign_id = $_POST['unblock_campaign_id'];
        $status = $_POST['status'];  

        if(empty($campaign_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("campaign_id"=>$campaign_id);
        $Que = $obj->getmst_mst_campaign($filter);
        
        if(empty($Que)){
            $response["success"] = false;
            $response["message"] = "Campaign no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_campaign($data,$campaign_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="campaign are UnBlock Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }
    if(isset($_POST["release_campaign_id"])){
        $campaign_id = $_POST['release_campaign_id'];  

        if(empty($campaign_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("campaign_id"=>$campaign_id);
        $Que = $obj->getmst_mst_campaign($filter);
        
        if(empty($Que)){
            $response["success"] = false;
            $response["message"] = "Campaign no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'result' => 1,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_campaign($data,$campaign_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Result Released Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }

    if(isset($_POST["sc_clg_approve_id"]) && isset($_POST['status'])){

        $school_collage_id = $_POST['sc_clg_approve_id'];
        $status = $_POST['status'];        

        if(empty($school_collage_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("school_collage_id"=>$school_collage_id);
        $Que = $obj->getmst_mst_school_collage($filter);

        if(empty($Que)){
            $response["success"] = false;
            $response["message"] = "School/College no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_school_collage($data,$school_collage_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }

    if(isset($_POST["sc_clg_reject_id"]) && isset($_POST['status'])){

        $school_collage_id = $_POST['sc_clg_reject_id'];
        $status = $_POST['status'];        

        if(empty($school_collage_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("school_collage_id"=>$school_collage_id);
        $Que = $obj->getmst_mst_school_collage($filter);

        if(empty($Que)){
            $response["success"] = false;
            $response["message"] = "School/College no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_school_collage($data,$school_collage_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }

    if(isset($_POST["remove_coupon_id"])){
        $coupon_id = isset($_POST["remove_coupon_id"])?base64_decode($_POST["remove_coupon_id"]):"";
        if(empty($coupon_id)){
            $response["success"] = false;
            $response["message"] = "You Can Not Remove Coupon.";
            die(json_encode($response));
        }

        $filter = array("coupon_id"=>$coupon_id);
        $coupon = $obj->getmst_coupon($filter);
    
        if(empty($coupon)){
            $response["success"] = false;
            $response["message"] = "Coupon Detail No Longer Exist.";
            die(json_encode($response));
        }

        $remove = $obj->remove_mst_coupon_code($filter);
        if($remove){
            $response["success"] = true;
            $response["message"] = "Coupon Removed Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = true;
            $response["message"] = "Something Went Wrong.Please Try Again Later.";
            die(json_encode($response));
        }
    }

    if(isset($_POST["block_q_ans_id"]) && isset($_POST['status'])){

        $q_answer_id = $_POST['block_q_ans_id'];
        $status = $_POST['status'];        

        if(empty($q_answer_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("q_answer_id"=>$q_answer_id);
        $Que = $obj->getmst_mst_question_answer($filter);

        if(empty($Que)){
            $response["success"] = false;
            $response["message"] = "Question/Answer no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_question_answer($data,$q_answer_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }
  
    if(isset($_POST["Unblock_q_ans_id"]) && isset($_POST['status'])){

        $q_answer_id = $_POST['Unblock_q_ans_id'];
        $status = $_POST['status'];        

        if(empty($q_answer_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("q_answer_id"=>$q_answer_id);
        $Que = $obj->getmst_mst_question_answer($filter);

        if(empty($Que)){
            $response["success"] = false;
            $response["message"] = "Question/Answer no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_question_answer($data,$q_answer_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }
    if(isset($_POST["q_answer_status_change"]) && isset($_POST['status'])){

        $q_answer_id = $_POST['q_answer_status_change'];
        $status = $_POST['status'];        

        if(empty($q_answer_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("q_answer_id"=>$q_answer_id);
        $Que = $obj->getmst_mst_question_answer($filter);
        if(empty($Que)){
            $response["success"] = false;
            $response["message"] = "Question/Answer no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'answer_type' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_mst_question_answer($data,$q_answer_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }
    if(isset($_POST["c_answer_status_change"]) && isset($_POST['status'])){

        $trn_join_id = $_POST['c_answer_status_change'];
        $status = $_POST['status'];        

        if(empty($trn_join_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("trn_join_id"=>$trn_join_id);
        $trn_data = $obj->getmst_trn_join_campaign($filter);
        if(empty($trn_data)){
            $response["success"] = false;
            $response["message"] = "Question/Answer no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'answer_status' => $status,
            'update_date' => date('Y-m-d H:i:s')
        );

        $result = $obj->addEdit_trn_join_campaign($data,$trn_join_id);
        
        if(!empty($result)){

            $point=0;
            $join_result=$obj->getmst_mst_join_campaign(array('join_id' => $trn_data->join_id, ));

            if ($join_result) {
                $point=$join_result->point;
            }
            if ($status=="1") {
                if ($trn_data->answer_status!="1") {
                    $point=$point+5;
                }
            }else if ($status=="2") {

                if (!empty($point) && $trn_data->answer_status=="1") {
                    $point=$point-5;
                }
            }
            if ($point<0) {
                $point=0;
            }
            $data = array();
            $data['update_date']=date("Y-m-d H:i:s");
            $data['point']=$point;
            
            $result=$obj->addEdit_mst_join_campaign($data,$trn_data->join_id);
            
            $response["success"] = true;
            $response["message"] ="Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong";
            die(json_encode($response));
        }
    }

    if(isset($_POST["status_comment_id"]) && isset($_POST['status'])){

        $comment_id = $_POST['status_comment_id'];
        $status = $_POST['status'];        

        if(empty($comment_id)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        if(empty($status)){
            $response["success"] = false;
            $response["message"] = "Something went wrong.Please try again later.";
            die(json_encode($response));
        }

        $filter = array("q_comment_id"=>$comment_id);
        $comment = $obj->getmst_mst_question_comment($filter);

        if(empty($comment)){
            $response["success"] = false;
            $response["message"] = "Comment no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
        );

        $result = $obj->addEdit_mst_question_comment($data,$comment_id);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Comment Status Change Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong, Please Try Again Later.";
            die(json_encode($response));
        }
    }
    if(isset($_POST["remove_admin_post_id"])){

        $post_id = isset($_POST['remove_admin_post_id'])?base64_decode($_POST['remove_admin_post_id']):"";

        if(empty($post_id)){
            $response["success"] = false;
            $response["message"] = "Please Enter Post Id.";
            die(json_encode($response));
        }

        $filter = array("post_id"=>$post_id);
        $Post = $obj->getmst_admin_post($filter);

        if(empty($Post)){
            $response["success"] = false;
            $response["message"] = "Post no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'post_id' => $post_id,
        );

        $result = $obj->remove_admin_post($data);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Post Removed Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong, Please Try Again Later.";
            die(json_encode($response));
        }
    }
    if(isset($_POST["remove_language_id"])){

        $language_id = isset($_POST['remove_language_id'])?base64_decode($_POST['remove_language_id']):"";

        if(empty($language_id)){
            $response["success"] = false;
            $response["message"] = "Please Enter Language Id.";
            die(json_encode($response));
        }

        $filter = array("language_id"=>$language_id);
        $language = $obj->get_manage_language($filter);

        if(empty($language)){
            $response["success"] = false;
            $response["message"] = "Language no longer exist.";
            die(json_encode($response));
        }

        $data = array(
            'language_id' => $language_id,
        );

        $result = $obj->remove_manage_language($data);
        
        if(!empty($result)){
            $response["success"] = true;
            $response["message"] ="Language Removed Successfully.";
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong, Please Try Again Later.";
            die(json_encode($response));
        }
    }
    if(isset($_POST["change_status_language_id"])){
        $language_id = isset($_POST['change_status_language_id'])?base64_decode($_POST['change_status_language_id']):"";
        $status = isset($_POST['status'])?$_POST['status']:"";

        if(empty($language_id)){
            $response["success"] = false;
            $response["message"] = "Please Enter Language Id.";
            die(json_encode($response));
        }

        $data = array(
            'status' => $status,
        );

        $result = $obj->add_Edit_manage_language($data,$language_id);
        
        if(!empty($result)){
            $response["success"] = true;
            if ($status=="1") {
                $response["message"] ="Language Activated Successfully.";
            }else if ($status=="2") {
                $response["message"] ="Language InActive Successfully.";
            }
            die(json_encode($response));
        }else{
            $response["success"] = fasle;
            $response["message"] ="Something Went Wrong, Please Try Again Later.";
            die(json_encode($response));
        }
    }
?>