<?php 
   require_once('../config/config.php');
   error_reporting(E_ALL);
   require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
   require_once('header.php');
   $obj = new pms();
   $error = $success = array();
   $trn_pr_id   = $projectInfo  =  $emp_id = '';
   
   if(isset($_GET["id"])){
       if(!empty($_GET["id"])){
           $trn_pr_id   = base64_decode($_GET["id"]);
       }
   }
   /*echo "<pre>";print_r($trn_pr_id);die();*/
   if(!empty($trn_pr_id)){
       $filter   = array("trn_pr_id"=>$trn_pr_id);
       $projectInfo  = $obj->get_trnproject($filter);
       /*echo "<pre>";print_r($projectInfo);die();*/
       if(empty($projectInfo)){
           $trn_pr_id   = '';
       }
   }
   /*echo "<pre>";print_r($projectInfo);die();*/
   if(isset($_POST["btnadd"])){
       $pr_id    = isset($_POST["pr_id"])?$_POST["pr_id"]:"";
       $point_name = isset($_POST["point_name"])?$_POST["point_name"]:"";
       $inserted = isset($_POST["inserted"])?$_POST["inserted"]:"";
       $updated   = isset($_POST["updated"])?$_POST["updated"]:"";
       $deleted   = isset($_POST["deleted"])?$_POST["deleted"]:"";
       $display   = isset($_POST["display"])?$_POST["display"]:"";
       $mins_req  = isset($_POST["mins_req"])?$_POST["mins_req"]:"";
       $Remarks  = isset($_POST["Remarks"])?$_POST["Remarks"]:"";
       $testing  = isset($_POST["testing"])?$_POST["testing"]:"";
       $Description  = isset($_POST["Description"])?$_POST["Description"]:"";
       $Remarks  = isset($_POST["Remarks"])?$_POST["Remarks"]:"";
      
       if(empty($pr_id)){
           $error[] = "Please Enter Project Name.";
       }
       if(empty($point_name)){
           $error[] = "Please Enter Start point Name.";
       }
      
       if(empty($error)){
           $data = array(
               'pr_id' => $pr_id,
               'point_name' => $point_name,
               'inserted' => $inserted,
               'updated' => $updated,
               'deleted' => $deleted,
               'display' => $display,
               'Remarks' => $Remarks,
               'testing' => $testing,
               'Description' => $Description,
               'mins_req' => $mins_req,

           );
        $results = $obj->addEdit_trnproject($data,$trn_pr_id);
        if(!empty($results)){
            if(empty($trn_pr_id) && empty($error)){
                $success[] =  "results Details Added Successfully.";
            }else if(!empty($trn_pr_id) &&empty($error)){
                $success[] =  "results Details Updated Successfully.";
            }
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
                  <?php if(empty($trn_pr_id)){ ?>
                  Add
                  <?php }else{ ?>
                  Update
                  <?php } ?>
                  Details
               </h2>
               <ul class="nav navbar-right panel_toolbox">
                  <li>
                     <a href="<?php echo ADMIN_URL.'manage_points.php';?>">
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
                           <label class="control-label" 
                              for="point_name">Project Name*<span>:</span></label>
                           <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                              <input type="text" class="form-control" id="pr_id" 
                                 name="pr_id" value="<?php if(isset($_POST['pr_id'])){ 
                                    echo $_POST['pr_id']; }else if(!empty($projectInfo)) { echo $projectInfo->pr_id; } ?>"
                                 placeholder="Enter Your pr_id">
                           </div>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label" 
                              for="point_name">Point Name*<span>:</span></label>
                           <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                              <input type="text" class="form-control col-md-7 col-xs-12" name="point_name" placeholder="Enter Point Name" maxlength="255" 
                                 value="<?php if(isset($_POST['point_name']) && !empty($error)){ echo $_POST['point_name']; }else if(!empty($projectInfo)){ echo $projectInfo->point_name; } ?>">
                           </div>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label" 
                              for="inserted">Inserted*<span>:</span></label>
                           <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                              <select class="form-control" name="inserted" id="inserted" maxlength="11">
                                 <option value="1" <?php if(isset($_POST["inserted"]) && $_POST["inserted"]==1){ echo "selected"; }else if(!empty($projectInfo) && $projectInfo->inserted==1){ echo "selected"; } ?> >Complete</option>
                                 <option value="2" <?php if(isset($_POST["inserted"]) && $_POST["inserted"]==2){ echo "selected"; }else if(!empty($projectInfo) && $projectInfo->inserted==2){ echo "selected"; } ?> >Pending</option>
                              </select>
                           </div>
                        </div>
                    </div>
                     
                     <div class="col-md-12 col-xs-12 col-sm-12">
                       <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label" 
                              for="updated">Updated*<span>:</span></label>
                           <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                              <select class="form-control" name="updated" id="updated" maxlength="11">
                                 <option value="1" <?php if(isset($_POST["updated"]) && $_POST["updated"]==1){ echo "selected"; }else if(!empty($projectInfo) && $projectInfo->updated==1){ echo "selected"; } ?> >Complete</option>
                                 <option value="2" <?php if(isset($_POST["updated"]) && $_POST["updated"]==2){ echo "selected"; }else if(!empty($projectInfo) && $projectInfo->updated==2){ echo "selected"; } ?> >Pending</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label" 
                              for="deleted">Deleted*<span>:</span></label>
                           <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                              <select class="form-control" name="deleted" id="deleted" maxlength="11">
                                 <option value="1" <?php if(isset($_POST["deleted"]) && $_POST["deleted"]==1){ echo "selected"; }else if(!empty($projectInfo) && $projectInfo->deleted==1){ echo "selected"; } ?> >Complete</option>
                                 <option value="2" <?php if(isset($_POST["deleted"]) && $_POST["deleted"]==2){ echo "selected"; }else if(!empty($projectInfo) && $projectInfo->deleted==2){ echo "selected"; } ?> >Pending</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label" 
                              for="display">Display*<span>:</span></label>
                           <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                              <select class="form-control" name="display" id="display" maxlength="11">
                                 <option value="1" <?php if(isset($_POST["display"]) && $_POST["display"]==1){ echo "selected"; }else if(!empty($projectInfo) && $projectInfo->display==1){ echo "selected"; } ?> >Complete</option>
                                 <option value="2" <?php if(isset($_POST["display"]) && $_POST["display"]==2){ echo "selected"; }else if(!empty($projectInfo) && $projectInfo->display==2){ echo "selected"; } ?> >Pending</option>
                              </select>
                           </div>
                        </div>
                    </div>
                  <div class="col-md-12 col-xs-12 col-sm-12">
                     <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label" 
                              for="testing">Testing*<span>:</span></label>
                           <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                              <select class="form-control" name="testing" id="testing" maxlength="11">
                                 <option value="1" <?php if(isset($_POST["testing"]) && $_POST["testing"]==1){ echo "selected"; }else if(!empty($projectInfo) && $projectInfo->testing==1){ echo "selected"; } ?> >Complete</option>
                                 <option value="2" <?php if(isset($_POST["testing"]) && $_POST["testing"]==2){ echo "selected"; }else if(!empty($projectInfo) && $projectInfo->testing==2){ echo "selected"; } ?> >Pending</option>
                              </select>
                           </div>
                        </div>
                       <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label" 
                              for="status">Minite Require*<span>:</span></label>
                           <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                              <input type="text" name="mins_req" class="form-control item_price" placeholder="Add mins_req" onkeypress="return isNumber(event)" value="<?php if(isset($_POST['mins_req'])){ echo $_POST['mins_req']; }else if(!empty($projectInfo)) { echo $projectInfo->mins_req; } ?>">
                           </div>
                       </div>
                       <div class="col-md-4 col-xs-12 col-sm-12">
                           <label class="control-label" 
                              for="Remarks">Remarks*<span>:</span></label>
                           <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                              <input type="text" name="Remarks" class="form-control item_price" placeholder="Add Remarks" onkeypress="return isNumber(event)" value="<?php if(isset($_POST['Remarks'])){ echo $_POST['Remarks']; }else if(!empty($projectInfo)) { echo $projectInfo->Remarks; } ?>">
                           </div>
                        </div>  
                  </div>
                   <div class="col-md-12 col-xs-12 col-sm-12">
                                  <div class="col-md-12 col-xs-12 col-sm-12 form-group">
                                    <label class="control-label" for="Description">Description<span>:</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <textarea class="form-control" name="Description" rows="7"
                                        placeholder="Enter Address" id="Description"></textarea>
                                    </div>
                                  </div>
                              </div>
            </div>
         </div>
         <div class="form-group col-md-12 col-xs-12 col-sm-12 text-center">
         <button type="submit" name="btnadd" class="btn btn-primary">
         <?php if(empty($trn_pr_id )){ ?>
         Add
         <?php }else{ ?>
         Update
         <?php } ?>
         pr_id
         </button>
         </div>
         </form>
      </div>
   </div>
</div>
</div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
     $('#updated').select2();
      $('#item_id').select2();
     $('#myDatepicker1').datetimepicker({
     format: 'DD-MM-YYYY',
    });
   });
</script>
<?php include_once('footer.php'); ?>