<?php 
   require_once('../config/config.php');
   require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
   require_once("header.php"); 
  
   $obj = new StudyMeet();
   $result=$obj->getmst_mst_campaign(); 
   //echo "string";print_r($result);die();
       
   ?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3><b>Campaign List</b></h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        
            <div class="alert alert-danger fade in error-msg hidden">
            </div>
            <div class="alert alert-success fade in success-msg hidden">
            </div>
            <div class="x_content">
               <table id="export" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                     <tr>
                        <th>Sr No.</th>
                        <th>Campaign Title</th>
                        <th>User Name</th>
                        <th>Campaign Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($result)){ $i=1; ?>
                    <?php foreach ($result as $results) {   
                         //echo "<pre>";print_r($data);die();  
                       
                          $user_type="";
                            if ($results->user_type=="1") {
                                $filter = array("student_id"=>$results->user_id);
                                $data = $obj->getmst_student($filter);
                                if ($data) {
                                    $user_type=$data->name;   
                                }
                            }else if ($results->user_type=="2") {
                                $filter = array("teacher_id"=>$results->user_id);
                                $data = $obj->getmst_mst_teacher($filter);
                                if ($data) {
                                    $user_type=$data->name;
                                }
                            }

                          $status="";
                          if ($results->status=="1") {
  
                              $status="Active";
                          }
                          if ($results->status=="2") {
  
                              $status="Expired";
                          }
                          if ($results->status=="3") {
                                $status="Stop";
                          }
  
                         
                        ?>
                    
                     <tr>
                        <td><?php echo $i++;;?></td>
                        <td><?php echo $results->campaign_name; ?></td>
                        <td><?php echo $user_type; ?></td>
                        <td><?php echo date("d-m-Y",strtotime($results->entry_date)); ?></td> 
                        <td><?php echo $status ?></td>                     
                        <td>

                         <?php if($results->status=="1"){?>
                           <a href="javascript:void(0);" class="btn btn-danger block_camp" id="<?php echo $results->campaign_id; ?>">Block</a>

                         <?php }?>

                         <?php if($results->status=="2"){?>
                           <a href="javascript:void(0);" class="btn btn-danger Unblock_camp" id="<?php echo $results->campaign_id; ?>">UnBlock</a>

                         <?php }?>
                        
                        <a href="<?php echo ADMIN_URL.'Campaign_QueList.php?id='.base64_encode($results->campaign_id); ?>" class="btn btn-primary">See All Question</a>

                        <a href="<?php echo ADMIN_URL.'Campaign_Ranking.php?id='.base64_encode($results->campaign_id); ?>" class="btn btn-primary">See All Rank</a>
                       
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
     $(document).ready(function(){
        $(document).on('click','.block_camp',function(){
            var campaign_id = $(this).attr('id');
            if(confirm("Are you sure you want to Block Campaign?")){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo AJAX_URL;?>",
                    data: {block_campaign_id:campaign_id,status:2},
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
        $(document).on('click','.Unblock_camp',function(){
            var campaign_id = $(this).attr('id');

            if(confirm("Are you sure you want to UnBlock Campaign?")){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?php echo AJAX_URL;?>",
                    data: {unblock_campaign_id:campaign_id,status:1},
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