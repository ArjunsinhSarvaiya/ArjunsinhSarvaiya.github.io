<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
    $obj = new StudyMeet();

    if(isset($_GET["id"])){
        if(!empty($_GET["id"])){
            $post_id = base64_decode($_GET["id"]);
        }
    }
    if(!empty($post_id)){
        $filter = array("post_id"=>$post_id);
        $post_data = $obj->getmst_admin_post($filter);
        if(empty($post_data)){
            $post_id = '';
        }
    }

    if(isset($_POST['btnaddplan'])){
        //echo "<pre>";print_r($_POST);die();
        $text = isset($_POST['text'])?$_POST['text']:"";
        $link = isset($_POST['link'])?$_POST['link']:"";
        $status   = isset($_POST['status'])?$_POST['status']:"";
        $city   = isset($_POST['city'])?$_POST['city']:"";
        $state   = isset($_POST['state'])?$_POST['state']:"";

        if(empty($text)){
            $error[] = "Please Enter text.";
        }
        if(empty($link)){
            $error[] = "Please Enter link.";
        }
       
        $filename="";
        if(empty($error) && !empty($_FILES['image']) && $_FILES['image']['error']==0){
            if(!file_exists(QUESTION_FILE_IMG_PATH)){
                mkdir(QUESTION_FILE_IMG_PATH);
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
                move_uploaded_file($_FILES["image"]["tmp_name"], QUESTION_FILE_IMG_PATH.$filename);
            }
        }
        if(empty($error)){          
            $data = array(
                'status' => $status,
              );
            if (!empty($text)) {
                $data['text']=$text;
            }
            if (!empty($link)) {
                $data['link']=$link;
            }
            if (!empty($filename)) {
                $data['image']=$filename;
            }
            $data['city']=$city;
            if (!empty($state)) {
                $data['state']=$state;
            }
            if (empty($post_id)) {
                $data['entry_date']=date("Y-m-d H:i:s");   
            }else{
                $data['update_date']=date("Y-m-d H:i:s");
            }
            $result = $obj->add_Edit_admin_post($data,$post_id);
            if ($result) {
                if ($post_id) {
                    $success[]="Plan Edited Successfully.";
                }else{
                    $success[]="Plan Added Successfully.";
                }
                echo '<script type="text/javascript">$(document).ready(function(){window.setTimeout(function(){window.location.href = "'.ADMIN_URL.'manage_post.php";}, 1000);})</script>';
            }else{
                $error[] = "Something Went Wrong.Please Try Again Later.";
            }
        }
    }

    $states=$obj->getStates();
?>
<div class="">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2> <?php if(empty($post_id )){ ?> Add <?php }else{ ?> Update <?php } ?> Post </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li> <a href="<?php echo ADMIN_URL.'manage_post.php';?>"> <i class="fa fa-arrow-left"></i> Back</a> </li>
                    </ul>
                    <div class="clearfix"></div>
                    </div>
                        <div class="x_content">
                            <br/>
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
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <label class="control-label"for="">Select Image<span>:</span></label>
                                            <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                                <input type="file" class="form-control" id="image" name="image" value="<?php if(isset($_POST['image'])){ echo $_POST['image']; } ?>" placeholder="Enter Image">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <label class="control-label"for="plan_name">Post Text<span>:</span></label>
                                            <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                                <input type="text" maxlength="250" class="form-control" id="text" name="text" value="<?php if(isset($_POST['text'])){ echo $_POST['text']; }else if(!empty($post_data)) { echo $post_data->text; } ?>" placeholder="Enter Post Text">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <label class="control-label"for="">Link<span>:</span></label>
                                            <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                                <input type="text" style="margin-bottom: 0px" class="form-control" id="link" name="link" value="<?php if(isset($_POST['link'])){ echo $_POST['link']; }else if(!empty($post_data)) { echo $post_data->link; } ?>" placeholder="Enter Link">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <label class="control-label" for="status">Status*<span>:</span></label>
                                            <select class="form-control" name="status" id="status" maxlength="11">
                                                <option value="1" <?php if(isset($_POST["status"]) && $_POST["status"]==1){ echo "selected"; }else if(!empty($post_data) && $post_data->status==1){ echo "selected"; } ?> >Active</option>

                                                <option value="2" <?php if(isset($_POST["status"]) && $_POST["status"]==2){ echo "selected"; }else if(!empty($post_data) && $post_data->status==2){ echo "selected"; } ?> >InActive</option>     
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <label class="control-label"for="">City<span>:</span></label>
                                            <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                                <input type="text" class="form-control" id="city" name="city" value="<?php if(isset($_POST['city'])){ echo $_POST['city']; }else if(!empty($post_data)) { echo $post_data->city; } ?>" placeholder="Enter Link">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <label class="control-label" for="status">States*<span>:</span></label>
                                            <select class="form-control" name="state" id="state">
                                                <option value="0">Select State</option>
                                                <?php foreach ($states as $key => $state) { ?>
                                                    <option value="<?php echo $state; ?>" <?php if(isset($_POST["state"]) && $_POST["state"]==1){ echo "selected"; }else if(!empty($post_data) && $post_data->state==$state){ echo "selected"; } ?> ><?php echo $state; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 col-xs-12 col-sm-12 text-center">
                                            <?php if (!empty($post_data->image)) { ?>
                                                <a href="<?php echo QUESTION_FILE_IMG_URL.$post_data->image; ?>" target="_blank">
                                                    <img src="<?php echo QUESTION_FILE_IMG_URL.$post_data->image; ?>" width="150px">
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group col-md-12 col-xs-12 col-sm-12 text-center">

                                            <button type="submit" name="btnaddplan" class="btn btn-primary"> <?php if(empty($post_id )){ ?> Add <?php }else{ ?> Update <?php } ?> Post </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
      $('#status').select2();
  });
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