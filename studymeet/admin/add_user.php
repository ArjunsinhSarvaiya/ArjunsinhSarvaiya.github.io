<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
    $obj = new StudyMeet(); 

    $stream_data=$obj->get_stream();
    $medium_data=$obj->get_medium();
    $states=$obj->getStates();
  
    $data['status']="1";
    if (!empty($type)) {
        $data['type']=$type;    
    }
    $sc_clg_data=$obj->getmst_school_collage($data);
    if(isset($_GET["id"])){
        if(!empty($_GET["id"])){
            $user_id = base64_decode($_GET["id"]);
        }
    }
    if(isset($_GET["type"])){
        if(!empty($_GET["type"])){
            $user_type = $_GET["type"];
        }
    }
    if(!empty($user_id) && !empty($user_type)){
        if ($user_type=="1") {
            $filter = array("student_id"=>$user_id);
            $user_data = $obj->getmst_student($filter);
        }
        if ($user_type=="2") {
            $filter = array("teacher_id"=>$user_id);
            $user_data = $obj->getmst_mst_teacher($filter);
            if ($user_data) {
                $user_data->class = "";
                $user_data->medium = "";
                $user_data->stream = "";
            }
        }
    }
    if(isset($_POST['add_edit_user'])){
        $name = isset($_POST['name'])?$_POST['name']:"";
        $mobile = isset($_POST['mobile'])?$_POST['mobile']:"";
        $gmail = isset($_POST['gmail'])?$_POST['gmail']:"";
        $school_name   = isset($_POST['school_name'])?$_POST['school_name']:"";
        $type = isset($_POST['type'])?$_POST['type']:"";
        $class = isset($_POST['class'])?$_POST['class']:"";
        $medium   = isset($_POST['medium'])?$_POST['medium']:"";
        $stream   = isset($_POST['stream'])?$_POST['stream']:"";
        $city   = isset($_POST['city'])?$_POST['city']:"";
        $state   = isset($_POST['state'])?$_POST['state']:"";

        if(empty($name)){
            $error[] = "Please Enter name.";
        }
        if(empty($mobile)){
            $error[] = "Please Enter mobile.";
        } 
        if(empty($gmail)){
            $error[] = "Please Enter gmail";
        } 
        if(empty($school_name)){
            $error[] = "Please Select school_name";
        } 
        if(empty($type)){
            $error[] = "Please Enter type";
        }
        if ($type=="1") {
            if(empty($class)){
                $error[] = "Please Enter class";
            }
            if(empty($stream)){
                $error[] = "Please Enter stream";
            }
            if(empty($medium)){
                $error[] = "Please Enter medium";
            }
        }
        if(empty($city)){
            $error[] = "Please Enter city";
        }
        if(empty($state)){
            $error[] = "Please Enter state";
        }
        $filename="";
        if(!empty($_FILES['image']) && $_FILES['image']['error']==0){
            if(!file_exists(PROFILE_IMG_PATH)){
                mkdir(PROFILE_IMG_PATH);
            }
            $extension = array();
            $extension[]="jpg";
            $extension[]="jpeg";
            $extension[]="png";
            $extension[]="PNG";

            $org_name = $_FILES['image']['name'];
            $ext = pathinfo($org_name, PATHINFO_EXTENSION);
            $filename = time().'.'.$ext;

            if(!in_array($ext, $extension)){
                $error[] = "You Can Upload Only Image File.";
            }else{
                move_uploaded_file($_FILES["image"]["tmp_name"], PROFILE_IMG_PATH.$filename);
            }
        }
        if (empty($error) && $type=="1") {
            $data = array(
                    'name' => $name,
                    'mobile'=> $mobile,
                    'gmail' => $gmail,
                    'school_name' => $school_name,
                    'class' => $class,
                    'medium' => $medium,
                    'stream' => $stream,
                    'city' => $city,
                    'state' => $state,
                    'entry_Date'=>date('Y-m-d H:i:s'),
                );
            if (!empty($filename)) {
                $data['image']=$filename;
            }
            $student_data2 = $obj->addEdit_mst_student($data,$user_id);
            if ($student_data2) {
                $success[]="Student Edited Successfully."; 
                echo '<script type="text/javascript">$(document).ready(function(){ window.setTimeout(function(){window.location.href = "'.ADMIN_URL.'User_list.php";}, 1000); })</script>';
            }else{
                $error[] = "Something Went Wrong.Please Try Again Later.";
            }
        }else if (empty($error) && $type=="2") {
            $data2 = array(
                    'name' => $name,
                    'mobile'=> $mobile,
                    'gmail' => $gmail,
                    'school_name' => $school_name,
                    'city' => $city,
                    'state' => $state,
                    'status'=>"1",
                    'entry_Date'=>date('Y-m-d H:i:s'),
                  );
            if (!empty($filename)) {
                $data['image']=$filename;
            }
            $teacher_data2 = $obj->addEdit_mst_teacher($data2,$user_id);
            if ($teacher_data2) {
                $success[]="Teacher Edited Successfully."; 
                echo '<script type="text/javascript">$(document).ready(function(){ window.setTimeout(function(){window.location.href = "'.ADMIN_URL.'User_list.php";}, 1000); })</script>';
            }else{
                $error[] = "Something Went Wrong.Please Try Again Later.";
            }
        }
    }
?>
<div class="">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Edit User </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="<?php echo ADMIN_URL.'User_list.php';?>"><i class="fa fa-arrow-left"></i> Back</a>
                        </li>
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
                                    <label class="control-label"for="">User Image<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="file" class="form-control" id="image" name="image" value="<?php if(isset($_POST['image'])){ echo $_POST['image']; } ?>" placeholder="Select Image">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <img src="<?php if(!empty($user_data->image)){ echo PROFILE_IMG_URL.$user_data->image;} ?>" width="80px" style="border-style: solid;border-width: 1px;border-color: #b5aeae;border-radius: 4px;">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label"for="project_name">Name<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];}else if(!empty($user_data)) { echo $user_data->name; }?>" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label"for="">Number<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="Number" class="form-control" id="mobile" name="mobile" value="<?php if(isset($_POST['mobile'])){ echo $_POST['mobile'];} else if(!empty($user_data)) { echo $user_data->mobile; } ?>" placeholder="Enter Number">
                                    </div>
                                </div>                  
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label"for="">Email Id<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="email" class="form-control" id="gmail" name="gmail" value="<?php if(isset($_POST['gmail'])){ echo $_POST['gmail'];} else if(!empty($user_data)) { echo $user_data->gmail; }?>" placeholder="Enter Email Id">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label" 
                                      for="type">User*<span>:</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <select class="form-control type" name="type" id="type">
                                            <option value="0">Select User Type</option>
                                            <option value="1" <?php if(isset($_POST["type"]) && $_POST["type"]=="1"){echo "selected";}else if($user_type=="1"){echo "selected";}?>>Student</option>
                                            <option value="2" <?php if(isset($_POST["type"]) && $_POST["type"]=="2"){echo "selected";}else if($user_type=="2"){echo "selected";}?> >Teacher</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12 class">
                                    <label class="control-label">Select Class <span>:</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <select class="form-control class" name="class" id="class" maxlength="22">
                                            <option value="0">Select Class</option>
                                            <option value="4Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="4Th"){ echo "selected";}elseif (!empty($user_data) && $user_data->class=="4Th") { echo "selected"; }?> >4Th</option>
                                            <option value="5Th" <?php if(isset($_POST["class"]) && $_POST["school_name"]=="5Th"){ echo "selected";}elseif (!empty($user_data) && $user_data->class=="5Th") { echo "selected"; }?> >5Th</option>
                                            <option value="6Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="6Th"){ echo "selected";}elseif (!empty($user_data) && $user_data->class=="6Th") { echo "selected"; }?> >6Th</option>
                                            <option value="7Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="7Th"){ echo "selected";}elseif (!empty($user_data) && $user_data->class=="7Th") { echo "selected"; }?> >7Th</option>
                                            <option value="8Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="8Th"){ echo "selected";}elseif (!empty($user_data) && $user_data->class=="8Th") { echo "selected"; }?> >8Th</option>
                                            <option value="9Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="9Th"){ echo "selected";}elseif (!empty($user_data) && $user_data->class=="9Th") { echo "selected"; }?> >9Th</option>
                                            <option value="10Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="10Th"){ echo "selected";}elseif (!empty($user_data) && $user_data->class=="10Th") { echo "selected"; }?> >10Th</option>
                                            <option value="11Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="11Th"){ echo "selected";}elseif (!empty($user_data) && $user_data->class=="11Th") { echo "selected"; }?> >11Th</option>
                                            <option value="12Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="12Th"){ echo "selected";}elseif (!empty($user_data) && $user_data->class=="12Th") { echo "selected"; }?> >12Th</option>
                                            <option value="Collage" <?php if(isset($_POST["class"]) && $_POST["class"]=="Collage"){ echo "selected";}elseif (!empty($user_data) && $user_data->class=="Collage") { echo "selected"; }?> >Collage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12 stream">
                                    <label class="control-label" for="stream">Stream*<span>:</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <select class="form-control " name="stream" id="stream">
                                            <option  value="0">Select Stream</option>
                                            <?php if(!empty($stream_data)){ ?>
                                                <?php foreach ($stream_data as $streams) { ?>
                                                    <option value="<?php echo $streams; ?>"  <?php if(isset($_POST['stream']) && $_POST['stream']==$streams){echo "selected=selected"; }else if(!empty($user_data) && $user_data->stream==$streams){echo "selected=selected";} ?>> <?php echo $streams; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label" for="school_name">School / college*<span>:</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <select class="form-control" name="school_name" id="school_name">
                                            <option  value="0">Select :</option>
                                            <?php if(!empty($sc_clg_data)){ ?>
                                                <?php foreach ($sc_clg_data as $scname) { ?>
                                                    <option value="<?php echo $scname->school_collage_id; ?>" <?php if(isset($_POST['school_name']) && $_POST['school_name']==$scname->school_collage_id){echo "selected=selected"; } else if (!empty($user_data) && $user_data->school_name==$scname->school_collage_id){ echo "selected=selected"; } ?>> <?php echo $scname->school_collage_name; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>         
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12 medium">
                                    <label class="control-label" for="medium">Medium*<span>:</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <select class="form-control" name="medium" id="medium">
                                            <option  value="0">Select Medium</option>
                                            <?php if(!empty($medium_data)){ ?>
                                                <?php foreach ($medium_data as $mediums) { ?>
                                                    <option value="<?php echo $mediums; ?>" <?php if(isset($_POST['medium']) && $_POST['medium']==$mediums){echo "selected=selected"; }else if(!empty($user_data) && $user_data->medium==$mediums){echo "selected=selected";} ?>> <?php echo $mediums; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label">City<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="text" class="form-control" id="city" name="city" value="<?php if(isset($_POST['city'])){ echo $_POST['city'];}else if(!empty($user_data)) { echo $user_data->city; }?>" placeholder="Enter City">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label">State*<span>:</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <select class="form-control" name="state" id="state">
                                            <option  value="0">Select state</option>
                                            <?php if(!empty($states)){ ?>
                                                <?php foreach ($states as $state) { ?>
                                                    <option value="<?php echo $state; ?>" <?php if(isset($_POST['state']) && $_POST['state']==$state){echo "selected=selected"; }else if(!empty($user_data) && $user_data->state==$state){echo "selected=selected";} ?>> <?php echo $state; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-xs-12 col-sm-12 text-center">
                                    <button type="submit" name="add_edit_user" class="btn btn-primary"> <?php if(empty($user_id)){ ?> Add <?php }else{ ?> Update <?php } ?> User </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#type").select2();
        $("#class").select2();
        $("#school_name").select2();
        $("#stream").select2();
        $("#medium").select2();
        $("#state").select2();

        var user_type = "<?php echo $user_type; ?>";

        type_select(user_type);

        $(".type").change(function(){
            var type = $(this).find(':selected').val();
            type_select(type);
        });
        $(".class").change(function(){
            class_select();
        });
    });
    function type_select(type){
        if (type=="1") {
            $(".medium").removeClass("hidden");
            $(".class").removeClass("hidden");
            class_select();
        }else if (type=="2") {
            $(".medium").addClass("hidden");
            $(".class").addClass("hidden");
            $(".stream").addClass("hidden");
        }
    }
    function class_select(){
        var class_name = $(".class").find(':selected').val();
        if (class_name=="11Th") {
            $(".stream").removeClass("hidden");
        }else if (class_name=="12Th") {
            $(".stream").removeClass("hidden");
        }else{
            $(".stream").addClass("hidden");
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