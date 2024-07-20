<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
    $obj = new StudyMeet(); 
    
    $school_collage_id="";
    if (isset($_GET['id'])) {
        $school_collage_id=base64_decode($_GET['id']);
        if ($school_collage_id) {
            $data = array(
                'school_collage_id' => $school_collage_id,
            );
            $school_collage_data = $obj->getmst_mst_school_collage($data);
            if (empty($school_collage_data)) {
                $school_collage_data="";
            }
        }
    }
    
    if(isset($_POST['btnaddplan'])){
        $school_collage_name = isset($_POST['school_collage_name'])?$_POST['school_collage_name']:"";
        $type = isset($_POST['type'])?$_POST['type']:"";
        $status = isset($_POST['status'])?$_POST['status']:"";

        if(empty($school_collage_name)){
            $error[] = "Please Enter School/Collage Name";
        }else{
            $data = array(
                'school_collage_name' => $school_collage_name,
                'type' => $type,
            );
            $project_result = $obj->getmst_mst_school_collage($data,$school_collage_id);
            if ($project_result) {
                if ($type==1) {
                    $error[] = "This School Already Added.";
                }else if ($type==2) {
                    $error[] = "This Collage Already Added.";
                }
            }
        }
        if (empty($error)) {
            $data = array(
                'school_collage_name' => $school_collage_name,
                'type'=>$type,
                'status'=>$status,
            );
            if ($school_collage_id) {
                $date['update_date']=date('Y-m-d H:i:s');
            }else{
                $date['entry_date']=date('Y-m-d H:i:s');
            }
            $result = $obj->addEdit_mst_school_collage($data,$school_collage_id);
            if ($result) {
                if ($school_collage_id) {
                    if ($type==1) {
                        $success[] = "School Updated Successfully.";
                    }else if ($type==2) {
                        $success[] = "Collage Updated Successfully.";
                    }
                }else{
                    if ($type==1) {
                        $success[] = "School Added Successfully.";
                    }else if ($type==2) {
                        $success[] = "Collage Added Successfully.";
                    }
                }
                echo '<script type="text/javascript">$(document).ready(function(){ window.setTimeout(function(){window.location.href = "'.ADMIN_URL.'Approve_sc_clg.php";}, 100); })</script>';
            }else{
                $error[] = "Something Went Wrong, Please Try Again.";
            }
        }
    }
?>
<div class="">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php if ($school_collage_id) { echo "Edit School/Collage"; }else { echo "Add School/Collage"; } ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="<?php echo ADMIN_URL.'Approve_sc_clg.php';?>"><i class="fa fa-arrow-left"></i> Back</a></li>
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
                        <div class="col-md-12 col-xs-12 col-sm-12"> 
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <label class="control-label"for="">School/Collage Name*<span>:</span></label>
                                <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                    <input type="text" class="form-control" name="school_collage_name" value="<?php if(isset($_POST['school_collage_name'])){ echo $_POST['school_collage_name'];}else if(isset($school_collage_data) && !empty($school_collage_data)){ echo $school_collage_data->school_collage_name;} ?>" placeholder="Enter School/Collage Name">
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <label class="control-label"for="">Select Type<span>:</span></label>
                                <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                    <select class="form-control" name="type">
                                        <option value="1" <?php if(isset($_POST['type']) && $_POST['type']==1){ echo "selected";}else if(isset($school_collage_data) && $school_collage_data->type==1){ echo "selected";} ?>>School</option>
                                        <option value="2" <?php if(isset($_POST['type']) && $_POST['type']==2){ echo "selected";}else if(isset($school_collage_data) && $school_collage_data->type==2){ echo "selected";} ?>>Collage</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <label class="control-label"for="">Select Status<span>:</span></label>
                                <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                    <select class="form-control" name="status">
                                        <option value="1" <?php if(isset($_POST['status']) && $_POST['status']==1){ echo "selected";}else if(isset($school_collage_data) && $school_collage_data->status==1){ echo "selected";} ?>>Active</option>
                                        <option value="2" <?php if(isset($_POST['status']) && $_POST['status']==2){ echo "selected";}else if(isset($school_collage_data) && $school_collage_data->status==2){ echo "selected";} ?>>InActive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-xs-12 col-sm-12 text-center">
                                <button type="submit" name="btnaddplan" class="btn btn-primary">Submit</button>
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