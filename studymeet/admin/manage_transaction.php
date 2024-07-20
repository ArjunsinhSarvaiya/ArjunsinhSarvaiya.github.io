<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
  
    $obj = new StudyMeet();
    $result=$obj->getmst_mst_transaction();
    $total=$obj->get_amount_total();       
?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3><b>All Transaction Details</b></h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
            <ul class="nav navbar-right panel_toolbox">
               <?php foreach ($total as $totals) {?>
               <li><?php echo "Total: ".$totals->total;?>
               </li>
            <?php } ?>
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
                            <th>User Name</th>
                            <th>User Type</th>
                            <th>User mobile</th>
                            <th>School</th>
                            <th>Class</th>
                            <th>Plan Title</th>
                            <th>Amount</th>
                            <th>Month</th>
                            <th>Expiry Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($result)){ $i=1; ?>
                            <?php foreach ($result as $results) {
                                $user_type="";
                                $class="-";
                                $school_name="-";
                                if ($results->user_type=="1") {
                                    $filter = array("student_id"=>$results->user_id);
                                    $data = $obj->getmst_student($filter);
                                    if ($data) {
                                        $user_type="student";
                                        $class=$data->class;

                                        $school_filter = array("school_collage_id"=>$data->school_name);
                                        $school_data = $obj->getmst_mst_school_collage($school_filter);
                                        if ($school_data) {
                                            $school_name=$school_data->school_collage_name;
                                        }
                                    }
                                }else if ($results->user_type=="2") {
                                    $filter = array("teacher_id"=>$results->user_id);
                                    $data = $obj->getmst_mst_teacher($filter);
                                    if ($data) {
                                        $user_type="teacher";

                                        $school_filter = array("school_collage_id"=>$data->school_name);
                                        $school_data = $obj->getmst_mst_school_collage($school_filter);
                                        if ($school_data) {
                                            $school_name=$school_data->school_collage_name;   
                                        }
                                    }
                                }
                            ?>
                            <tr>
                                <td><?php echo $i++;;?></td>                
                                <td><?php echo $data->name; ?></td>  
                                <td><?php echo $user_type; ?></td>  
                                <td><?php echo $data->mobile; ?></td>  
                                <td><?php echo $school_name; ?></td>  
                                <td><?php echo $class; ?></td>  
                                <td><?php echo $results->plan_name; ?></td>  
                                <td><?php echo $results->plan_amount; ?></td>   
                                <td><?php echo $results->plan_month; ?></td>
                                <td><?php echo date("d-m-Y h:iA",strtotime($results->expiry_date)); ?></td> 
                            </tr>
                            <?php } ?>
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
                   extend: 'excel',
                   footer: false,
                   exportOptions: {
                        format: {
                                body: function (data, row, column, node ) {
                                        return "\0" + data;
                                    }
                        }
                    }
               },
               {
                   extend: 'pdf',
                   footer: false,
                   exportOptions: {
                        format: {
                                body: function (data, row, column, node ) {
                                        return "\0" + data;
                                    }
                        }
                    }
               },
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