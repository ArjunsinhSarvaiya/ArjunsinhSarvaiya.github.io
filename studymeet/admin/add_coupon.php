<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
    $obj = new StudyMeet(); 

    $success = $error = array();
    if(isset($_POST['btnaddplan'])){
        $number = isset($_POST['number'])?$_POST['number']:"";
        $amount = isset($_POST['amount'])?$_POST['amount']:"";

        if(empty($amount)){
            $error[] = "Please Enter amount";
        }
        if(empty($number)){
            $error[] = "Please Enter Number";
        }

        $total_coupon=0;
        while ($total_coupon<$number) {
            $chars = "0123456789ABCDEFGHIJKLMNPQRSTUVWZYX";
            $code = substr(str_shuffle($chars), 0, 6 );

            $codecheck = array();
            $codecheck['coupon_code']=$code;
            $check_code_num=$obj->getmst_coupon($codecheck);
            if (!$check_code_num) {
                $data = array(
                    'amount' => $amount,
                    'status'=>"1",
                    'coupon_code'=>$code,
                    'entry_date'=>date('Y-m-d H:i:s'),
                );
                $project_result = $obj->add_Edit_coupon_code($data);
                if ($project_result) {
                    $total_coupon++;
                }
            }
        }
        $success[] = "Coupon generated Successfully.";
        echo '<script type="text/javascript">$(document).ready(function(){ window.setTimeout(function(){window.location.href = "'.ADMIN_URL.'manage_coupan.php";}, 100); })</script>';
    }
?>
<div class="">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
              <h2>
               Add/Edit Plan
              </h2>
              <ul class="nav navbar-right panel_toolbox">
                <li>
                  <a href="<?php echo ADMIN_URL.'manage_coupan.php';?>">
                      <i class="fa fa-arrow-left"></i> Back</a>
                </li>
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
                          <label class="control-label"for="">Number<span>:</span></label>
                          <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                <input type="Number" onkeypress="return isNumber(event)" class="form-control" id="number" 
                         name="number" value=""
                         placeholder="Enter Number">
                          </div>
                        </div> 

                        <div class="col-md-4 col-xs-12 col-sm-12">
                          <label class="control-label"for="">Coupon Amount<span>:</span></label>
                          <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                <input type="text" class="form-control" id="customer_line2" 
                         name="amount" onkeypress="return isNumber(event)" value="<?php if(isset($_POST['amount'])){ echo $_POST['amount']; } ?>"
                         placeholder="Enter Coupon Amount">
                          </div>
                        </div>                       
                        
                          
                        <div class="form-group col-md-12 col-xs-12 col-sm-12 text-center">
                        <button type="submit" name="btnaddplan" class="btn btn-primary">
                          Create Coupon
                        </button>
                      </div>
                    </div>
                    </div>                    
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