<?php

    if (isset($_SESSION['admin_status']) && $_SESSION['admin_status']=="1") {
    	$_SESSION['admin_status'] = "2";
    }else{
    	session_start();
    }

//if((isset($_SESSION['admin_id'])) || (isset($_SESSION['admin_login'])) || (isset($_SERVER['HTTP_JADLAS']) && $_SERVER['HTTP_JADLAS']==='sdfsfjaslf878*&8kalk308&slkaoi437d_D(S)DAL#$*(*(SDA&*#JAD*&*&@$J)@&h*Thf^^H%643jkh&^786234j6L*&*')){

    /*ini_set('session.gc_maxlifetime', '315360000');
	ini_set('session.use_cookies', '1');
	ini_set('session.cookie_lifetime', '315360000');*/
	ini_set('post_max_size', '10M');
	ini_set('max_execution_time', 60);
	ini_set('upload_max_filesize', '20M');
	error_reporting(0);
	
	date_default_timezone_set("Asia/Kolkata");

	define("PROJECT_NAME", 'StudentMeet');
	define("PROJECT_TITLE", 'StudentMeet');
	define("DIR", "studymeet");
	define("CONFIG_DIR", "config");
	$protocol=strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                === FALSE ? 'http:' : 'https:';
    /*$protocol='https:';*/
	define("HOST_PROTOCOL", $protocol);
	define("ROOT_DIR", $_SERVER['DOCUMENT_ROOT']."/".DIR."/");
	define("HOST", $_SERVER['HTTP_HOST']."/".DIR);
	define("URL", HOST_PROTOCOL.'//'.HOST.'/');
	/* Direcotry Variables start */
	define("IMG_DIR", "images");
	define("ADMIN_DIR", "admin");

	/* URL Variables start */
	define("LINK_URL", HOST_PROTOCOL.'//'.HOST.'/');
	define("AJAX_URL", LINK_URL.CONFIG_DIR.'/ajax.php');
	define("IMG_URL", LINK_URL.IMG_DIR.'/');
	define("LOGO_URL", LINK_URL.IMG_DIR.'/'.'climax-logo.png');
	define("ADMIN_URL", HOST_PROTOCOL.'//'.HOST.'/'.ADMIN_DIR.'/');

	define("PROFILE_IMG_DIR", "Profile");
	define("PROFILE_IMG_PATH", ROOT_DIR.IMG_DIR.'/'.PROFILE_IMG_DIR.'/');
	define("PROFILE_IMG_URL", IMG_URL.PROFILE_IMG_DIR.'/');

	define("QUESTION_FILE_IMG_DIR", "Question File");
	define("QUESTION_FILE_IMG_PATH", ROOT_DIR.IMG_DIR.'/'.QUESTION_FILE_IMG_DIR.'/');
	define("QUESTION_FILE_IMG_URL", IMG_URL.QUESTION_FILE_IMG_DIR.'/');

	define("CAMPAIGN_FILE_IMG_DIR", "Campaign File");
	define("CAMPAIGN_FILE_IMG_PATH", ROOT_DIR.IMG_DIR.'/'.CAMPAIGN_FILE_IMG_DIR.'/');
	define("CAMPAIGN_FILE_IMG_URL", IMG_URL.CAMPAIGN_FILE_IMG_DIR.'/');

	define('FIREBASE_API_KEY', 'AAAAmohFV3s:APA91bGO82MBzzwOd1xMaLHMDKYg6qAcGEq_6M1B4UM02G1d91sp6j_fWU3MyQ-sAXTQQ3VUfGjT3pyFhCqnuULe126SEQpoxE6CqD-soCfdQLbI61b8EiJt5xjbQRHhhZffEvGqrQoN');

	/* Database configuration start */
	define('DB_TYPE', 'mysql');
	define("MAIN_DB_HOST", 'localhost');  
	define("MAIN_DB_USER", 'root');  
	define("MAIN_DB_PASSWORD", '');  
	define("MAIN_DB_DATABSE", 'study_meet');
	define('DB_CHARSET', 'utf8');
	// /* Database configuration end */
/*} else{
	$response['success']=false;
		$response['message']="Invalid Access";
		die(json_encode($response));
}*/

?>