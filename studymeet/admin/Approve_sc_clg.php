<?php 
   require_once('../config/config.php');
   require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
   require_once("header.php"); 
  
   $obj = new StudyMeet();
   $result=$obj->getmst_mst_school_collage();
   //echo "string";print_r($result);die();
       
?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><b>School Or College Approve</b></h3>
        </div>
    </div>
    <div class="clearfix"></div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="<?php echo 'add_school_collage.php';?>"><i class="fa fa-plus"></i> Add School/Collage</a></li>
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
                        <th>School or College Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($result)){ $i=1; ?>
                        <?php foreach ($result as $results) {   
                            $type="-";
                            if ($results->type==1) {
                                $type="School";
                            }else if ($results->type==2) {
                                $type="Collage";
                            }
                        ?>
                        <tr>
                            <td><?php echo $i++;;?></td>
                            <td><?php echo $results->school_collage_name; ?></td>
                            <td><?php echo $type; ?></td>
                            <td><?php if ($results->status=="1") { echo "Approved"; }else if ($results->status=="2") { echo "Rejected";} ?></td>
                            <td>
                                <?php if($results->status=="1"){?>                             
                                    <a href="javascript:void(0);" class="btn btn-danger reject_btn" id="<?php echo $results->school_collage_id; ?>">Reject</a>
                                <?php }?>
                                <?php if($results->status=="2"){?>
                                    <a href="javascript:void(0);" class="btn btn-success approve_btn" id="<?php echo $results->school_collage_id; ?>">Approve</a>
                                <?php }?>
                                <a href="<?php echo 'add_school_collage.php?id='.base64_encode($results->school_collage_id) ;?>" class="btn btn-primary" id="<?php echo $results->school_collage_id; ?>">Edit</a>
                            </td>
                        </tr>
                    <?php } } ?>
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

        $(document).on('click','.reject_btn',function(){
            var school_collage_id = $(this).attr('id');
            if(confirm("Are you sure you want to Reject?")){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo AJAX_URL;?>",
                    data: {sc_clg_reject_id:school_collage_id,status:2},
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

        $(document).on('click','.approve_btn',function(){
            var school_collage_id = $(this).attr('id');
            if(confirm("Are you sure you want to Approve?")){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo AJAX_URL;?>",
                    data: {sc_clg_approve_id:school_collage_id,status:1},
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