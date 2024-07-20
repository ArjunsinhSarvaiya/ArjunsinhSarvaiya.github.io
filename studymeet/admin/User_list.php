<?php 
   require_once('../config/config.php');
   require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
   require_once("header.php"); 
  
   $obj = new StudyMeet();
   $result=$obj->search_friend(array(),"","","","all_entry");
?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3><b>All User List</b></h3>
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
                        <th>Student Or Teacher</th>
                        <th>User Name</th>
                        <th>User Profile</th>
                        <th>Number</th>
                        <th>Today's Points</th>
                        <th>Class</th>
                        <th>Gmail</th>
                        <th>school Or college</th>
                        <th>Medium</th>
                        <th>Stream</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($result)){ $i=1; ?>
                        <?php foreach ($result as $results) {
                            $user_type="";
                            if ($results->user_type=="1") {
                                $user_type="Student";
                            }else if ($results->user_type=="2") {
                                $user_type="Teacher";
                            }

                            $today_campaign_point=$obj->get_user_wise_total_point($results->user_id,$results->user_type,date("Y-m-d"),date("Y-m-d"));
                            $today_question=$obj->get_user_wise_answer_question($results->user_id,$results->user_type,"1",date("Y-m-d"),date("Y-m-d"));
                        ?>
                            <tr>
                                <td><?php echo $i++;;?></td>
                                <td><?php echo $user_type; ?></td>
                                <td><?php echo $results->name; ?></td>
                                <td>
                                    <img src="<?php echo PROFILE_IMG_URL.$results->image; ?>" height="100px" width="100px" alt="">
                                </td> 
                                <td><?php echo $results->mobile; ?></td>
                                <td><?php echo $today_campaign_point->total_point+$today_question->total_point; ?></td>
                                <td><?php echo $results->class; ?></td>   
                                <td><?php echo $results->gmail; ?></td>
                                <td><?php echo $results->school_collage_name; ?></td>
                                <td><?php echo $results->medium; ?></td>
                                <td><?php echo $results->stream; ?></td>
                                <td><?php if($results->status=="1"){echo "Active";}else if($results->status=="2"){echo "Block";} ?></td>
                                <td> 
                                    <a href="<?php echo ADMIN_URL.'add_user.php?id='.base64_encode($results->user_id).'&type='.$results->user_type;?>" class="btn btn-primary">Edit</a>

                                    <div class="mobile_div_reset"> 
                                        <input type="hidden" name="mobile_reset" class="mobile_reset" value="<?php echo $results->mobile; ?>">
                                        <?php if($results->status=="1" && $results->user_type=="1"){?>
                                            <a href="javascript:void(0);" class="btn btn-danger block_student" id="<?php echo $results->user_id; ?>">Block</a>
                                        <?php }?>
                                        <?php if($results->status=="2" && $results->user_type=="1"){?>
                                            <a href="javascript:void(0);" class="btn btn-danger unblock_student" id="<?php echo $results->user_id; ?>">UnBlock</a>
                                        <?php }?>
                                        <?php if($results->status=="1" && $results->user_type=="2"){?>
                                            <a href="javascript:void(0);" class="btn btn-danger block_teacher" id="<?php echo $results->user_id; ?>">Block</a>
                                        <?php }?>
                                        <?php if($results->status=="2" && $results->user_type=="2"){?>
                                            <a href="javascript:void(0);" class="btn btn-danger unblock_teacher" id="<?php echo $results->user_id; ?>">UnBlock</a>
                                        <?php }?>
                                    </div>

                                    <a href="<?php echo ADMIN_URL.'user_points.php?id='.base64_encode($results->user_id).'&type='.$results->user_type;?>" class="btn btn-primary">See Points</a>
                                </td>
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

<script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-firestore.js"></script>
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
        $(document).on('click','.block_student',function(){
            var user_id = $(this).attr("id");

            var mobile = $(this).closest('.mobile_div_reset').find(".mobile_reset").val();
            if(confirm("Are you sure you want to Block Student?")){
                student_status_change(user_id,2,mobile)
            }
        });
        $(document).on('click','.unblock_student',function(){
            var user_id = $(this).attr("id");
            if(confirm("Are you sure you want to UnBlock Student?")){
                student_status_change(user_id,1,"")
            }
        });
        $(document).on('click','.block_teacher',function(){
            var user_id = $(this).attr("id");

            var mobile = $(this).closest('.mobile_div_reset').find(".mobile_reset").val();
            if(confirm("Are you sure you want to Block Teacher?")){
                teacher_status_change(user_id,"2",mobile)
            }
        });
        $(document).on('click','.unblock_teacher',function(){
            var user_id = $(this).attr("id");
            if(confirm("Are you sure you want to UnBlock Teacher?")){
                teacher_status_change(user_id,"1","")
            }
        });
    });
    function student_status_change(user_id,status,mobile){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo AJAX_URL;?>",
            data: {block_student_id:user_id,status:status},
            success: function(data){                            
                if(data.success){
                    $('.success-msg').removeClass("hidden");
                    $('.success-msg').html(data.message);
                    if (mobile!="") {
                        Set_token(mobile);
                    }else{
                        location.reload();   
                    }
                }else{
                    $('.error-msg').removeClass("hidden");
                    $('.error-msg').html(data.message);
                }
            }
        });
    }
    function teacher_status_change(user_id,status,mobile){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo AJAX_URL;?>",
            data: {block_teacher_id:user_id,status:status},
            success: function(data){                            
                if(data.success){
                    $('.success-msg').removeClass("hidden");
                    $('.success-msg').html(data.message);
                    if (mobile!="") {
                        Set_token(mobile);
                    }else{
                        location.reload();   
                    }
                }else{
                    $('.error-msg').removeClass("hidden");
                    $('.error-msg').html(data.message);
                }
            }
        });
    }

    function Set_token(mobile){
        const config = {
            apiKey: "AIzaSyBM-ox7s8uVteGtsaYjKoAkN0SeLMRAsMg",

            authDomain: "studymeet-1208f.firebaseapp.com",

            projectId: "studymeet-1208f",

            storageBucket: "studymeet-1208f.appspot.com",

            messagingSenderId: "140694784823",

            appId: "1:140694784823:web:b83934eb2e29f17e6968b2"
        };

        firebase.initializeApp(config);
        var db=firebase.firestore();
        db.collection("user_login").doc(mobile).set({ token: "",})
        .then(function() {
            console.log("Document successfully written!");
        })
        .catch(function(error) {
            console.error("Error writing document: ", error);
            location.reload();
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