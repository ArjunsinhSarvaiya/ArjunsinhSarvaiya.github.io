<?php 
    require_once('../config/config.php');
    require_once(ROOT_DIR.CONFIG_DIR.'/functions.php');
    require_once("header.php"); 
    $obj = new StudyMeet(); 
    $error = $success=array();
    $campaign_id="";
    if (isset($_GET['id'])) {
        $campaign_id = base64_decode($_GET['id']);

        $camp_data=$obj->getmst_mst_campaign(array('campaign_id' => $campaign_id,));

        $trn_camp=$obj->getmst_trn_campaign(array('campaign_id' => $campaign_id,),"","ASC");
    }

    $data=array();
    $data['status']="1";
    $sc_clg_data=$obj->getmst_school_collage($data);

    $item_count="";
    
    if(isset($_POST['btn_add_campaign'])){
        $campaign_name = isset($_POST['campaign_name'])?$_POST['campaign_name']:"";
        $from_date = isset($_POST['from_date'])?$_POST['from_date']:"";
        $to_date   = isset($_POST['to_date'])?$_POST['to_date']:"";
        $timer   = isset($_POST['timer'])?$_POST['timer']:"";   
        $classs= isset($_POST['classs'])?$_POST['classs']:"";
        $school_collage= isset($_POST['school_collage'])?$_POST['school_collage']:"";  
        $status= isset($_POST['status'])?$_POST['status']:"";
        $from_time= isset($_POST['from_time'])?$_POST['from_time']:"";
        $to_time= isset($_POST['to_time'])?$_POST['to_time']:"";

        if(empty($_FILES['campaign_image']['name']) && empty($campaign_id)){
            $error[] =  "Please Select Campaign Profile.";
        }
        if(empty($campaign_name)){
            $error[] = "Please Enter campaign_name.";
        } 
        if(empty($from_date)){
            $error[] = "Please Enter from_date";
        } 
        if(empty($to_date)){
            $error[] = "Please Enter to_date";
        } 
        if(empty($timer)){
            $error[] = "Please Enter timer";
        } 

        $item_count=0;
        $index=array();

        foreach ($_POST as $key => $post) {
            if (strpos($key, "point_name") !==false) {
                $a=explode("_", $key);
                $index[$item_count]=$a[2];
                $item_count++;
            }
        }
        if ($item_count<10) {
            $error[] = "Please Add At Least 10 Question.";
        }

        if(!empty($_FILES['campaign_image']) && $_FILES['campaign_image']['error']==0){
            if(!file_exists(CAMPAIGN_FILE_IMG_PATH)){
                mkdir(CAMPAIGN_FILE_IMG_PATH);
            }
            $extension = array();
            $extension[]="jpg";
            $extension[]="jpeg";
            $extension[]="png";
            $extension[]="PNG";
            $org_name = $_FILES['campaign_image']['name'];
            $ext = pathinfo($org_name, PATHINFO_EXTENSION);
            $filename = time().'.'.$ext;

            if(!in_array($ext, $extension)){
                $error[] = "You Can Upload Only Image File.";
            }else{
                move_uploaded_file($_FILES["campaign_image"]["tmp_name"], CAMPAIGN_FILE_IMG_PATH.$filename);
            }
        }
        if (empty($error)) {
            $data = array(
                    'user_type'=> "1",
                    'user_id'=> "1",
                    'campaign_name'=> $campaign_name,
                    'from_date' => date('Y-m-d',strtotime($from_date)),
                    'to_date' => date('Y-m-d',strtotime($to_date)),
                    'entry_date'=>date('Y-m-d H:i:s'),
                    'timer'=>$timer,
                    'status'=>"1",
                    'all_friends'=>$status,
                );
            if (!empty($filename)) {
                $data['campaign_image'] = $filename;
            }
            if (!empty($from_time)) {
                $data['from_time'] = date("H:i:s",strtotime($from_time));
            }
            if (!empty($to_time)) {
                $data['to_time'] = date("H:i:s",strtotime($to_time));
            }

            if ($status=="2") {
                $data['school_collage']=$school_collage;
                if (!empty($classs)) {
                    $data['class']=$classs;
                }
            }
          
            //echo "<pre>";print_r($data);die();
            $project_result = $obj->addEdit_mst_campaign($data,$campaign_id);
            if ($project_result) {
                for ($i=0; $i <$item_count ; $i++) {
                    $data2 = array();
                    $data_extra=$_REQUEST['point_ans2_'.$index[$i]];
                   
                    if ($data_extra=="A"||$data_extra=="B"||$data_extra=="C"||$data_extra=="D") {                        
                        $data2['right_answer'] =$data_extra;
                    }
                    if($data_extra=="0"){
                        $data2['right_answer'] =$_REQUEST['point_ans_'.$index[$i]];
                    }
                    if (!empty($campaign_id)) {
                        $data2['campaign_id']=$campaign_id;
                    }else{
                        $data2['campaign_id']=$project_result;
                    }
                    $data2['question_title'] =$_REQUEST['point_name_'.$index[$i]];
                    $data2['time_for_question'] =$_REQUEST['point_timer_'.$index[$i]];
                    $data2['option_a'] =$_REQUEST['point_a_'.$index[$i]];
                    $data2['option_b'] =$_REQUEST['point_b_'.$index[$i]];
                    $data2['option_c'] =$_REQUEST['point_c_'.$index[$i]];
                    $data2['option_d'] =$_REQUEST['point_d_'.$index[$i]];   
                    $data2['entry_date']=date('Y-m-d H:i:s');             
                    $data2['option_type']=$_REQUEST['option_'.$index[$i]];
                    $trn_campaign_id = isset($_REQUEST['point_trn_question_'.$index[$i]])?$_REQUEST['point_trn_question_'.$index[$i]]:"";
                    
                    $result=$obj->addEdit_trn_campaign($data2,$trn_campaign_id);
                }
                $success[] = "Campaign Added Successfully.";

                $camp_data=$obj->getmst_mst_campaign(array('campaign_id' => $campaign_id,));

                $trn_camp=$obj->getmst_trn_campaign(array('campaign_id' => $campaign_id,));
            }else{
                $error[] = "Something Went Wrong.Please Try Again Later.";
            }
        }     
    }
?>
<div class="">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>CREATE CAMPAIGN</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="<?php echo ADMIN_URL.'Campaign_by_admin.php';?>"><i class="fa fa-arrow-left"></i> Back</a>
                        </li>
                    </ul>         
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <form id="myForm" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                    <?php if(!empty($error)) { ?>
                        <div class="alert alert-danger fade in error-msg">
                            <ul> <?php foreach ($error as $e) { echo '<li>'.$e.'</li>'; } ?> </ul>
                        </div>
                    <?php } if (!empty($success)) { ?>
                        <div class="alert alert-success fade in success-msg">
                            <ul> <?php foreach ($success as $s) { echo '<li>'.$s.'</li>'; } ?> </ul>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <div class="col-md-12 col-xs-12 col-sm-12"> 
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <label class="control-label"for="">Campaing Image<span>:</span></label>
                                <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                    <input type="file" class="form-control" id="campaign_image" name="campaign_image" value="<?php if(isset($_POST['campaign_image'])){ echo $_POST['campaign_image']; } ?>" placeholder="Enter Image">
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <label class="control-label"for="project_name">Campaing Name<span>:</span></label>
                                <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                    <input type="text" class="form-control" id="campaign_name" name="campaign_name" value="<?php if(isset($_POST['campaign_name'])){ echo $_POST['campaign_name']; }else if(isset($camp_data) && !empty($camp_data)){ echo $camp_data->campaign_name;} ?>" placeholder="Enter Campaing Name">
                                </div>
                            </div>
                            <?php //echo "<pre>";print_r($camp_data);die(); ?>
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                    <label class="control-label">Select <span>:</span></label>
                                    <br>
                                    <Input type = 'Radio' Name ='status' value='1' <?php if(isset($_POST['status']) && $_POST['status']=="1"){ echo "checked"; }else if(isset($camp_data) && !empty($camp_data) && $camp_data->all_friends=="1"){ echo "checked";}else if(!isset($_POST['status']) && empty($camp_data)){ echo "checked"; } ?>> Show to all Friend
                                    &nbsp;&nbsp;&nbsp;&nbsp;      
                                    <Input type = 'Radio' Name ='status' value='2' <?php if(isset($_POST['status']) && $_POST['status']=="2"){ echo "checked"; }else if(isset($camp_data) && !empty($camp_data) && $camp_data->all_friends=="2"){ echo "checked";} ?>> Show by school 
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="col-md-4 col-xs-12 col-sm-12 hidden" id="class_check" >
                                <label class="control-label" for="class">Select Class <span>:</span></label>
                                <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <select class="form-control" name="classs" id="class" maxlength="22">
                                        <option value="0">Select Class</option>
                                        <option value="4Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="4Th"){ echo "selected";}else if(isset($camp_data) && !empty($camp_data) && $camp_data->class=="4Th"){ echo "selected";} ?> >4Th</option>
                                        <option value="5Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="5Th"){ echo "selected";}else if(isset($camp_data) && !empty($camp_data) && $camp_data->class=="5Th"){ echo "selected";} ?>>5Th</option>
                                        <option value="6Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="6Th"){ echo "selected";}else if(isset($camp_data) && !empty($camp_data) && $camp_data->class=="6Th"){ echo "selected";} ?>>6Th</option>
                                        <option value="7Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="7Th"){ echo "selected";}else if(isset($camp_data) && !empty($camp_data) && $camp_data->class=="7Th"){ echo "selected";} ?>>7Th</option>
                                        <option value="8Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="8Th"){ echo "selected";}else if(isset($camp_data) && !empty($camp_data) && $camp_data->class=="8Th"){ echo "selected";} ?>>8Th</option>
                                        <option value="9Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="9Th"){ echo "selected";}else if(isset($camp_data) && !empty($camp_data) && $camp_data->class=="9Th"){ echo "selected";} ?>>9Th</option>
                                        <option value="10Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="10Th"){ echo "selected";}else if(isset($camp_data) && !empty($camp_data) && $camp_data->class=="10Th"){ echo "selected";} ?>>10Th</option>
                                        <option value="11Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="11Th"){ echo "selected";}else if(isset($camp_data) && !empty($camp_data) && $camp_data->class=="11Th"){ echo "selected";} ?>>11Th</option>
                                        <option value="12Th" <?php if(isset($_POST["class"]) && $_POST["class"]=="12Th"){ echo "selected";}else if(isset($camp_data) && !empty($camp_data) && $camp_data->class=="12Th"){ echo "selected";} ?>>12Th</option>
                                        <option value="Collage" <?php if(isset($_POST["class"]) && $_POST["class"]=="Collage"){ echo "selected";}else if(isset($camp_data) && !empty($camp_data) && $camp_data->class=="Collage"){ echo "selected";} ?>>Collage</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <label class="control-label" for="start_date">From Date*<span>:</span></label>
                                <div class="input-group date" id='myDatepicker1'>
                                    <input type="text" name="from_date" class="form-control" placeholder="Enter From Date" value="<?php if(isset($_POST['from_date'])){ echo date("d-m-Y",strtotime($_POST['from_date'])); }else if(isset($camp_data) && !empty($camp_data) && !empty($camp_data->from_date)){ echo date("d-m-Y",strtotime($camp_data->from_date));} ?>">
                                    <span class="input-group-addon round-border">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <label class="control-label" for="start_date">To Date*<span>:</span></label>
                                <div class="input-group date" id='myDatepicker2'>
                                    <input type="text" name="to_date" class="form-control" placeholder="Enter To Date"  value="<?php if(isset($_POST['to_date'])){ echo date("d-m-Y",strtotime($_POST['to_date'])); }else if(isset($camp_data) && !empty($camp_data) && !empty($camp_data->to_date)){ echo date("d-m-Y",strtotime($camp_data->to_date));} ?>">
                                    <span class="input-group-addon round-border">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12 col-sm-12 hidden" id="school">
                                <label class="control-label" for="school_name">School / college*<span>:</span></label>
                                <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <select class="form-control" name="school_collage" id="school_collage">
                                        <option  value="0">Select Name</option>
                                        <?php if(!empty($sc_clg_data)){ ?>             
                                            <?php foreach ($sc_clg_data as $scname) {?>
                                                <option value="<?php echo $scname->school_collage_id; ?>" 
                                                    <?php if(isset($_POST['school_collage']) && $_POST['school_collage']==$scname->school_collage_id){echo "selected"; }else if(isset($camp_data) && !empty($camp_data) && $camp_data->school_collage==$scname->school_collage_id){ echo "selected";}?>>
                                                    <?php echo $scname->school_collage_name;?>    
                                                </option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>                                 
                            </div> 
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <label class="control-label" style="text-align: left;">Time for campaign In Minutes*:</label>
                                <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <input id="timer" onkeypress="return isNumber(event)" type="number" name="timer" class="form-control item_qty" placeholder="Enter time in minutes" value="<?php if(isset($_POST['timer'])){ echo $_POST['timer']; }else if(isset($camp_data) && !empty($camp_data) && !empty($camp_data->timer)){ echo $camp_data->timer;} ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <label class="control-label">From Time<span>:</span></label>
                                <input type="time" name="from_time" class="form-control" placeholder="Enter From Time" value="<?php if(isset($_POST['from_time'])){ echo $_POST['from_time']; }else if(isset($camp_data) && !empty($camp_data) && !empty($camp_data->from_time)){ echo $camp_data->from_time;} ?>">
                            </div>
                            <div class="col-md-4 col-xs-12 col-sm-12">
                                <label class="control-label">To Time<span>:</span></label>
                                <input type="time" name="to_time" class="form-control" placeholder="Enter From Time" value="<?php if(isset($_POST['to_time'])){ echo $_POST['to_time']; }else if(isset($camp_data) && !empty($camp_data) && !empty($camp_data->to_time)){ echo $camp_data->to_time;} ?>">
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-12 col-sm-12 col-xs-12 div_main">
                        <?php $i=0; $num=1;?>
                        <?php if ($camp_data) {
                            foreach ($trn_camp as $key => $value) {
                                ?>
                                <div class="x_panel div_sub" style="border-width:1px;border-color: black;">
                                    <div class="col-md-3 col-xs-12 col-sm-12">
                                        <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                            <label class="control-label" for="school_name">Select <span>:</span></label><br>
                                            <Input type='Radio' id="option" class="option" name='<?php echo 'option_'.$i; ?>' value='1' <?php if ($value->option_type=="1"){ echo "checked"; } ?>>With option<br>
                                            <Input type = 'Radio' id="option" class="option" name ='<?php echo 'option_'.$i; ?>' value='2' <?php if ($value->option_type=="2"){ echo "checked"; } ?>> Without option
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <label class="control-label point_name_0text" style="text-align: left;">Question:</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                            <input type="text" name="<?php echo 'point_name_'.$i; ?>" class="form-control item_qty" placeholder="Add Question" value="<?php if (!empty($value->question_title)){ echo $value->question_title; } ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-12 col-sm-12 right_ans <?php if ($value->option_type=="2"){ echo "hidden"; } ?> " id="right_ans" >
                                        <label class="control-label point_ans2__0text" for="school_name">Select Right Answer <span>:</span></label>
                                        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                            <select class="form-control" name="<?php echo 'point_ans2_'.$i; ?>" id="class" maxlength="22">
                                                <option value="0">Right Answer </option>
                                                <option value="A" <?php if ($value->right_answer=="A"){ echo "selected"; } ?>>A</option>
                                                <option value="B" <?php if ($value->right_answer=="B"){ echo "selected"; } ?>>B</option>
                                                <option value="C" <?php if ($value->right_answer=="C"){ echo "selected"; } ?>>C</option>
                                                <option value="D" <?php if ($value->right_answer=="D"){ echo "selected"; } ?>>D</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 <?php if ($value->option_type=="1"){ echo "hidden"; } ?> answer" id="answer">
                                        <label class="control-label point_ans__0text" style="text-align: left;">Answer:</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                            <input type="text" name="<?php echo 'point_ans_'.$i; ?>" class="form-control item_qty" placeholder="Add Answer" value="<?php if (!empty($value->right_answer)){ echo $value->right_answer; }?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 op_a <?php if ($value->option_type=="2"){ echo "hidden"; } ?>" id="op_a">
                                        <label class="control-label point_a__0text" style="text-align: left;">Option A:</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                            <input type="text" name="<?php echo 'point_a_'.$i; ?>" class="form-control item_qty" placeholder="Option A" value="<?php if (!empty($value->option_a)){ echo $value->option_a; } ?>">
                                        </div>
                                    </div>                              
                                    <div class="col-md-3 col-sm-12 col-xs-12 op_b <?php if ($value->option_type=="2"){ echo "hidden"; } ?>" id="op_b">
                                        <label class="control-label point_b__0text" style="text-align: left;">Option B:</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                            <input type="text" name="<?php echo 'point_b_'.$i; ?>" class="form-control item_qty" placeholder="Option B" value="<?php if (!empty($value->option_b)){ echo $value->option_b; } ?>">
                                        </div>
                                    </div>                              
                                    <div class="col-md-3 col-sm-12 col-xs-12 op_c <?php if ($value->option_type=="2"){ echo "hidden"; } ?>" id="op_c">
                                        <label class="control-label point_c__0text" style="text-align: left;">Option C:</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                            <input type="text" name="<?php echo 'point_c_'.$i; ?>" class="form-control item_qty" placeholder="Option C" value="<?php if (!empty($value->option_c)){ echo $value->option_c; } ?>">
                                        </div>
                                    </div>    
                                    <div class="col-md-3 col-sm-12 col-xs-12 op_d <?php if ($value->option_type=="2"){ echo "hidden"; } ?>" id="op_d">
                                        <label class="control-label point_d__0text" style="text-align: left;">Option D:</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                            <input type="text" name="<?php echo 'point_d_'.$i; ?>" class="form-control item_qty" placeholder="Option D" value="<?php if (!empty($value->option_d)){ echo $value->option_d; } ?>">
                                        </div>
                                    </div>                             
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <label class="control-label point_timer__0text" style="text-align: left;">Time In Second:</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                            <input id="timer" type="number" onkeypress="return isNumber(event)" name="<?php echo 'point_timer_'.$i; ?>" class="form-control item_qty" placeholder="Enter time in secound" value="<?php if (!empty($value->time_for_question)){ echo $value->time_for_question; }?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 text-right">

                                        <input id="timer" type="hidden" name="<?php echo 'point_trn_question_'.$i; ?>" class="form-control item_qty" placeholder="Enter time in secound" value="<?php if (!empty($value->trn_campaign_id)){ echo $value->trn_campaign_id; }?>">
                                        <button type="button" class="btn btn-primary btn_add" >Add More</button>
                                        </button> 
                                        <button class="btn btn-danger remove_btn">Remove
                                        </button> 
                                    </div>
                                </div>
                            <?php $i++; $num++;
                            }
                        }else{ ?>
                            <div class="x_panel div_sub" style="border-width:1px;border-color: black;">
                                <div class="col-md-3 col-xs-12 col-sm-12">
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <label class="control-label" for="school_name">Select <span>:</span></label><br>
                                        <Input type = 'Radio' id="option" class="option" name ='<?php echo 'option_'.$i; ?>'  value= '1'>  With option<br>
                                        <Input type = 'Radio' id="option" checked="checked" class="option" name ='<?php echo 'option_'.$i; ?>' value= '2'> Without option
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="control-label point_name_0text" style="text-align: left;">Question:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="<?php echo 'point_name_'.$i; ?>" class="form-control item_qty" placeholder="Add Question" value="">
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-12 col-sm-12 right_ans hidden" id="right_ans" >
                                    <label class="control-label point_ans2__0text" for="school_name">Select Right Answer <span>:</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <select class="form-control" name="<?php echo 'point_ans2_'.$i; ?>" id="class" maxlength="22">
                                            <option value="0">Right Answer </option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 answer" id="answer">
                                    <label class="control-label point_ans__0text" style="text-align: left;">Answer:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="<?php echo 'point_ans_'.$i; ?>" class="form-control item_qty" placeholder="Add Answer" value="">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 op_a hidden" id="op_a">
                                    <label class="control-label point_a__0text" style="text-align: left;">Option A:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="<?php echo 'point_a_'.$i; ?>" class="form-control item_qty" placeholder="Option A" value="">
                                    </div>
                                </div>                              
                                <div class="col-md-3 col-sm-12 col-xs-12 op_b hidden" id="op_b">
                                    <label class="control-label point_b__0text" style="text-align: left;">Option B:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="<?php echo 'point_b_'.$i; ?>" class="form-control item_qty" placeholder="Option B" value="">
                                    </div>
                                </div>                              
                                <div class="col-md-3 col-sm-12 col-xs-12 op_c hidden" id="op_c">
                                    <label class="control-label point_c__0text" style="text-align: left;">Option C:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="<?php echo 'point_c_'.$i; ?>" class="form-control item_qty" placeholder="Option C" value="">
                                    </div>
                                </div>    
                                <div class="col-md-3 col-sm-12 col-xs-12 op_d hidden" id="op_d">
                                    <label class="control-label point_d__0text" style="text-align: left;">Option D:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="<?php echo 'point_d_'.$i; ?>" class="form-control item_qty" placeholder="Option D" value="">
                                    </div>
                                </div>                             
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="control-label point_timer__0text" style="text-align: left;">Time In Second:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input id="timer" type="number" onkeypress="return isNumber(event)" name="<?php echo 'point_timer_'.$i; ?>" class="form-control item_qty" placeholder="Enter time in secound" value="">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="button" class="btn btn-primary btn_add" >Add More</button>
                                    </button> 
                                    <button class="btn btn-danger remove_btn">Remove
                                    </button> 
                                </div>
                            </div>
                            <?php $i++; $num++; ?>
                        <?php } ?>
                        <br><br>
                    </div>
                    <div class="form-group col-md-12 col-xs-12 col-sm-12 text-center">
                        <label class="col-md-12 col-xs-12 col-sm-12" style="color: red;">*Confirm All Data Before Submit</label>
                        <button type="submit" name="btn_add_campaign" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var count=1;
        var total_count=1;
        $('#status').select2();
        $('#item_id').select2();

        $('#myDatepicker1').datetimepicker({
            format: 'DD-MM-YYYY',
        });
         
        $('#myDatepicker2').datetimepicker({
            format: 'DD-MM-YYYY',
            minDate: new Date()
        });

        var show_to = "<?php echo isset($camp_data->all_friends)?$camp_data->all_friends:''; ?>"
        if (show_to!="") {
            show_to_select($('input[name=status]:checked').val());   
        }
        $('#myForm input').on('change', function() {
            show_to_select($('input[name=status]:checked').val());
        });
        count="<?php echo isset($i)?$i:'' ; ?>";
        total_count="<?php echo isset($i)?$i:'' ; ?>";
        $('.btn_add').addClass('hidden');
        $('.btn_add').last().removeClass('hidden');
        $('.remove_btn').removeClass('hidden');
        if (total_count=="1") {
            $('.remove_btn').last().addClass('hidden');
        }

        $(document).on("change",".option",function(){
            var option="0";
            if( $(this).is(":checked") ){
                option = $(this).val();
            }
            
            if (option=="1"){
                $(this).closest('.div_sub').find(".right_ans").removeClass('hidden');
                $(this).closest('.div_sub').find(".op_a").removeClass('hidden');
                $(this).closest('.div_sub').find(".op_b").removeClass('hidden');
                $(this).closest('.div_sub').find(".op_c").removeClass('hidden');
                $(this).closest('.div_sub').find(".op_d").removeClass('hidden');
                $(this).closest('.div_sub').find(".answer").addClass('hidden');
            }else if (option=="2"){          
                $(this).closest('.div_sub').find(".right_ans").addClass('hidden');
                $(this).closest('.div_sub').find(".op_a").addClass('hidden');
                $(this).closest('.div_sub').find(".op_b").addClass('hidden');
                $(this).closest('.div_sub').find(".op_c").addClass('hidden');
                $(this).closest('.div_sub').find(".op_d").addClass('hidden');
                $(this).closest('.div_sub').find(".answer").removeClass('hidden');
            }   
        });    

        $(document).on("click",".btn_add",function(){
            var content = `
                            <div class="x_panel div_sub" style="border-width:1px;border-color: black;">
                                <div class="col-md-3 col-xs-12 col-sm-12">
                                    <div class="col-md-12 col-sm-6 col-xs-12 nopadding">
                                        <label class="control-label" for="school_name">Select <span>:</span></label><br>
                                        <Input type = 'Radio' id="option" class="option" name ='option_`+count+`'  value= '1'>  With option<br>
                                        <Input type = 'Radio' id="option" checked="checked" class="option" name ='option_`+count+`' value= '2'> Without option
                                    </div>
                                </div> 
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="control-label point_name_0text" style="text-align: left;">Question:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="point_name_`+count+`" class="form-control item_qty" placeholder="Add Question" value="">
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-12 col-sm-12 right_ans hidden" id="right_ans" >
                                    <label class="control-label point_ans2__0text" for="school_name">Select Right Answer <span>:</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <select class="form-control" name="point_ans2_`+count+`" id="class" maxlength="22">
                                            <option value="0">Right Answer </option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-12 col-xs-12 answer" id="answer">
                                    <label class="control-label point_ans__0text" style="text-align: left;">Answer:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="point_ans_`+count+`" class="form-control item_qty" placeholder="Add Answer" value="">
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-12 col-xs-12 op_a hidden" id="op_a">
                                    <label class="control-label point_a__0text" style="text-align: left;">Option A:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="point_a_`+count+`" class="form-control item_qty" placeholder="Option A" value="">
                                    </div>
                                </div>                              
                                <div class="col-md-3 col-sm-12 col-xs-12 op_b hidden" id="op_b">
                                    <label class="control-label point_b__0text" style="text-align: left;">Option B:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="point_b_`+count+`" class="form-control item_qty" placeholder="Option B" value="">
                                    </div>
                                </div>                              
                                <div class="col-md-3 col-sm-12 col-xs-12 op_c hidden" id="op_c">
                                    <label class="control-label point_c__0text" style="text-align: left;">Option C:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="point_c_`+count+`" class="form-control item_qty" placeholder="Option C" value="">
                                    </div>
                                </div>    
                                <div class="col-md-3 col-sm-12 col-xs-12 op_d hidden" id="op_d">
                                    <label class="control-label point_d__0text" style="text-align: left;">Option D:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input type="text" name="point_d_`+count+`" class="form-control item_qty" placeholder="Option D" value="">
                                    </div>
                                </div>                             
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="control-label point_timer__0text" style="text-align: left;">Time In Second:</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <input id="timer" type="number" name="point_timer_`+count+`" class="form-control item_qty" placeholder="Enter time in secound" value="">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="button" class="btn btn-primary btn_add" >Add More</button>
                                    </button> 
                                    <button class="btn btn-danger remove_btn">Remove
                                    </button> 
                                </div>
                            </div>`;
            
            $('.div_main').append(content);
            $(this).addClass('hidden');
            $('.remove_btn').removeClass('hidden');
            count++;
            total_count++;
            $(document).on("click",".remove_btn",function(){
                $(this).closest('.div_sub').remove();
                $('.btn_add').last().removeClass('hidden');
                total_count--;
                if (total_count=="1") {
                    $('.remove_btn').last().addClass('hidden');
                }  
            });
        });
    });
    function show_to_select(show_to){
        if (show_to=="1"){
          $("#school").addClass('hidden');
          $("#school2").addClass('hidden');
          $("#class_check").addClass('hidden');
        }else if (show_to=="2"){
          $("#school").removeClass('hidden');
          $("#school2").removeClass('hidden');
          $("#class_check").removeClass('hidden');
        }
    }
  
    function isNumber(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=46) {
          return false;
      }
      return true;
    }
</script>
<?php include_once('footer.php'); ?>