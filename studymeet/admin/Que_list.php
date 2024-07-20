<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
  
    $obj = new StudyMeet();
    $result=$obj->getmst_mst_question();
?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3><b>Question's List</b></h3>
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
                        <th>User Name</th>
                        <th>Question Title</th>
                        <th>Type</th>
                        <th>Option Type</th>
                        <th>Right Answer</th>
                        <th>Option A</th>
                        <th>Option B</th>
                        <th>Option C</th>
                        <th>Option D</th>
                        <th>Entry Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($result)){ $i=1; ?>
                    <?php foreach ($result as $results) {
                        $name="-";
                        if ($results->user_type=="1") {
                            $d_array=array();
                            $d_array['student_id'] = $results->user_id;

                            $user_result=$obj->getmst_student($d_array);
                            if ($user_result) {
                                $name=$user_result->name;
                            }
                        }else if ($results->user_type=="2") {
                            
                            $d_array=array();
                            $d_array['teacher_id'] = $results->user_id;

                            $user_result=$obj->getmst_mst_teacher($d_array);
                            if ($user_result) {
                                $name=$user_result->name;
                            }
                        }

                        $post_type="";
                        if ($results->post_type=="1") {
                            $post_type="Post";
                        }else if ($results->post_type=="2") {
                            $post_type="Question";
                        }
                        $status="";
                        if ($results->status=="1") {
                            $status="Active";
                        }else if ($results->status=="2") {
                            $status="Block";
                        }

                        $option_type="-";
                        if ($results->option_type=="1") {
                            $option_type="With Option";
                        }else if ($results->option_type=="2") {
                            $option_type="Without Option";
                        }
                        
                        ?>
                     <tr>
                        <td><?php echo $i++;;?></td>
                        <td><?php echo $name; ?></td>    
                        <td><?php echo $results->question_text; ?></td>    
                        <td><?php echo $post_type; ?></td>    
                        <td><?php echo $option_type; ?></td>    
                        <td><?php echo $results->right_answer; ?></td>
                        <td><?php echo $results->option_a; ?></td>
                        <td><?php echo $results->option_b; ?></td>   
                        <td><?php echo $results->option_c; ?></td> 
                        <td><?php echo $results->option_d; ?></td> 
                        <td><?php echo date("d-m-Y h:iA",strtotime($results->entry_date)); ?></td> 

                        <td><?php echo $status; ?></td> 
                         
                        <td>
                            <?php if($results->status=="1"){?>
                                <a href="javascript:void(0);" class="btn btn-danger block_que" id="<?php echo $results->question_id; ?>">Block</a>
                            <?php }?>

                            <?php if($results->status=="2"){?>
                                <a href="javascript:void(0);" class="btn btn-danger unblock_que" id="<?php echo $results->question_id; ?>">UnBlock</a>
                            <?php }?>

                            <?php if ($results->post_type!="1") { ?>
                                    <a href="<?php echo ADMIN_URL.'Qu_An_List.php?id='.base64_encode($results->question_id); ?>" class="btn btn-primary">See All Answer</a>
                                    <a href="<?php echo ADMIN_URL.'Que_comment_list.php?id='.base64_encode($results->question_id); ?>" class="btn btn-primary">See All Comment</a>
                            <?php } ?>
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
      $(document).on('click','.block_que',function(){
        var question_id = $(this).attr("id");
        if(confirm("Are you sure you want to InActive Question?")){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo AJAX_URL;?>",
                data: {Block_Question_id:question_id,status:2},
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

      $(document).on('click','.unblock_que',function(){
        var question_id = $(this).attr("id");
        if(confirm("Are you sure you want to Active Question?")){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo AJAX_URL;?>",
                data: {Unblock_Question_id:question_id,status:1},
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