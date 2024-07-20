<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
    $obj = new StudyMeet();
    
    $filter = array("plan_id"=>$plan_id);
    $summery = $obj->get_summery();

    // [student_count] => 21
    // [teacher_count] => 12
    // [question_count] => 70
    // [campaign_count] => 54

?>
<style>
    @media only screen and (min-width: 990px){
        .sizedives{
            width: 25.3333;
        }
    }
    @media only screen and (max-width: 990px){
        .sizedives{
            width: 40.333;
        }
    }
    .tile-stats h3{
        color: white;
        height: 30px;
    }
    h5{
        color: white;
        font-size: 17px;
        height: 30px;
    }
</style>
<div class="">
    <div class="">
        <div class="page-title">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="title_left" style="margin-bottom: 40px;">
                <h3><b>Dashboard</b></h3>
              </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <a href="<?php echo ADMIN_URL.'User_list.php'; ?>" target="_blank">
                        <div class="tile-stats" style="background: linear-gradient(to bottom, #003366 0%, #336699 100%);padding-top: 10px;">
                            <h3 style="text-align: center;margin: 0dp !important;padding: 0dp !important"><?php echo $summery->student_count; ?> </h3>
                            <h3 style="text-align: center;margin-left: 0dp !important;padding: 0dp !important">Total Student</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <a href="<?php echo ADMIN_URL.'User_list.php'; ?>" target="_blank">
                        <div class="tile-stats" style="background: linear-gradient(to bottom, #003366 0%, #336699 100%);padding-top: 10px;">
                            <h3 style="text-align: center;margin: 0dp !important;padding: 0dp !important"><?php echo $summery->teacher_count; ?> </h3>
                            <h3 style="text-align: center;margin-left: 0dp !important;padding: 0dp !important">Total Teacher</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <a href="<?php echo ADMIN_URL.'Campaign_List.php'; ?>" target="_blank">
                        <div class="tile-stats" style="background: linear-gradient(to bottom, #003366 0%, #336699 100%);padding-top: 10px;">
                            <h3 style="text-align: center;margin: 0dp !important;padding: 0dp !important"><?php echo $summery->campaign_count; ?> </h3>
                            <h3 style="text-align: center;margin-left: 0dp !important;padding: 0dp !important">Total Campaign</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <a href="<?php echo ADMIN_URL.'Que_list.php'; ?>" target="_blank">
                        <div class="tile-stats" style="background: linear-gradient(to bottom, #003366 0%, #336699 100%);padding-top: 10px;">
                            <h3 style="text-align: center;margin: 0dp !important;padding: 0dp !important"><?php echo $summery->question_count; ?> </h3>
                            <h3 style="text-align: center;margin-left: 0dp !important;padding: 0dp !important">Total Question</h3>
                        </div>
                    </a>
                </div>
            </div>           
        </div>       
    </div>
</div>
<?php require_once('footer.php'); ?>
