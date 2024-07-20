<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
    $obj = new StudyMeet();
    $result=$obj->getmst_coupon();
    // echo "<pre>";print_r($result);die();
       
?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3><b>Coupon List</b></h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li><a href="<?php echo 'add_coupon.php';?>"><i class="fa fa-plus"></i> Add Coupon</a></li>
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
                        <th>Coupon Code</th>                       
                        <th>Amount</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                   <?php if(!empty($result)){ $i=1; ?>
                      <?php foreach ($result as $results) {   
                         //echo "<pre>";print_r($data);die();                     
                        ?>
                    
                      <tr>
                        <td><?php echo $i++;;?></td>
                        <td><?php echo $results->coupon_code; ?></td>                       
                        <td><?php echo $results->amount; ?></td>                       
                        <td> 
                            <a href="javascript:void(0);" class="btn btn-danger remove_code" id="<?php echo base64_encode($results->coupon_id); ?>">Remove</a>
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
                  extend: 'copy',
                   footer: true,
               },
               {
                   extend: 'excel',
                   footer: false,
                   exportOptions: {
                    columns: [0,1,2],
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
                    columns: [0,1,2],
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
      $(document).on('click','.remove_code',function(){
        var code_id = $(this).attr("id");
        if(confirm("Are you sure you want to Remove Coupon?")){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo AJAX_URL;?>",
                data: {remove_coupon_id:code_id},
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