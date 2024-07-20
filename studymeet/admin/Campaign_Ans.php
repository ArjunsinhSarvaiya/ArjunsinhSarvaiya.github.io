<?php 
   require_once('../config/config.php');
   require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
   require_once("header.php"); 
  
   $obj = new StudyMeet();
 
    if(isset($_GET["id"])){
       if(!empty($_GET["id"])){
           $join_id   = base64_decode($_GET["id"]);
       }
    }

    if(isset($_GET["name"])){
      if(!empty($_GET["name"])){
         $user_name = $_GET["name"];
         //echo "string";print_r($user_name);die();
      }
    }

    if(isset($_GET["title"])){
      if(!empty($_GET["title"])){
         $camp_name = $_GET["title"];
         //echo "string";print_r($camp_name);die();
      }
    }
    $by="";
    if(isset($_GET["by"])){
       if(!empty($_GET["by"])){
           $by   = $_GET["by"];
       }
    }

    if(!empty($join_id)){
       $filter   = array("join_id"=>$join_id);
     //  echo "string";print_r($filter);die();
       $result=$obj->getmst_trn_join_campaign($filter);
     // echo "string";print_r($result);die();
       if(empty($result)){
           $join_id   = '';
       }
    }
       
   ?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3><b>Campaign Answer List</b></h3>
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
                        <th>Question Title</th>
                        <th>Answer Status</th>
                        <th>User Answer</th>
                        <th>Right Answer</th>
                        <th>Option-A</th>
                        <th>Option-B</th>
                        <th>Option-C</th>
                        <th>Option-D</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($result)){ $i=1; ?>
                      <?php foreach ($result as $results) { 
                      //echo "<pre>";print_r($results);die(); ?>
                      
                      <tr>
                        <td><?php echo $i++;;?></td>
                        <td><?php echo $camp_name; ?></td>                         
                        <td><?php echo $user_name;?></td>
                        <td><?php echo $results->question_title; ?></td>
                        <td><?php if ($results->answer_status=="0") { ?>
                            <label style="color: green;">Pending</label>
                        <?php }else if ($results->answer_status=="1") { ?>
                            <label style="color: green;">Right</label>
                        <?php }else if ($results->answer_status=="2") { ?>
                            <label style="color: red;">Wrong</label>
                        <?php }else if ($results->answer_status=="3") { ?>
                            <label>Pass</label>
                        <?php } ?></td>
                        <td><?php 
                            if($results->user_answer=="A"){
                                echo $results->option_a;
                            }elseif ($results->user_answer=="B") {
                                echo $results->option_b;
                            }elseif ($results->user_answer=="C") {
                                echo $results->option_c;
                            }elseif ($results->user_answer=="D") {
                                echo $results->option_d;
                            }else{
                              echo $results->user_answer;
                            }
                        ?></td>
                        <td><?php echo $results->right_answer; ?></td>
                        <td><?php echo $results->option_a; ?></td>
                        <td><?php echo $results->option_b; ?></td>
                        <td><?php echo $results->option_c; ?></td>
                        <td><?php echo $results->option_d; ?></td>
                        <td><?php if(!empty($results->file)){ ?>
                                <a href="<?php echo CAMPAIGN_FILE_IMG_URL.$results->file; ?>" target="_blank" class="btn btn-success">View File</a>
                            <?php } ?>
                            <?php if (!empty($by)) {
                                if ($results->answer_status=="2") {?>
                                    <a href="javascript:void(0);" class="btn btn-success set_right" id="<?php echo $results->trn_join_id; ?>">Set Right</a>
                                <?php }else if ($results->answer_status=="1") {?>
                                    <a href="javascript:void(0);" class="btn btn-danger set_wrong" id="<?php echo $results->trn_join_id; ?>">Set Wrong</a>
                                <?php }else if ($results->answer_status=="0") {?>
                                    <a href="javascript:void(0);" class="btn btn-success set_right" id="<?php echo $results->trn_join_id; ?>">Set Right</a>
                                    <a href="javascript:void(0);" class="btn btn-danger set_wrong" id="<?php echo $results->trn_join_id; ?>">Set Wrong</a>
                            <?php } } ?>
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
        $(document).on('click','.set_right',function(){
            var answer_id = $(this).attr("id");
            change_answer_status(answer_id,"1");
        });
        $(document).on('click','.set_wrong',function(){
            var answer_id = $(this).attr("id");
            change_answer_status(answer_id,"2");
        });
    });
    function change_answer_status(answer_id,status){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo AJAX_URL;?>",
            data: {c_answer_status_change:answer_id,status:status},
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