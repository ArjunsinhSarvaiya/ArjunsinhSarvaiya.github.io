<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
    $obj = new StudyMeet(); 

    $question_id="";
    if (isset($_GET['id'])) {
        $question_id=base64_decode($_GET['id']);

        $question_data=$obj->getmst_mst_question(array('question_id' => $question_id));
        if (!$question_data) {
            $question_id="";            
        }
    }

    if(isset($_POST['btnaddplan'])){
        //echo "<pre>";print_r($_POST);die();
        $question_text = isset($_POST['question_text'])?$_POST['question_text']:"";
        $post_type = isset($_POST['post_type'])?$_POST['post_type']:"";
        $option_type = isset($_POST['option_type'])?$_POST['option_type']:"";
        $right_answer = isset($_POST['right_answer'])?$_POST['right_answer']:"";
        $right_answer_select = isset($_POST['right_answer_select'])?$_POST['right_answer_select']:"";
        $timer = isset($_POST['timer'])?$_POST['timer']:"";
        $status = isset($_POST['status'])?$_POST['status']:"";
        $option_a = isset($_POST['option_a'])?$_POST['option_a']:"";
        $option_b = isset($_POST['option_b'])?$_POST['option_b']:"";
        $option_c = isset($_POST['option_c'])?$_POST['option_c']:"";
        $option_d = isset($_POST['option_d'])?$_POST['option_d']:"";

        if(empty($question_text)){
            $error[] = "Please Enter Question";
        }
        if ($option_type=="1") {
            if(empty($right_answer_select)){
                $error[] = "Please Select Right Answer.";
            }
            $option_empty=0;
            if(empty($option_a)){
                $option_empty++;
            }
            if(empty($option_b)){
                $option_empty++;
            }
            if(empty($option_c)){
                $option_empty++;
            }
            if(empty($option_d)){
                $option_empty++;
            }
            if($option_empty>2){
                $error[] = "Please Add At Least 2 Option.";
            }
        }
        if(empty($error)){
            if(!empty($_FILES['question_Image']) && $_FILES['question_Image']['error']==0){
                if(!file_exists(QUESTION_FILE_IMG_PATH)){
                    mkdir(QUESTION_FILE_IMG_PATH);
                }
                $extension  =  array('jpg','jpeg','png');
                $org_name = $_FILES['question_Image']['name'];
                $ext = pathinfo($org_name, PATHINFO_EXTENSION);
                $filename = time().'.'.$ext;

                if(!in_array($ext, $extension)){
                    $error[] = "You Can Upload Only Image File.";
                }else{
                    if (!move_uploaded_file($_FILES['question_Image']['tmp_name'],QUESTION_FILE_IMG_PATH.$filename)) {
                        $filename = '';
                        $error[] = "Question Image Uploade Failed";
                    }
                }
            }
        }
        if (empty($error)) {
            $data = array(
                'user_id' => "1",
                'user_type' => "1",
                'question_text' => $question_text,
                'status'=>$status,
                'post_type'=>$post_type,
            );
            if ($post_type=="2") {
                $data['option_type']=$option_type;
                $data['timer']=$timer;

                if ($option_type=="1") {
                    $data['right_answer']=$right_answer_select;
                    $data['option_a']=$option_a;
                    $data['option_b']=$option_b;
                    $data['option_c']=$option_c;
                    $data['option_d']=$option_d;
                }else if ($option_type=="2") {
                    $data['right_answer']=$right_answer;
                }
            }
            if ($filename) {
                $data['question_Image']=$filename;
            }
            if ($question_id) {
                $data['update_date']=date('Y-m-d H:i:s');
            }else{
                $data['entry_date']=date('Y-m-d H:i:s');
            }
            $project_result = $obj->addEdit_mst_question($data,$question_id);
            if ($project_result) {
                $success[] = "Coupon generated Successfully.";
                echo '<script type="text/javascript">$(document).ready(function(){ window.setTimeout(function(){window.location.href = "'.ADMIN_URL.'Que_list_by_admin.php";}, 100); })</script>';
            }else{
                $error[] = "Something Went Wrong, Please Try Again Later.";
            }
        }
    }
?>
<div class="">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add/Edit Plan</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="<?php echo ADMIN_URL.'Que_list_by_admin.php';?>"><i class="fa fa-arrow-left"></i> Back</a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="add-plan" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                        <?php if(!empty($error)) { ?>
                            <div class="alert alert-danger fade in error-msg">
                                <ul> <?php foreach ($error as $e) { echo '<li>'.$e.'</li>'; } ?> </ul>
                            </div>
                        <?php } if (!empty($success)) { ?>
                            <div class="alert alert-success fade in success-msg">
                                <ul> <?php foreach ($success as $s) { echo '<li>'.$s.'</li>'; } ?> </ul>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label">Question Image*<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="file" class="form-control" id="question_Image" 
                                         name="question_Image" value="<?php if(isset($_POST['question_Image'])){ 
                                            echo $_POST['question_Image']; }else if(!empty($empInfo)) { echo $empInfo->question_Image; } ?>" placeholder="Enter Profile">
                                    </div>
                                    <?php if(!empty($question_data) && !empty($question_data->question_Image)){ ?>
                                        <div class="col-md-4 col-xs-12 col-sm-12">
                                            <label class="control-label" for="course-image">&nbsp;</label>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalThumbnail">View Question Image</button>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-8 col-xs-12 col-sm-12">
                                    <label class="control-label"for="">Question/Post*<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="text" class="form-control" name="question_text" value="<?php if(isset($_POST['question_text'])){echo $_POST['question_text'];}else if(!empty($question_data)){echo $question_data->question_text;} ?>" placeholder="Enter Question" style="min-height: 120px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label"for="">Select Type*<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <label><input type="radio" class="post_type" name="post_type" value="2" <?php if(isset($_POST['post_type']) && $_POST['post_type']==2){echo "checked";}else if(!empty($question_data) && $question_data->post_type==2){echo "checked";}else if(!isset($_POST['post_type']) && empty($question_data)){ echo "checked";} ?>> Question</label>
                                        <label><input type="radio" class="post_type" name="post_type" value="1" <?php if(isset($_POST['post_type']) && $_POST['post_type']==1){echo "checked";}else if(!empty($question_data) && $question_data->post_type==1){echo "checked";}?>> Post</label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12 option_type_div">
                                    <label class="control-label"for="">Select Option Type*<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <label><input type="radio" class="option_type" name="option_type" value="2" <?php if(isset($_POST['option_type']) && $_POST['option_type']==2){echo "checked";}else if(!empty($question_data) && $question_data->option_type==2){echo "checked";}else if(!isset($_POST['option_type']) && empty($question_data)){ echo "checked";} ?>> Without Option</label>
                                        <label><input type="radio" class="option_type" name="option_type" value="1" <?php if(isset($_POST['option_type']) && $_POST['option_type']==1){echo "checked";}else if(!empty($question_data) && $question_data->option_type==1){echo "checked";} ?>> With Option</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="col-md-4 col-xs-12 col-sm-12 right_answer_div">
                                    <label class="control-label"for="">Right Answer<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="text" class="form-control" name="right_answer" value="<?php if(isset($_POST['right_answer'])){echo $_POST['right_answer'];}else if(!empty($question_data)){echo $question_data->right_answer;}?>" placeholder="Enter Right Answer" style="min-height: 80px;">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12 right_answer_select_div hidden">
                                    <label class="control-label"for="">Select Right Answer*<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <select class="form-control" name="right_answer_select">
                                            <option value="0">Select Right Answer</option>
                                            <option value="A" <?php if(isset($_POST['right_answer_select']) && $_POST['right_answer_select']=="A"){echo "selected";}else if(!empty($question_data) && $question_data->right_answer=="A"){echo "selected";} ?>>A</option>
                                            <option value="B" <?php if(isset($_POST['right_answer_select']) && $_POST['right_answer_select']=="B"){echo "selected";}else if(!empty($question_data) && $question_data->right_answer=="B"){echo "selected";} ?>>B</option>
                                            <option value="C" <?php if(isset($_POST['right_answer_select']) && $_POST['right_answer_select']=="C"){echo "selected";}else if(!empty($question_data) && $question_data->right_answer=="C"){echo "selected";} ?>>C</option>
                                            <option value="D" <?php if(isset($_POST['right_answer_select']) && $_POST['right_answer_select']=="D"){echo "selected";}else if(!empty($question_data) && $question_data->right_answer=="D"){echo "selected";} ?>>D</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12 timer_div">
                                    <label class="control-label"for="">Select Timer (In Second)<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <select class="form-control" name="timer">
                                            <option value="0">Select Timer</option>
                                            <option value="5" <?php if(isset($_POST['timer']) && $_POST['timer']=="5"){echo "selected";}else if(!empty($question_data) && $question_data->timer=="5"){echo "selected";} ?>>5</option>
                                            <option value="10" <?php if(isset($_POST['timer']) && $_POST['timer']=="10"){echo "selected";}else if(!empty($question_data) && $question_data->timer=="10"){echo "selected";} ?>>10</option>
                                            <option value="15" <?php if(isset($_POST['timer']) && $_POST['timer']=="15"){echo "selected";}else if(!empty($question_data) && $question_data->timer=="15"){echo "selected";} ?>>15</option>
                                            <option value="20" <?php if(isset($_POST['timer']) && $_POST['timer']=="20"){echo "selected";}else if(!empty($question_data) && $question_data->timer=="20"){echo "selected";} ?>>20</option>
                                            <option value="25" <?php if(isset($_POST['timer']) && $_POST['timer']=="25"){echo "selected";}else if(!empty($question_data) && $question_data->timer=="25"){echo "selected";} ?>>25</option>
                                            <option value="30" <?php if(isset($_POST['timer']) && $_POST['timer']=="30"){echo "selected";}else if(!empty($question_data) && $question_data->timer=="30"){echo "selected";} ?>>30</option>
                                            <option value="35" <?php if(isset($_POST['timer']) && $_POST['timer']=="35"){echo "selected";}else if(!empty($question_data) && $question_data->timer=="35"){echo "selected";} ?>>35</option>
                                            <option value="40" <?php if(isset($_POST['timer']) && $_POST['timer']=="40"){echo "selected";}else if(!empty($question_data) && $question_data->timer=="40"){echo "selected";} ?>>40</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label"for="">Select Status*<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <select class="form-control" name="status">
                                            <option value="1" <?php if(isset($_POST['status']) && $_POST['status']=="1"){echo "selected";}else if(!empty($question_data) && $question_data->status=="1"){echo "selected";} ?>>Active</option>
                                            <option value="2" <?php if(isset($_POST['status']) && $_POST['status']=="2"){echo "selected";}else if(!empty($question_data) && $question_data->status=="2"){echo "selected";} ?>>InActive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12 option_div hidden">
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label"for="">Option A<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="text" class="form-control" name="option_a" value="<?php if(isset($_POST['option_a'])){echo $_POST['option_a'];}else if(!empty($question_data)){echo $question_data->option_a;} ?>" placeholder="Enter Option A">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label"for="">Option B<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="text" class="form-control" name="option_b" value="<?php if(isset($_POST['option_b'])){echo $_POST['option_b'];}else if(!empty($question_data)){echo $question_data->option_b;} ?>" placeholder="Enter Option B">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label"for="">Option C<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="text" class="form-control" name="option_c" value="<?php if(isset($_POST['option_c'])){echo $_POST['option_c'];}else if(!empty($question_data)){echo $question_data->option_c;} ?>" placeholder="Enter Option C">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label"for="">Option D<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="text" class="form-control" name="option_d" value="<?php if(isset($_POST['option_d'])){echo $_POST['option_d'];}else if(!empty($question_data)){echo $question_data->option_d;} ?>" placeholder="Enter Option D">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group col-md-12 col-xs-12 col-sm-12 text-center">
                                    <button type="submit" name="btnaddplan" class="btn btn-primary">Create Coupon</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalThumbnail" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Question Image</h4>
            </div>
            <div class="modal-body text-center">
                <div class="alert alert-danger fade in error-msg hidden"></div>
                <div class="alert alert-success fade in success-msg hidden"></div>
                <?php if(!empty($question_data)){ ?>
                  <img src="<?php echo QUESTION_FILE_IMG_URL.$question_data->question_Image;?>" width="300px" height="300px">
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var post_type_post="<?php echo isset($_POST['post_type'])?$_POST['post_type']:""; ?>";
        var post_type_server="<?php echo isset($question_data->post_type)?$question_data->post_type:""; ?>";

        var post_type="";
        if (post_type_post!="" && post_type_post!="0") {
            post_type=post_type_post;
        }
        if (post_type_server!="" && post_type_server!="0") {
            post_type=post_type_server;
        }
        if (post_type!="" && post_type!="0") {
            post_type_setup(post_type);
        }
        
        $(".option_type").click(function(){
            var option_type=$(this).val();
            option_setup(option_type);
        });
        $(".post_type").click(function(){
            var post_type=$(this).val();
            post_type_setup(post_type);
        });
    });
    function post_type_setup(post_type){
        if (post_type=="1") {
            $(".right_answer_div").addClass("hidden");
            $(".right_answer_select_div").addClass("hidden");
            $(".option_div").addClass("hidden");
            $(".timer_div").addClass("hidden");
            $(".option_type_div").addClass("hidden");
        }else{
            $(".timer_div").removeClass("hidden");
            $(".option_type_div").removeClass("hidden");
            var option_type=$(".option_type:checked").val();
            option_setup(option_type);
        }
    }
    function option_setup(option_type){
        if (option_type=="1") {
            $(".right_answer_div").addClass("hidden");
            $(".right_answer_select_div").removeClass("hidden");
            $(".option_div").removeClass("hidden");
        }else{
            $(".right_answer_select_div").addClass("hidden");
            $(".right_answer_div").removeClass("hidden");
            $(".option_div").addClass("hidden");
        }
    }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=46) {
            return false;
        }
        return true;
    }
</script>
<?php include_once('footer.php'); ?>