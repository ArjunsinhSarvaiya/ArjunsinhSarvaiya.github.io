<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
  
    $obj = new StudyMeet();
    $by = $question_id = "";
    if(isset($_GET["id"])){
        if(!empty($_GET["id"])){
            $question_id   = base64_decode($_GET["id"]);
        }
    }
    if(isset($_GET["by"])){
        if(!empty($_GET["by"])){
            $by = $_GET["by"];
        }
    }
    if(!empty($question_id)){
       $filter   = array("question_id"=>$question_id);
       $result=$obj->getmst_mst_question_answer($filter);
       if(empty($result)){
           $question_id   = '';
       }
    }  
?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3><b>Question's Answer List</b></h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
           
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
                        <th>Question Title</th>
                        <th>User Name</th>
                        <th>Answer</th>
                        <th>Answer Type</th>
                        <th>Answer Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($result)){ $i=1; ?>
                      <?php foreach ($result as $results) {
                            //echo "<pre>";print_r($results);die();
                            $answer_type="Pending";
                            if ($results->answer_type=="1") {
                                $answer_type="Right";
                            }else if ($results->answer_type=="2") {
                                $answer_type="Wrong";
                            }
                            $filter = array("question_id"=>$results->question_id);
                            $que = $obj->getmst_mst_question($filter);

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
                        <td><?php echo $i++;;?></td>
                        <td><?php echo $que->question_text; ?></td> 
                        <td><?php echo $user_type; ?></td>
                        <td><?php echo $results->answer; ?></td>
                        <td><?php echo $answer_type; ?></td>
                        <td><?php echo date("d-m-Y h:iA",strtotime($results->entry_date)); ?></td>
                        <td><?php if ($results->status=="1") {
                            echo "Active";   
                        }else if ($results->status=="2") {
                            echo "Block";
                        } ?></td>
                        <td>
                            <?php if($results->status=="1"){?>
                                <a href="javascript:void(0);" class="btn btn-danger block_btn" id="<?php echo $results->q_answer_id; ?>">Block</a>
                            <?php }?>
                            <?php if($results->status=="2"){?>
                                <a href="javascript:void(0);" class="btn btn-danger unblock_btn" id="<?php echo $results->q_answer_id; ?>">UnBlock</a>
                            <?php }?>
                            <?php if(!empty($results->file)){?>
                                <a href="<?php echo QUESTION_FILE_IMG_URL.$results->file; ?>" target="_blank" class="btn btn-primary">View File</a>
                            <?php }?>

                            <?php if(!empty($by)){
                                if ($results->answer_type=="2") {?>
                                    <a href="javascript:void(0);" class="btn btn-success set_right" id="<?php echo $results->q_answer_id; ?>">Set Right</a>
                                <?php }else if ($results->answer_type=="1") {?>
                                    <a href="javascript:void(0);" class="btn btn-danger set_wrong" id="<?php echo $results->q_answer_id; ?>">Set Wrong</a>
                                <?php }else {?>
                                    <a href="javascript:void(0);" class="btn btn-success set_right" id="<?php echo $results->q_answer_id; ?>">Set Right</a>
                                    <a href="javascript:void(0);" class="btn btn-danger set_wrong" id="<?php echo $results->q_answer_id; ?>">Set Wrong</a>
                            <?php } }?>
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
      $(document).on('click','.block_btn',function(){
        var q_answer_id = $(this).attr("id");
        if(confirm("Are you sure you want to Block?")){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo AJAX_URL;?>",
                data: {block_q_ans_id:q_answer_id,status:2},
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
      $(document).on('click','.unblock_btn',function(){
        var q_answer_id = $(this).attr("id");
        if(confirm("Are you sure you want to UnBlock?")){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo AJAX_URL;?>",
                data: {Unblock_q_ans_id:q_answer_id,status:1},
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

        $(document).on('click','.set_right',function(){
            var q_answer_id = $(this).attr("id");
            change_answer_status(q_answer_id,"1");
        });
        $(document).on('click','.set_wrong',function(){
            var q_answer_id = $(this).attr("id");
            change_answer_status(q_answer_id,"2");
        });
  });
    function change_answer_status(q_answer_id,status){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo AJAX_URL;?>",
            data: {q_answer_status_change:q_answer_id,status:status},
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