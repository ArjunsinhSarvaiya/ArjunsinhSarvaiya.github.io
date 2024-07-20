<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
    $obj = new StudyMeet();
    $result=$obj->getmst_admin_post();
    // echo "<pre>";print_r($result);die();
?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3><b>Post List</b></h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="<?php echo 'add_post.php';?>"><i class="fa fa-plus"></i> Add Post</a>
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
                        <th>Post Image</th>                       
                        <th>Post Text</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Status</th>
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
                        <td><?php if (!empty($results->image)) { ?>
                                <img src="<?php echo QUESTION_FILE_IMG_URL.$results->image; ?>" width="80px">
                            <?php } ?>
                        </td>
                        <td><?php echo $results->text; ?></td>
                        <td><?php echo $results->city; ?></td>
                        <td><?php echo $results->state; ?></td>
                        <td><?php if ($results->status=="1") {
                            echo "Active";
                        }else if ($results->status=="2") {
                            echo "InActive";
                        } ?></td>
                        <td>
                            <?php if (!empty($results->link)) { ?>
                                <a href="<?php echo $results->link; ?>" class="btn btn-primary" target="_blank">Visit Link</a>
                            <?php } ?>
                            <a href="<?php echo ADMIN_URL.'/add_post.php?id='.base64_encode($results->post_id); ?>" class="btn btn-primary">Edit</a>
                            <a href="javascript:void(0);" class="btn btn-danger remove_post" id="<?php echo base64_encode($results->post_id); ?>">Remove</a>
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
      $(document).on('click','.remove_post',function(){
        var id = $(this).attr("id");
        if(confirm("Are you sure you want to Remove This Post?")){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo AJAX_URL;?>",
                data: {remove_admin_post_id:id},
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