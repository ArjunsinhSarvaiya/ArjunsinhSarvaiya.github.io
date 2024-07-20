<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
  
    $obj = new StudyMeet();

    $success = $error = array();
    if(isset($_GET["id"])){
        if(!empty($_GET["id"])){
            $question_id   = base64_decode($_GET["id"]);
        }
    }
    $by = "";
    if(isset($_GET["by"])){
        if(!empty($_GET["by"])){
            $by = $_GET["by"];
        }
    }
    if(!empty($question_id)){
        $filter   = array("question_id"=>$question_id);
        $result=$obj->getmst_mst_question_comment($filter);
        if(empty($result)){
            $question_id   = '';
        }
    }
    if (isset($_POST['btn_comment'])) {
        $comment=isset($_POST['comment'])?$_POST['comment']:"";
        if (!empty($comment)) {
            $data = array();
            $data['question_id']=$question_id;
            $data['user_id']=1;
            $data['user_type']=1;
            $data['status']="1";
            $data['entry_date']=date("Y-m-d H:i:s");

            $data['comment']=$comment;
        
            $comment_result=$obj->addEdit_mst_question_comment($data);
            if ($comment_result) {

                $filter   = array("question_id"=>$question_id);
                $result=$obj->getmst_mst_question_comment($filter);
                $success[]="Comment Added SuccessFully.";   
            }
        }else{
            $error[]="Please Enter Comment.";
        }
    }
?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3><b>Question Comment List</b></h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">

                  <?php if(!empty($error)) { ?>
                    <div class="alert alert-danger fade in">
                      <ul> <?php foreach ($error as $e) { echo '<li>'.$e.'</li>'; } ?> </ul>
                    </div>
                  <?php } if (!empty($success)) { ?>
                    <div class="alert alert-success fade in">
                    <ul> <?php foreach ($success as $s) { echo '<li>'.$s.'</li>'; } ?> </ul>
                    </div>
                  <?php } ?>
            <div class="alert alert-danger fade in error-msg hidden">
            </div>
            <div class="alert alert-success fade in success-msg hidden">
            </div>
            <?php if (!empty($by)) { ?>
                <form id="add-plan" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-md-12 col-xs-12 col-sm-12"> 
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <label class="control-label"for="">Comment<span>:</span></label>
                                <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                    <input type="text" class="form-control" id="comment" name="comment" value="" placeholder="Enter Comment">
                                </div>
                            </div>
                            <div class="form-group col-md-4 col-xs-12 col-sm-12 text-center">
                                <label class="control-label col-md-12 col-xs-12 col-sm-12"for="">&nbsp;</label>
                                <button type="submit" name="btn_comment" class="btn btn-primary">Add Comment</button>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } ?>
            <div class="x_content">
               <table id="export" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                  <thead>
                     <tr>
                        <th>Sr No.</th>
                        <th>Question Title</th>
                        <th>User Name</th>
                        <th>Comment</th>
                        <th>Comment Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($result)){ $i=1; ?>
                      <?php foreach ($result as $results) {
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
                        <td><span style="<?php if ($results->user_id=="1" && $results->user_type=="1") { echo "color: green"; } ?>"><?php echo $user_type; ?></span></td>
                        <td><?php echo $results->comment; ?></td>
                        <td><?php echo date("d-m-Y h:iA",strtotime($results->entry_date)); ?></td>
                        <td><?php if ($results->status=="1") {
                            echo "Active";   
                        }else if ($results->status=="2") {
                            echo "Block";
                        } ?></td>
                        <td>
                            <?php if($results->status=="1"){?>
                                <a href="javascript:void(0);" class="btn btn-danger block_btn" id="<?php echo $results->q_comment_id; ?>">Block</a>
                            <?php }?>
                            <?php if($results->status=="2"){?>
                                <a href="javascript:void(0);" class="btn btn-danger unblock_btn" id="<?php echo $results->q_comment_id; ?>">UnBlock</a>
                            <?php }?>
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
            var id = $(this).attr("id");
            change_status(id,2);
        });
        $(document).on('click','.unblock_btn',function(){
            var id = $(this).attr("id");
            change_status(id,1);
        });
    });
    function change_status(id,status) {
        if(confirm("Are you sure you want to delete Product?")){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo AJAX_URL;?>",
                data: {status_comment_id:id,status:status},
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