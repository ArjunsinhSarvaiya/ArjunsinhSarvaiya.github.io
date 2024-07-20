<?php
	class StudyMeet{
		var $db;
		function __construct() {
			$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
			$this->db = new PDO(DB_TYPE . ':host=' . MAIN_DB_HOST . ';dbname=' . MAIN_DB_DATABSE . ';charset=' . DB_CHARSET, MAIN_DB_USER, MAIN_DB_PASSWORD, $options);
		}

        function get_medium(){
            $medium = array();
            $medium[]="Hindi";
            $medium[]="English";
            return $medium;
        }

        function get_stream(){
            $stream = array();
            $stream[]="Arts";
            $stream[]="Commerce";
            $stream[]="Science";
            return $stream;
        }

        function getStates(){
            $states = array('Andhra Pradesh','Arunachal Pradesh','Andaman and Nicobar Islands','Assam','Bihar','Chhattisgarh','Chandigarh','Dadra and Nagar Haveli','Daman and Diu','Goa','Gujarat','Haryana','Himachal Pradesh','Jammu and Kashmir','Jharkhand','Karnataka','Kerala','Lakshadweep','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','National Capital Territory of Delhi','Odisha','Punjab','Puducherry','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal');
            return $states;
        }

        function addEdit_mst_student($data="",$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_student` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_student` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `student_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_student($filter=array(),$is_edited='',$student_id=""){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_student` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `student_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY student_id DESC";
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($student_id) && !empty($student_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_mst_student($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_student` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            return $query->rowCount();
        }

        function addEdit_mst_teacher($data,$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_teacher` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_teacher` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `teacher_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_mst_teacher($filter=array(),$is_edited=''){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_teacher` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `teacher_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY teacher_id DESC";
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($teacher_id) && !empty($teacher_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_mst_teacher($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_teacher` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            return $query->rowCount();
        }

        function addEdit_mst_school_collage($data,$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_school_collage` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_school_collage` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `school_collage_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_mst_school_collage($filter=array(),$is_edited=''){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_school_collage` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `school_collage_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY school_collage_name ASC";
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($school_collage_id) && !empty($school_collage_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_mst_school_collage($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_school_collage` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            return $query->rowCount();
        }

        function addEdit_mst_campaign($data="",$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_campaign` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_campaign` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `campaign_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_mst_campaign($filter=array(),$is_edited='',$limit_start="",$limit_ends="",$search_text="",$school_collage="",$class="",$friends_list=array()){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_campaign` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($friends_list)){
                $sql.=" AND ( ";
                $friend_condition="";
                foreach ($friends_list as $key => $val) {

                    if (!empty($friend_condition)) {
                        $friend_condition.=" OR (`user_id`=".$val['user_id']." AND `user_type`=".$val['user_type']." AND  all_friends=1)";
                    }else {

                        $friend_condition.="(`user_id`=".$val['user_id']." AND `user_type`=".$val['user_type']." AND  all_friends=1)";
                    }
                }
                if (!empty($school_collage)) {
                    $friend_condition.=" OR (FIND_IN_SET ('".$school_collage."',school_collage) AND FIND_IN_SET ('".$class."',class) AND all_friends=2) OR (FIND_IN_SET ('".$school_collage."',school_collage) AND class ='' AND all_friends=2)";
                }
                $sql.=$friend_condition." )";
            }
            if (empty($friends_list) && !empty($school_collage)) {
                $sql.=" AND ((FIND_IN_SET ('".$school_collage."',school_collage) AND FIND_IN_SET ('".$class."',class) AND all_friends=2) OR (FIND_IN_SET ('".$school_collage."',school_collage) AND class ='' AND all_friends=2))";
            }
            if(!empty($is_edited)){
                $sql.=" AND `campaign_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            if(!empty($search_text)){
                $sql.=' AND (campaign_name LIKE "%'.$search_text.'%")';
            }

            $sql.=" ORDER BY campaign_id DESC";
            //echo $sql." = <pre>";print_r($params);die();
            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($campaign_id) && !empty($campaign_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }
        function get_user_rank($campaign_id='',$user_id='',$user_type=''){
            
            $sql = "SELECT * FROM (SELECT @a:=@a+1 rank, join_id FROM `mst_join_campaign`,(SELECT @a:= 0) AS a WHERE 1 and campaign_id=".$campaign_id." ORDER BY point DESC, complate_timer ASC) as main LEFT JOIN mst_join_campaign ON mst_join_campaign.join_id=main.join_id WHERE 1 and mst_join_campaign.user_id=".$user_id." and mst_join_campaign.user_type=".$user_type."";

            //echo $sql."<pre>";print_r($params);die();
            $query = $this->db->prepare($sql);
            $query->execute();

            $admin = $query->fetch();
            return $admin;
        }

        function remove_mst_campaign($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_campaign` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            return $query->rowCount();
        }

        function addEdit_mst_friends($data,$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_friends` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_friends` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `friend_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_mst_friends($filter=array(),$is_edited='',$my_id="",$my_type="",$other_user_id="",$other_user_type="",$u_id="",$u_type="",$limit_start="",$limit_ends=""){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_friends` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

        	if (!empty($my_id) && !empty($my_type) && !empty($other_user_id) && !empty($other_user_type)) {
                $sql.=" AND (((`my_id`=:my_id AND `my_type`=:my_type) AND (`other_user_id`=:other_user_id AND `other_user_type`=:other_user_type)) OR ((`my_id` = :other_user_id AND `my_type` = :other_user_type) AND (`other_user_id`=:my_id AND `other_user_type`=:my_type))) ";
                $params[":my_id"]=$my_id;
                $params[":my_type"]=$my_type;
                $params[":other_user_id"]=$other_user_id;
                $params[":other_user_type"]=$other_user_type;
        	}
            if (!empty($u_id) && !empty($u_type)) {
                $sql.=" AND ((`my_id`=:u_id AND `my_type`=:u_type) OR (`other_user_id`=:u_id AND `other_user_type`=:u_type)) ";
                $params[":u_id"]=$u_id;
                $params[":u_type"]=$u_type;
            }

            if(!empty($is_edited)){
                $sql.=" AND `friend_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY friend_id DESC";

            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($friend_id) && !empty($friend_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_mst_friends($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_friends` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            return $query->rowCount();
        }

        function addEdit_mst_join_campaign($data,$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_join_campaign` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    //$all_data .="'".$value."',";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                //echo $sql."<pre>";print_r($params);die();
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_join_campaign` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `join_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_mst_join_campaign($filter=array(),$is_edited='',$limit_start="",$limit_ends="",$sort_by_point=""){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_join_campaign` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `join_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }
            if (!empty($sort_by_point)) {
                $sql.=" ORDER BY point DESC,complate_timer ASC";
            }else{
                $sql.=" ORDER BY join_id DESC";
            }
            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($join_id) && !empty($join_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_mst_join_campaign($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_join_campaign` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            return $query->rowCount();
        }

        function addEdit_mst_notes($data,$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_notes` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_notes` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `note_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_mst_notes($filter=array(),$is_edited='',$limit_start='',$limit_ends=''){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_notes` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `note_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY note_id DESC";

            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($note_id) && !empty($note_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function removeNotebook($note_id=''){
            $sql='DELETE FROM `mst_notes`';
            if(!empty($note_id)){
                $sql.=' WHERE `note_id`='.$note_id;
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            return $query->rowCount();
            //echo "<pre>";print_r($query);die();
        }

        function remove_mst_notes($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_notes` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            return $query->rowCount();
        }
        
        function addEdit_mst_plans($data,$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_plans` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_plans` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `plan_id`=:id";
               // echo "<pre>";print_r($sql);die();
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);            
            $admin = $query->execute($params);            
            return $admin;
        }

        function getmst_mst_plans($filter=array(),$is_edited=''){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_plans` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `plan_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY plan_id DESC";
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($plan_id) && !empty($plan_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_mst_plans($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_plans` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }
            return $query->rowCount();
        }
        
        function addEdit_mst_question($data,$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_question` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                //echo $sql." <pre>";print_r($params);die();
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_question` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `question_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_mst_question($filter=array(),$is_edited='',$user_id="",$user_type="",$friend_array=array(),$limit_start="",$limit_ends=""){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_question` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($user_id) && !empty($user_type) && !empty($friend_array)){
                $friend_query="";
                $sql.=" AND ( ";
                foreach ($friend_array as $key => $value) {
                    
                    if ($value->my_id==$user_id && $value->my_type==$user_type){
                        if (!empty($friend_query)) {
                            $sql.="OR";
                        }else{
                            $friend_query="Next";
                        }
                        $sql.=" (`user_id`='".$value->other_user_id."' AND `user_type`='".$value->other_user_type."') ";
                    }else if ($value->other_user_id==$user_id && $value->other_user_type==$user_type){

                        if (!empty($friend_query)) {
                            $sql.="OR";
                        }else{
                            $friend_query="Next";
                        }
                        $sql.=" (`user_id`='".$value->my_id."' AND `user_type`='".$value->my_type."') ";
                    }
                }
                $sql.=")";
            }

            if(!empty($is_edited)){
                $sql.=" AND `question_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY question_id DESC";

            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }

            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($question_id) && !empty($question_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_mst_question($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_question` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }
            return $query->rowCount();
        }
        
        function addEdit_mst_question_answer($data,$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_question_answer` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_question_answer` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `q_answer_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_mst_question_answer($filter=array(),$is_edited='',$limit_start="",$limit_ends="",$sort_asc=""){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_question_answer` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `q_answer_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }


            if (empty($sort_asc)) {
                $sql.=" ORDER BY q_answer_id DESC";   
            }

            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($q_answer_id) && !empty($q_answer_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_mst_question_answer($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_question_answer` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }
            return $query->rowCount();
        }
        
        function addEdit_mst_question_comment($data,$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_question_comment` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_question_comment` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `q_comment_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_mst_question_comment($filter=array(),$is_edited='',$limit_start="",$limit_ends="",$sort_asc=""){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_question_comment` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `q_comment_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            if (empty($sort_asc)) {
                $sql.=" ORDER BY q_comment_id DESC";   
            }

            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($q_comment_id) && !empty($q_comment_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_mst_question_comment($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_question_comment` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }
            return $query->rowCount();
        }

        function addEdit_mst_transaction($data="",$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_transaction` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_transaction` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `trans_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_mst_transaction($filter=array(),$is_edited='',$limit_start='',$limit_ends=''){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_transaction` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `trans_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY trans_id DESC";

            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($trans_id) && !empty($trans_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_mst_transaction($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_transaction` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }
            return $query->rowCount();
        }
        
        function addEdit_trn_campaign($data,$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `trn_campaign` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `trn_campaign` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `trn_campaign_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_trn_campaign($filter=array(),$is_edited='',$sort_asc=''){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `trn_campaign` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `trn_campaign_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            if (!empty($sort_asc)) {
                $sql.=" ORDER BY trn_campaign_id ASC";
            }else {
                $sql.=" ORDER BY trn_campaign_id DESC";
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($trn_campaign_id) && !empty($trn_campaign_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_trn_campaign($filter=array()){
            $params = array();
            $sql = "DELETE FROM `trn_campaign` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }
            return $query->rowCount();
        }
        
        function addEdit_trn_join_campaign($data,$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `trn_join_campaign` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);
                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `trn_join_campaign` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `trn_join_id`=:id";
                $params[':id']=$id;
            }
            //echo $sql." <pre>";print_r($params);die();
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }

        function getmst_trn_join_campaign($filter=array(),$is_edited='',$limit_start="",$limit_ends=""){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `trn_join_campaign` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `trn_join_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY trn_join_id DESC";
            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            //echo $sql."<pre>";print_r($params);die();
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($trn_join_id) && !empty($trn_join_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }

        function remove_trn_join_campaign($filter=array()){
            $params = array();
            $sql = "DELETE FROM `trn_join_campaign` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }
            return $query->rowCount();
        }

        function search_friend($filter="",$search_text="",$limit_start="",$limit_ends="",$all_entry=""){
            $params = array();
            //$sql = "SELECT * FROM (SELECT mst_student.student_id as user_id, 1 as user_type, mst_student.name, mst_student.mobile, mst_student.image, mst_student.city, mst_student.gmail, mst_school_collage.school_collage_name, mst_student.status, mst_student.class, mst_student.medium, mst_student.stream, 0 as friend FROM `mst_student` LEFT JOIN mst_school_collage ON mst_student.school_name=mst_school_collage.school_collage_id WHERE 1 AND mst_student.status=1 UNION ALL SELECT mst_teacher.teacher_id as user_id, 2 as user_type, mst_teacher.name, mst_teacher.mobile, mst_teacher.image, mst_teacher.city, mst_teacher.gmail, mst_school_collage.school_collage_name, mst_teacher.status, null as class, null as medium, null as stream, 0 as friend FROM `mst_teacher` LEFT JOIN mst_school_collage ON mst_teacher.school_name=mst_school_collage.school_collage_id WHERE 1 AND mst_teacher.status=1) as main WHERE 1 ";

            $sql .= "SELECT * FROM (SELECT mst_student.student_id as user_id, 1 as user_type, mst_student.name, mst_student.mobile, mst_student.image, mst_student.city, mst_student.gmail, mst_school_collage.school_collage_name, mst_student.status, mst_student.class, mst_student.medium, mst_student.stream, 0 as friend FROM `mst_student` LEFT JOIN mst_school_collage ON mst_student.school_name=mst_school_collage.school_collage_id WHERE 1 ";
            if (empty($all_entry)) {
                $sql .= " AND mst_student.status=1 ";   
            }
            $sql .= " UNION ALL SELECT mst_teacher.teacher_id as user_id, 2 as user_type, mst_teacher.name, mst_teacher.mobile, mst_teacher.image, mst_teacher.city, mst_teacher.gmail, mst_school_collage.school_collage_name, mst_teacher.status, null as class, null as medium, null as stream, 0 as friend FROM `mst_teacher` LEFT JOIN mst_school_collage ON mst_teacher.school_name=mst_school_collage.school_collage_id WHERE 1 ";
            if (empty($all_entry)) {
                $sql .= " AND mst_teacher.status=1 ";   
            }
            $sql .= " ) as main WHERE 1 ";

            $sql.=' AND (name LIKE "%'.$search_text.'%" OR school_collage_name LIKE "%'.$search_text.'%" OR city LIKE "%'.$search_text.'%" OR class LIKE "%'.$search_text.'%")';
            $sql.=' ORDER BY name';

            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            //echo $sql;die();
            $query = $this->db->prepare($sql);
            $query->execute();

            $result = $query->fetchAll();
            
            return $result;
        }        
        function get_count_of_answer_comment($question_id,$all_entry=""){
            $sql = "SELECT * FROM (SELECT count(q_answer_id) as answer, null as comment FROM `mst_question_answer` WHERE 1 AND question_id=".$question_id." ";
            if (empty($all_entry)) {
                $sql .= " AND status=1";
            }
            $sql .= " UNION ALL ";
            $sql .= " SELECT null as answer, count(q_comment_id) as comment FROM `mst_question_comment` WHERE 1 AND question_id=".$question_id." ";
            if (empty($all_entry)) {
                $sql .= " AND status=1";
            }

            $sql .= " ) as main WHERE 1 ";

            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        function get_user_wise_total_point($user_id="",$user_type='',$from_date='',$to_date=''){
            $sql = "SELECT SUM(point) as total_point FROM `mst_join_campaign` WHERE 1 AND user_id=".$user_id." AND user_type=".$user_type;
            if (!empty($from_date) && !empty($to_date)) {
                $sql .= " AND date(entry_date)>='".$from_date."' AND date(entry_date)<='".$to_date."'";
            }else{
                $sql .= " AND date(entry_date)='".date("Y-m-d")."'";
            }
            $query = $this->db->prepare($sql);
            $query->execute();

            $result = $query->fetch();
            return $result;
        }

        function get_user_wise_answer_question($user_id="",$user_type='',$answer_type='',$from_date='',$to_date=''){
            $sql = "SELECT count(q_answer_id) as total_point FROM `mst_question_answer` WHERE 1 AND user_id=".$user_id." AND user_type=".$user_type;
            if (!empty($from_date) && !empty($to_date)) {
                $sql .= " AND date(entry_date)>='".$from_date."' AND date(entry_date)<='".$to_date."'";
            }else{
                $sql .= " AND date(entry_date)='".date("Y-m-d")."'";
            }
            if ($answer_type) {
                $sql .= " AND answer_type=".$answer_type;
            }
            $query = $this->db->prepare($sql);
            $query->execute();

            $result = $query->fetch();
            return $result;
        }

         function get_count_campaings($campaign_id=""){
            $sql = "SELECT count(campaign_id) as total_campaign FROM `mst_join_campaign` WHERE 1 AND campaign_id=".$campaign_id."";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetch();
            return $result;
        }


        function getmst_coupon($filter=array(),$is_edited=''){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_coupon_code` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `coupon_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY coupon_id DESC";
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($coupon_id) && !empty($coupon_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }
        
        function remove_mst_coupon_code($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_coupon_code` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            return $query->rowCount();
        }

        function get_city($limit_start="",$limit_ends=''){
            $sql = "SELECT * FROM (SELECT city FROM `mst_student` WHERE 1 GROUP BY city UNION ALL SELECT city FROM `mst_teacher` WHERE 1 GROUP BY city) as main WHERE 1 GROUP BY city ORDER BY city ASC";

            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            unset($result[0]);
            return array_values($result);
        }

        function get_count_friends($filter=array(),$is_edited='',$my_id="",$my_type="",$other_user_id="",$other_user_type="",$u_id="",$u_type="",$limit_start="",$limit_ends=""){
            $params = array();
            extract($filter);
            $sql = "SELECT count(my_id) as total_Friend FROM `mst_friends` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if (!empty($my_id) && !empty($my_type) && !empty($other_user_id) && !empty($other_user_type)) {
                $sql.=" AND (((`my_id`=:my_id AND `my_type`=:my_type) AND (`other_user_id`=:other_user_id AND `other_user_type`=:other_user_type)) OR ((`my_id` = :other_user_id AND `my_type` = :other_user_type) AND (`other_user_id`=:my_id AND `other_user_type`=:my_type))) ";
                $params[":my_id"]=$my_id;
                $params[":my_type"]=$my_type;
                $params[":other_user_id"]=$other_user_id;
                $params[":other_user_type"]=$other_user_type;
            }
            if (!empty($u_id) && !empty($u_type)) {
                $sql.=" AND ((`my_id`=:u_id AND `my_type`=:u_type) OR (`other_user_id`=:u_id AND `other_user_type`=:u_type)) ";
                $params[":u_id"]=$u_id;
                $params[":u_type"]=$u_type;
            }

            if(!empty($is_edited)){
                $sql.=" AND `friend_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY friend_id DESC";
            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            $admin = $query->fetch();
            return $admin;
        }

            
        function CheckAuthentication($name,$password){
            $field='';
            if(is_numeric($name)){
                $field = "mobile";
            }else{
                $field = "name";
            }
            $sql = "SELECT * FROM `mst_admin` WHERE $field=:name AND password=:password";
            $params = array(':name'=>$name,':password'=>md5($password));
            $query = $this->db->prepare($sql);
            $query->execute($params);
            $user = $query->fetch();

           
            if(empty($user)){
                $user = new stdClass();
                $user->user_id = 0;
                $user->error=  "Invalid username/password.";
                return $user;
            }elseif($user->status==0){            
                $user = new stdClass();
                $user->user_id = 0;
                $user->error=  "Your account has been pending for approval.";            
                return $user;
            }else if($user->status==3){
                $user = new stdClass();
                $user->user_id = 0;
                $user->error=  "Your account has been blocked.";
                return $user;
            }

            return $user;
        }

        function get_amount_total(){
            $sql = "SELECT SUM(plan_amount) AS total FROM `mst_transaction` WHERE 1";
           // echo "string";print_r($sql);die();

            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            //echo "string";print_r($result);die();
            return $result;
        }
        function add_Edit_coupon_code($data="",$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_coupon_code` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);

                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `trn_join_campaign` SET";
                foreach ($data as $key => $value) {
                    $sql.=" `".$key."`=:".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `trn_join_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }
        function getmst_school_collage($filter=array(),$is_edited=''){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_school_collage` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `school_collage_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY school_collage_name ASC";
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($school_collage_id) && !empty($school_collage_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }
        function get_summery(){
            $sql = "SELECT 
                        (SELECT COUNT(*) FROM `mst_student` WHERE 1) AS student_count,
                        (SELECT COUNT(*) FROM `mst_teacher` WHERE 1) AS teacher_count,
                        (SELECT COUNT(*) FROM `mst_question` WHERE 1) AS question_count,
                        (SELECT COUNT(*) FROM `mst_campaign` WHERE 1) AS campaign_count";

            $query = $this->db->prepare($sql);
            $query->execute();

            $admin = $query->fetch();
            return $admin;
        }

        function add_Edit_admin_post($data="",$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `admin_post` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);

                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `admin_post` SET";
                foreach ($data as $key => $value) {
                    if (empty($value)) {
                        $sql.=" `".$key."`='',";
                    }else{
                        $sql.=" `".$key."`=:".$key.",";
                        $params[':'.$key]=$value;   
                    }
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `post_id`=:id";
                $params[':id']=$id;
            }
            //echo $sql." <pre>";print_r($params);die();
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }
        function getmst_admin_post($filter=array(),$is_edited='',$sort_by=''){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `admin_post` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    if ($key=="city") {
                        $sql.=" AND ((`".$key."`=:".$key.") OR (`".$key."`=''))";
                        $params[":".$key]=$val;
                    }else if ($key=="state") {
                        $sql.=" AND ((`".$key."`=:".$key.") OR (`".$key."`=''))";
                        $params[":".$key]=$val;
                    }else{
                        $sql.=" AND `".$key."`=:".$key;
                        $params[":".$key]=$val;   
                    }
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `post_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            if (empty($sort_by)) {
                $sql.=" ORDER BY post_id DESC";   
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($post_id) && !empty($post_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }
        function remove_admin_post($filter=array()){
            $params = array();
            $sql = "DELETE FROM `admin_post` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }
            return $query->rowCount();
        }
        function add_Edit_mst_campaign_comment($data="",$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `mst_campaign_comment` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);

                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `mst_campaign_comment` SET";
                foreach ($data as $key => $value) {
                    if (empty($value)) {
                        $sql.=" `".$key."`='',";
                    }else{
                        $sql.=" `".$key."`=:".$key.",";
                        $params[':'.$key]=$value;   
                    }
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `c_comment_id`=:id";
                $params[':id']=$id;
            }
            //echo $sql." <pre>";print_r($params);die();
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }
        function get_mst_campaign_comment($filter=array(),$is_edited='',$limit_start="",$limit_ends=""){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `mst_campaign_comment` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    if ($key=="city") {
                        $sql.=" AND ((`".$key."`=:".$key.") OR (`".$key."`=''))";
                        $params[":".$key]=$val;
                    }else{
                        $sql.=" AND `".$key."`=:".$key;
                        $params[":".$key]=$val;   
                    }
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `c_comment_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY c_comment_id DESC";
            
            if (!empty($limit_start) || $limit_start=="0") {
                $sql.="  LIMIT ".$limit_start.",".$limit_ends;
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($c_comment_id) && !empty($c_comment_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }
        function remove_mst_campaign_comment($filter=array()){
            $params = array();
            $sql = "DELETE FROM `mst_campaign_comment` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }
            return $query->rowCount();
        }
        function add_Edit_manage_language($data="",$id=""){
            $params = array();
            if (empty($id)) {
                $sql="INSERT INTO `manage_language` (";
                $all_data='';
                foreach ($data as $key => $value) {
                    $sql .="`".$key."`,";
                    $all_data .=":".$key.",";
                    $params[':'.$key]=$value;
                }
                $sql=rtrim($sql,",");
                $all_data=rtrim($all_data,",");
                $sql .=") VALUES (".$all_data.")";
                $query = $this->db->prepare($sql);

                $query->execute($params);
                return $this->db->lastInsertId();
            }else{
                $sql="UPDATE `manage_language` SET";
                foreach ($data as $key => $value) {
                    if (empty($value)) {
                        $sql.=" `".$key."`='',";
                    }else{
                        $sql.=" `".$key."`=:".$key.",";
                        $params[':'.$key]=$value;   
                    }
                }
                $sql =rtrim($sql,",");
                $sql .=" WHERE `language_id`=:id";
                $params[':id']=$id;
            }
            $query=$this->db->prepare($sql);
            $admin = $query->execute($params);
            return $admin;
        }
        function get_manage_language($filter=array(),$is_edited=''){
            $params = array();
            extract($filter);
            $sql = "SELECT * FROM `manage_language` WHERE 1";

            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    if ($key=="city") {
                        $sql.=" AND ((`".$key."`=:".$key.") OR (`".$key."`=''))";
                        $params[":".$key]=$val;
                    }else{
                        $sql.=" AND `".$key."`=:".$key;
                        $params[":".$key]=$val;   
                    }
                }
            }

            if(!empty($is_edited)){
                $sql.=" AND `language_id`!=:is_edited";
                $params[":is_edited"]=$is_edited;
            }

            $sql.=" ORDER BY language_name ASC";
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }

            if((isset($language_id) && !empty($language_id)) || !empty($is_edited)){
                $admin = $query->fetch();
            }else{
                $admin = $query->fetchAll();
            }
            return $admin;
        }
        function remove_manage_language($filter=array()){
            $params = array();
            $sql = "DELETE FROM `manage_language` WHERE 1";
            if(!empty($filter)){
                foreach ($filter as $key => $val) {
                    $sql.=" AND `".$key."`=:".$key;
                    $params[":".$key]=$val;
                }
            }
            $query = $this->db->prepare($sql);
            if(!empty($params)){
                $query->execute($params);
            }else{
                $query->execute();
            }
            return $query->rowCount();
        }
	}
?>