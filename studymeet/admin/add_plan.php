<?php 
   require_once('../config/config.php');
   require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
   require_once("header.php"); 
   $obj = new StudyMeet();

   if(isset($_GET["id"])){
    if(!empty($_GET["id"])){
      $plan_id = base64_decode($_GET["id"]);
    }
  }
  if(!empty($plan_id)){
    $filter = array("plan_id"=>$plan_id);
    $plan = $obj->getmst_mst_plans($filter);
    if(empty($plan)){
      $plan_id = '';
    }
  }

  if(isset($_POST['btnaddplan'])){

    $plan_name = isset($_POST['plan_name'])?$_POST['plan_name']:"";
    $plan_month = isset($_POST['plan_month'])?$_POST['plan_month']:"";
    $plan_amount = isset($_POST['plan_amount'])?$_POST['plan_amount']:"";
    $status   = isset($_POST['status'])?$_POST['status']:"";

    if(empty($plan_name)){
      $error[] = "Please Enter plan_name.";
    }
    if(empty($plan_month)){
      $error[] = "Please Enter plan_month.";
    } 
    if(empty($plan_amount)){
      $error[] = "Please Enter Sale plan_amount";
    } 
       
       $data = array(
                'plan_name' => $plan_name,
                'plan_month'=> $plan_month,
                'plan_amount' => $plan_amount,
                'status' => $status,
              );

       if(empty($plan_id) && !empty($data))
       {          
            $project_result = $obj->addEdit_mst_plans($data);
            if ($project_result) {
                       $success[]="Plan Added Successfully."; 
                       echo '<script type="text/javascript">$(document).ready(function(){
                        window.setTimeout(function(){window.location.href = "'.ADMIN_URL.'manage_plan.php";}, 1000);
                      })</script>';   
            }else{
                $error[] = "Something Went Wrong.Please Try Again Later.";
            }
        }
       else if (!empty($data)) {
            
            $plan2 = $obj->addEdit_mst_plans($data,$plan_id);
            if ($plan2) {
                       $success[]="Plan Edited Successfully."; 
                       echo '<script type="text/javascript">$(document).ready(function(){
                        window.setTimeout(function(){window.location.href = "'.ADMIN_URL.'manage_plan.php";}, 1000);
                      })</script>';   
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
                    <h2> Add/Edit Plan </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li> <a href="<?php echo ADMIN_URL.'manage_plan.php';?>"> <i class="fa fa-arrow-left"></i> Back</a> </li>
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
                                        <div class="col-md-4 col-xs-12 col-sm-12">
                                            <label class="control-label"for="plan_name">Plan Title<span>:</span></label>
                                            <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                                <input type="text" class="form-control" id="customer_line1" name="plan_name" value="<?php if(isset($_POST['plan_name'])){ echo $_POST['plan_name']; }else if(!empty($plan)) { echo $plan->plan_name; } ?>" placeholder="Enter Plan Title">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12 col-sm-12">
                                            <label class="control-label"for="">Month<span>:</span></label>
                                            <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                                <input type="number" maxlength="2" class="form-control" id="customer_line2" onkeypress="return isNumber(event)" name="plan_month" value="<?php if(isset($_POST['plan_month'])){ echo $_POST['plan_month']; }else if(!empty($plan)) { echo $plan->plan_month; } ?>" placeholder="Enter Month">
                                            </div>
                                        </div>                       
                                        <div class="col-md-4 col-xs-12 col-sm-12">
                                            <label class="control-label"for="">Amount<span>:</span></label>
                                            <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                                <input type="text" onkeypress="return isNumber(event)" class="form-control" id="customer_address" name="plan_amount" value="<?php if(isset($_POST['plan_amount'])){ echo $_POST['plan_amount']; }else if(!empty($plan)) { echo $plan->plan_amount; } ?>" placeholder="Enter Amount">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12 col-sm-12">
                                            <label class="control-label" for="status">Status*<span>:</span></label>
                                            <select class="form-control" name="status" id="status" maxlength="11">
                                                <option value="1" <?php if(isset($_POST["status"]) && $_POST["status"]==1){ echo "selected"; }else if(!empty($plan) && $plan->status==1){ echo "selected"; } ?> >Active</option>

                                                <option value="2" <?php if(isset($_POST["status"]) && $_POST["status"]==2){ echo "selected"; }else if(!empty($plan) && $plan->status==2){ echo "selected"; } ?> >Block</option>     
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 col-xs-12 col-sm-12 text-center">
                                            <button type="submit" name="btnaddplan" class="btn btn-primary"> <?php if(empty($plan_id )){ ?> Add <?php }else{ ?> Update <?php } ?> Plan </button>
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