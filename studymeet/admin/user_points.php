<?php 
   require_once('../config/config.php');
   require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
   require_once("header.php"); 
  
    $obj = new StudyMeet();
    $user_id="";
    $user_type="";
    if (isset($_GET['id'])) {
        $user_id = base64_decode($_GET['id']);
    }
    if (isset($_GET['type'])) {
        $user_type = $_GET['type'];
    }

    $today_date=date("Y-m-d");
    $yesterday_date=date("Y-m-d",strtotime("-1 days"));
    $week_before_date="";

    if(date('D')!='Mon')
    {
      $week_before_date = date('Y-m-d',strtotime('last Monday'));
    }else{
        $week_before_date = date('Y-m-d');
    }

    $month_before_date=date("Y-m")."-1";

    $today_campaign_point=$obj->get_user_wise_total_point($user_id,$user_type,$today_date,$today_date);
    $today_question=$obj->get_user_wise_answer_question($user_id,$user_type,"1",$today_date,$today_date);

    $yesterday_campaign_point=$obj->get_user_wise_total_point($user_id,$user_type,$yesterday_date,$yesterday_date);
    $yesterday_question=$obj->get_user_wise_answer_question($user_id,$user_type,"1",$yesterday_date,$yesterday_date);

    $week_campaign_point=$obj->get_user_wise_total_point($user_id,$user_type,$week_before_date,$today_date);
    $week_question=$obj->get_user_wise_answer_question($user_id,$user_type,"1",$week_before_date,$today_date);

    $month_campaign_point=$obj->get_user_wise_total_point($user_id,$user_type,$month_before_date,$today_date);
    $month_question=$obj->get_user_wise_answer_question($user_id,$user_type,"1",$month_before_date,$today_date);
   $result=$obj->search_friend(array(),"","","","all_entry");
?>
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo LINK_URL;?>css/buttons.dataTables.min.css">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><b>User Points</b></h3>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="<?php echo 'User_list.php';?>"><i class="fa fa-arrow-left"></i> Back</a></li>
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
                            <th>Title</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Today's Points</td>
                            <td><?php echo $today_campaign_point->total_point+$today_question->total_point; ?></td>
                        </tr>
                        <tr>
                            <td>Yesterday's Points</td>
                            <td><?php echo $yesterday_campaign_point->total_point+$yesterday_question->total_point; ?></td>
                        </tr>
                        <tr>
                            <td>This Week's Points</td>
                            <td><?php echo $week_campaign_point->total_point+$week_question->total_point; ?></td>
                        </tr>
                        <tr>
                            <td>This Month's Points</td>
                            <td><?php echo $month_campaign_point->total_point+$month_question->total_point; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-firestore.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
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