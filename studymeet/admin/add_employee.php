<?php 
   require_once('../config/config.php');
   /*error_reporting(E_ALL);*/
   require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
   require_once('header.php');
  $obj=new pms();
  $error = $success = array();
  $emp_id='';
  $extension  =  array('jpg','jpeg','png');
  

  if(isset($_GET["id"])){
    if(!empty($_GET["id"])){
      $emp_id = base64_decode($_GET["id"]);
    }
  }

  if(!empty($emp_id)){
    $filter = array("emp_id"=>$emp_id);
    $empInfo = $obj->get_emp($filter);
    if(empty($empInfo)){
      $emp_id = '';
    }
  }
   
   $filter = array("menu_id"=>9,'role_id'=>$_SESSION['role_id']);
    $ManageEmployee  = $obj->getRights($filter,$is_single=true);
    if($_SESSION['role_id']!=1 && (empty($ManageEmployee) || $ManageEmployee->is_view!=1)){
        header("Location: ".ADMIN_URL."403.php");
    }

    if($_SESSION['role_id']!=1 && empty($emp_id) && (!empty($ManageEmployee) && $ManageEmployee->is_added!=1)){
        header("Location: ".ADMIN_URL."403.php");
    }

    if($_SESSION['role_id']!=1 && !empty($emp_id) && (!empty($ManageEmployee) && $ManageEmployee->is_edited!=1)){
        header("Location: ".ADMIN_URL."403.php");
    }
   
   if(isset($_POST["btnaddemp"])){
    
       $emp_name    = isset($_POST["emp_name"])?$_POST["emp_name"]:"";
       $mobile_no = isset($_POST["mobile_no"])?$_POST["mobile_no"]:"";
       $email_id = isset($_POST["email_id"])?$_POST["email_id"]:"";
       $password   = isset($_POST["password"])?$_POST["password"]:"";
       $role_id   = isset($_POST["role_id"])?$_POST["role_id"]:"";
       $status   = isset($_POST["status"])?$_POST["status"]:"";
      
      
      if(empty($emp_name)){
      $error[] = "Please Enter Employee Name.";
      }
      if(empty($mobile_no)){
            $error[] = "Please Enter Mobile No.";
      }else if(!is_numeric($mobile_no)){
            $error[] = "Mobile Number Must Be Numeric.";
      }else if(strlen($mobile_no)!=10){
            $error[] = "Mobile Number Must Be 10 Digits Long.";
      }else{
          $filter = array("mobile_no"=>$mobile_no);
          $MobilenoExist = $obj->get_emp($filter,$emp_id);
          if(!empty($MobilenoExist)){
            $error[] =  "Mobile No Already Exist.";
            }
      }
       if(empty($email_id)){
           $error[] = "Please Enter Email id.";
       }else{
           $filter = array("email_id"=>$email_id);
           $EmailExist = $obj->get_emp($filter,$emp_id);
          if(!empty($EmailExist)){
                $error[] =  "Email Already Exist.";
           }
        }
       

       if(empty($_FILES['profile_image']['name']) && empty($emp_id)){
          $error[] =  "Please Select Employee Profile.";
        }

        if(empty($error)){
          if(!empty($_FILES['profile_image']) && $_FILES['profile_image']['error']==0){
              if(!file_exists(EMPLOYEE_IMAGE_PATH)){
                mkdir(EMPLOYEE_IMAGE_PATH);
              }
              $org_name = $_FILES['profile_image']['name'];
              $ext = pathinfo($org_name, PATHINFO_EXTENSION);
              $filename = time().'.'.$ext;

              if(!in_array($ext, $extension)){
                  $error[] = "You Can Upload Only Image File.";
              }else{
                if (!move_uploaded_file($_FILES['profile_image']['tmp_name'],EMPLOYEE_IMAGE_PATH.$filename)) {
                  $filename = '';
                  $error[] = "EMployee Profile Not Uploaded Successfully";
                }
              }
          }
        }
      if (empty($error)) {
      $data = array(
         'emp_name' => $emp_name,
         'mobile_no' => $mobile_no,
         'email_id' => $email_id,
         'status' => $status,
         'password' => md5($password),
         'role_id' => $role_id,
      );
      if(!empty($filename)){
                $data["profile_image"] = $filename;
      }
      
       if(empty($emp_id)){
           $data["entry_date"] = date('Y-m-d H:i:s');
       }else{
         $data["updated_date"] = date('Y-m-d H:i:s');
       }
          
        $employees = $obj->addEdit_emp($data,$emp_id);
        /*echo "<pre>";print_r($employees);die();*/
        if(!empty($employees)){
            if(empty($emp_id) && empty($error)){
                $success[] =  "Employee Details Added Successfully.";
            }else if(!empty($emp_id) &&empty($error)){
                $success[] =  "Employee Details Updated Successfully.";
            }
          echo '<script type="text/javascript">$(document).ready(function(){
                    window.setTimeout(function(){window.location.href = "'.ADMIN_URL.'manage_employee.php";}, 1000);
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
               <h2>
                  <?php if(empty($emp_id)){ ?>
                  Add
                  <?php }else{ ?>
                  Update
                  <?php } ?>
                  Employee
               </h2>
               <ul class="nav navbar-right panel_toolbox">
                  <li>
                     <a href="<?php echo ADMIN_URL.'manage_employee.php';?>">
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
                           <label class="control-label"for="project_name">Employee Name<span>:</span></label>
                           <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                              <input type="text" class="form-control" id="emp_name" 
                                 name="emp_name" value="<?php if(isset($_POST['emp_name'])){ 
                                    echo $_POST['emp_name']; }else if(!empty($empInfo)) { echo $empInfo->emp_name; } ?>"
                                 placeholder="Enter Employee Name">
                           </div>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label"for="mobile_no">Mobile No<span>:</span></label>
                           <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                              <input type="text" class="form-control" id="mobile_no" 
                                 name="mobile_no" onkeypress="return isNumber(event)" maxlength="10" value="<?php if(isset($_POST['mobile_no'])){ 
                                    echo $_POST['mobile_no']; }else if(!empty($empInfo)) { echo $empInfo->mobile_no; } ?>"
                                 placeholder="Enter Mobile No">
                           </div>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label"for="email_id">Email<span>:</span></label>
                           <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                              <input type="text" class="form-control" id="email_id" 
                                 name="email_id" value="<?php if(isset($_POST['email_id'])){ 
                                    echo $_POST['email_id']; }else if(!empty($empInfo)) { echo $empInfo->email_id; } ?>"
                                 placeholder="Enter Email Id">
                           </div>
                        </div>
                        
                     </div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                      <?php if(empty($emp_id)){ ?>
                      <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label"for="password">Password<span>:</span></label>
                           <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                              <input type="password" class="form-control" id="password" 
                                 name="password" value="<?php if(isset($_POST['password'])){ 
                                    echo $_POST['password']; }else if(!empty($empInfo)) { echo $empInfo->password; } ?>"
                                 placeholder="Enter Your Password">
                           </div>
                        </div>
                      <?php }?>
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label"for="profile_image">Profile Image<span>:</span></label>
                           <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                              <input type="file" class="form-control" id="profile_image" 
                                 name="profile_image" value="<?php if(isset($_POST['profile_image'])){ 
                                    echo $_POST['profile_image']; }else if(!empty($empInfo)) { echo $empInfo->profile_image; } ?>" placeholder="Enter Profile">
                           </div>
                           <?php if(!empty($empInfo) && !empty($empInfo->profile_image)){ ?>
                                  <div class="col-md-4 col-xs-12 col-sm-12">
                                    <label class="control-label" for="course-image">&nbsp;</label>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalThumbnail">View Employee's Image</button>
                                  </div>
                              <?php } ?>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label" 
                              for="status">Status*<span>:</span></label>
                           <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                              <select class="form-control" name="status" id="status" maxlength="11">
                                 <option value="1" <?php if(isset($_POST["status"]) && $_POST["status"]==1){ echo "selected"; }else if(!empty($empInfo) && $empInfo->status==1){ echo "selected"; } ?> >Active</option>
                                 <option value="2" <?php if(isset($_POST["status"]) && $_POST["status"]==2){ echo "selected"; }else if(!empty($empInfo) && $empInfo->status==2){ echo "selected"; } ?> >InActive</option>
                              </select>
                           </div>
                        </div>  
                        
                     </div>
                  </div>
                  <div class="col-md-12 col-xs-12 col-sm-12">
                      <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label"for="role_id">Role Name<span>:</span></label>
                          <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <select class="form-control" name="role_id" id="role_id">
                                 <option  value="0">Select Role</option>
                                 <option value="1" <?php if(isset($_POST["role_id"]) && $_POST["role_id"]==1){ echo "selected"; }else if(!empty($empInfo) && $empInfo->role_id==1){ echo "selected"; } ?>>Admin</option>
                                 <option value="2" <?php if(isset($_POST["role_id"]) && $_POST["role_id"]==2){ echo "selected"; }else if(!empty($empInfo) && $empInfo->role_id==2){ echo "selected"; } ?>>Employee</option>
                                 <option value="3" <?php if(isset($_POST["role_id"]) && $_POST["role_id"]==3){ echo "selected"; }else if(!empty($empInfo) && $empInfo->role_id==3){ echo "selected"; } ?>>Sale Person</option>
                                 
                              </select>
                                    </div>
                        </div>  
                     </div>
                  </div>
                  <div class="form-group col-md-12 col-xs-12 col-sm-12 text-center">
                     <button type="submit" name="btnaddemp" class="btn btn-primary">
                     <?php if(empty($emp_id)){ ?>
                     Add
                     <?php }else{ ?>
                     Update
                     <?php } ?>
                     Employee
                     </button>
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
                <h4>Employee Profile Image</h4>
            </div>
            <div class="modal-body text-center">
                <div class="alert alert-danger fade in error-msg hidden"></div>
                <div class="alert alert-success fade in success-msg hidden"></div>
                <?php if(!empty($empInfo)){ ?>
                  <img src="<?php echo EMPLOYEE_IMAGE_URL.$empInfo->profile_image;?>" width="300px" height="300px">
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
     var count=1;
     var total_count=1;
     $('#status').select2();
     $('#role_id').select2();
     $('#item_id').select2();
     $('#myDatepicker1').datetimepicker({
       format: 'DD-MM-YYYY',
     });
     $('#myDatepicker2').datetimepicker({
       format: 'DD-MM-YYYY',});
     
    
   
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