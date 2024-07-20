<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
  
    $obj = new StudyMeet();
 
    if(isset($_GET["id"])){
        if(!empty($_GET["id"])){
            $campaign_id   = base64_decode($_GET["id"]);
        }
    }
    $by="";
    if(isset($_GET["by"])){
       if(!empty($_GET["by"])){
           $by   = $_GET["by"];
       }
    }

    if(!empty($campaign_id)){
        $filter   = array("campaign_id"=>$campaign_id);
        //echo "string";print_r($filter);die();
        $result=$obj->getmst_mst_join_campaign($filter,"","","","sort_by_point");
        //echo "<pre>";print_r($result);die();
        if(empty($result)){
            $campaign_id   = '';
        }
    }
    function get_rank($number){
        if ($number >= 11 && $number <= 13) {
            return $number."th";
        }
        if ($number % 10 == 1) {
            return $number."st";
        }else if ($number % 10 == 2) {
            return $number."nd";
        }else if ($number % 10 == 3) {
            return $number."rd";
        }else{
            return $number."th";
        }
        return $number;
    }
?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3><b>Campaign Ranking List</b></h3>
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
                        <th>Rank</th>
                        <th>Points</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php if(!empty($result)){ $i=1; ?>
                      <?php foreach ($result as $results) {   
                            // echo "<pre>";print_r($results->user_id);die();
                            $filter = array("campaign_id"=>$results->campaign_id);
                            $que = $obj->getmst_mst_campaign($filter);
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
                        ?>                    
                     <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $que->campaign_name; ?></td> 
                        <td><?php echo $user_type; ?></td>
                        <td><?php echo get_rank($i++); ?></td>
                        <td><?php echo $results->point; ?></td>
                        <td> <a href="<?php echo ADMIN_URL.'Campaign_Ans.php?id='.base64_encode($results->join_id).'&name='.$user_type.'&title='.$que->campaign_name.'&by='.$by;?>" class="btn btn-primary" id="">See Answer</a>
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
      $(document).on('click','.remove-product',function(){
        var product_id = $(this).attr("id");
        if(confirm("Are you sure you want to delete Product?")){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo AJAX_URL;?>",
                data: {remove_product_id:product_id},
                success: function(data){                            
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