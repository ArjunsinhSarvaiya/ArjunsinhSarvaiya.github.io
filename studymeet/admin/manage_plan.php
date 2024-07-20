<?php 
   require_once('../config/config.php');
   require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
   require_once("header.php"); 
  
   $obj = new StudyMeet();
   $result=$obj->getmst_mst_plans();
  // echo AJAX_URL;die();

   ?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3><b>All Plan Details</b></h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <a href="<?php echo 'add_plan.php';?>">
                <i class="fa fa-plus"></i> Add Plan</a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
            <div class="alert alert-danger fade in error-msg hidden">
            </div>
            <div class="alert alert-success fade in success-msg hidden">
            </div>
            <div class="x_content">
               <table id="export" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                     <tr>
                        <th>Sr No.</th>
                        <th>Plan Title</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                   <?php if(!empty($result)){ $i=1; ?>
                   <?php foreach ($result as $results) {                 
                        ?>
                    <tr>
                      <td><?php echo $i++;;?></td>
                      <td><?php echo $results->plan_name; ?></td>                       
                      <td><?php echo $results->plan_month; ?></td>                      
                      <td><?php echo $results->plan_amount."₹"; ?></td>
                      <td><?php if ($results->status=="1") {
                            echo "Active";
                        }else if ($results->status=="2") {
                            echo "Block";
                        } ?></td>
                      <td> <a href="<?php echo ADMIN_URL.'add_plan.php?id='.base64_encode($results->plan_id);?>" class="btn btn-primary">Edit</a> 
                        
                      <?php if($results->status=="1"){?>
                        <a href="javascript:void(0);" class="btn btn-danger edit_plan" id="<?php echo $results->plan_id; ?>">Block</a>

                      <?php }?>

                      <?php if($results->status=="2"){?>
                        <a href="javascript:void(0);" class="btn btn-danger edit_unblock" id="<?php echo $results->plan_id; ?>">UnBlock</a>

                      <?php }?>
                        
                      </td>
                      <?php } ?>
                    </tr>                     
                    <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
      $('#export').DataTable( {
             dom: 'Bfrtip',
              lengthMenu: [
                  [ 25, 50, -1 ],
                  [ '25 rows', '50 rows', 'Show all' ]
              ],
             buttons: [
               {
                 extend: 'pageLength',
               },
             ],
      });   
  });
</script>
<script type="text/javascript">  
    $(document).ready(function(){
        $(document).on('click','.edit_plan',function(){
            var plan_id = $(this).attr('id');
            if(confirm("Are you sure you want to Block Plan?")){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo AJAX_URL;?>",
                    data: {block_plan_id:plan_id,status:2},
                    success: function(data) {                            
                        if(data.success){
                            $('.success-msg').removeClass("hidden");
                            $('.success-msg').html(data.message);
                            location.reload();
                        }else{
                            $('.error-msg').removeClass("hidden");
                            $('.error-msg').html(data.message);
                        }
                    }
                });
            }
        });
    });

     $(document).ready(function(){
        $(document).on('click','.edit_unblock',function(){
            var plan_id = $(this).attr('id');
            if(confirm("Are you sure you want to UnBlock Plan?")){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo AJAX_URL;?>",
                    data: {unblock_plan_id:plan_id,status:1},
                    success: function(data) {                            
                        if(data.success){
                            $('.success-msg').removeClass("hidden");
                            $('.success-msg').html(data.message);
                            location.reload();
                        }else{
                            $('.error-msg').removeClass("hidden");
                            $('.error-msg').html(data.message);
                        }
                    }
                });
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo LINK_URL;?>js/button/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo LINK_URL;?>js/button/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo LINK_URL;?>js/button/buttons.flash.min.js"></script>
<script type="text/javascript" src="<?php echo LINK_URL;?>js/button/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo LINK_URL;?>js/button/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo LINK_URL;?>js/button/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo LINK_URL;?>js/button/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo LINK_URL;?>js/button/buttons.print.min.js"></script>
<?php require_once(ROOT_DIR.ADMIN_DIR.'/footer.php'); ?>-