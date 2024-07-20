<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
    $obj = new StudyMeet(); 

    $language_id='';

    if(isset($_GET["id"])){
        if(!empty($_GET["id"])){
            $language_id = base64_decode($_GET["id"]);
        }
    }

    if(!empty($language_id)){
        $filter = array("language_id"=>$language_id);
        $language_Info = $obj->get_manage_language($filter);
        if(empty($language_Info)){
            $language_id = '';
        }
    }
    if(isset($_POST['btn_submit'])){
        $language_name = isset($_POST['language_name'])?$_POST['language_name']:"";
        $status = isset($_POST['status'])?$_POST['status']:"";

        if(empty($language_name)){
            $error[] = "Please Enter Language";
        }else{
            $language_filter = array();
            $language_filter['language_name']=$language_name;
            $language_check=$obj->get_manage_language($language_filter,$language_id);
            if ($language_check) {
                $error[] = $language_name." Language Already Available";  
            }
        }

        if (empty($error)) {
            $data = array(
                'language_name' => $language_name,
                'status'=>$status,
            );
            if ($language_id) {
                $data['update_date'] = date('Y-m-d H:i:s');
            }else{
                $data['entry_date'] = date('Y-m-d H:i:s');
            }
            $language_result = $obj->add_Edit_manage_language($data,$language_id);

            if ($language_result) {
                $success[] = "Language Added Successfully.";
                echo '<script type="text/javascript">$(document).ready(function(){ window.setTimeout(function(){window.location.href = "'.ADMIN_URL.'manage_language.php";}, 100); })</script>';
            }
        }
    }
?>
<div class="">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <?php if (!empty($language_id)) { ?>
                           Edit Language
                        <?php }else{ ?>
                            Add Language  
                        <?php } ?>
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="<?php echo ADMIN_URL.'manage_language.php';?>"><i class="fa fa-arrow-left"></i> Back</a></li>
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
                                <div class="col-md-4 col-md-offset-4 col-xs-12 col-sm-12">
                                    <label class="control-label">Language<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <input type="text" class="form-control" name="language_name" value="<?php if(isset($_POST['language_name'])){ echo $_POST['language_name']; }else if(isset($language_Info)){ echo $language_Info->language_name;} ?>" placeholder="Enter Language">
                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-4 col-xs-12 col-sm-12">
                                    <label class="control-label">Status<span>:</span></label>
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <select class="form-control" name="status">
                                            <option value="1" <?php if(isset($_POST['status']) && $_POST['status']=="1"){ echo "selected"; }else if(isset($language_Info) && $language_Info->status=="1"){ echo "selected"; } ?>>Active</option>
                                            <option value="2" <?php if(isset($_POST['status']) && $_POST['status']=="2"){ echo "selected"; }else if(isset($language_Info) && $language_Info->status=="2"){ echo "selected"; } ?>>InActive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-xs-12 col-sm-12 text-center">
                                    <button type="submit" name="btn_submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>