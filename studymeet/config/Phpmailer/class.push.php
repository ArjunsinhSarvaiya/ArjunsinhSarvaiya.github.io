<?php 
/** 
 * Copyright 2014 Shop-Wiz.Com. 
 * 
 * Licensed under the Apache License, Version 2.0 (the "License"); you may 
 * not use this file except in compliance with the License. You may obtain 
 * a copy of the License at 
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0 
 * 
 * Unless required by applicable law or agreed to in writing, software 
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT 
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the 
 * License for the specific language governing permissions and limitations 
 * under the License. 
 */ 

class pushmessage{ 
     
    
     
    public $androidAuthKey      = ""; 
    public $iosApnsCertD            = ""; 
    public $iosApnsCertP            = ""; 
    
     /** 
     *  For Android GCM
     *  $params["msg"] : Expected Message For GCM 
     */  
    private function sendMessageAndroid($registration_id, $params) { 
        $this->androidAuthKey = $params['authkey']; //"AIzaSyAkv_h2gVlzuD0Nz-oF3O6BidOzrjB62K4";//Auth Key Herer 
         
        ## data is different from what your app is programmed 

        $data = array( 
            'registration_ids' => array($registration_id), 
            'priority' => 'high',
            'data' => $params
            ); 
         
        $headers = array( 
        "Content-Type:application/json",  
        "Authorization:key=".$this->androidAuthKey   
        ); 
         
         
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send"); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
        $result = curl_exec($ch); 
        //result sample {"multicast_id":6375780939476727795,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"0:1390531659626943%6cd617fcf9fd7ecd"}]} 
        //http://developer.android.com/google/gcm/http.html  // refer error code 
        curl_close($ch);        
        
        $rtn["code"]    = "000";//means result OK
        $rtn["msg"]     = "OK";
        $rtn["device_id"]     = $params["registration_id"] ;
        $rtn["result"]  = $result;
        return $rtn; 
        
     }      
        
    
   function sendMessageIos($registration_id, $params){
        // Provide the Host Information.
        //echo $registration_id; echo "<pre>"; print_r($params); die();
        $tPort = 2195;
        if($params["ios_mode"]=="production"){
            // 09-03-17
            $params['cert'] = $_SERVER['DOCUMENT_ROOT'].'/inc/certification/Production.pem';
            $tHost = 'gateway.push.apple.com';//this is for distribustion or production
            $tCert = $params['cert'];//$_SERVER['DOCUMENT_ROOT'].'/inc/certification/Production.pem';
        }else{
            // When ever we upload new version make sure we tested with both. This is temp changes for bulletin.
            $params['cert'] = $_SERVER['DOCUMENT_ROOT'].'/inc/certification/Production.pem';
            $tHost = 'gateway.push.apple.com';
            // 09-03-17
            // $params['cert'] = $_SERVER['DOCUMENT_ROOT'].'/inc/certification/Developer.pem'; // revert after new verion
            // saturday: 18/02 pradeep asked to use developer mode.
            // $tHost = 'gateway.sandbox.push.apple.com';// revert after new verion
            $tCert = $params['cert'];//$_SERVER['DOCUMENT_ROOT'].'/inc/certification/Production.pem';
        }

        // Provide the Private Key Passphrase (alternatively you can keep this secrete
        // and enter the key manually on the terminal -> remove relevant line from code).
        // Replace XXXXX with your Passphrase

        $tPassphrase = $params['passphrase']; //'123456';// this is passwword for pem file
        // Provide the Device Identifier (Ensure that the Identifier does not have spaces in it).
        // Replace this token with the token of the iOS device that is to receive the notification.

        //$registration_id = '501cfd6424139b994cdc0973c7e3a61cfbe8f21358683a68e5aad358678ddebd';

        $tToken = trim($registration_id);

        // The message that is to appear on the dialog.
        $tAlert = $params['apns_msg'];//'You have a LiveCode APNS Message';
        // The Badge Number for the Application Icon (integer >=0).
        $tBadge = 0;
        // Audible Notification Option.
        switch ($params['sound']) {
            case '0':
                $tSound = ' ';
                break;
            case '1':
                $tSound = '1.mp3';
                break;
            case '2':
                $tSound = '2.mp3';
                break;
            case '3':
                $tSound = '3.mp3';    
                break;
            default:
                $tSound = 'default';
                break;
        }
        // The content that is returned by the LiveCode "pushNotificationReceived" message.
        $tPayload = 'APNS Message Handled by LiveCode';
        // Create the message content that is to be sent to the device.

        if ($tSound == ' ') {
            // Don't send a sound parameter if user wants to set it "off".
               $tBody['aps'] = array (
                'alert' => $tAlert,
                'badge' => $tBadge,
                'content-available'=>1
                );
        }else{
                $tBody['aps'] = array (
                'alert' => $tAlert,
                'badge' => $tBadge,
                'sound' => $tSound,
                'content-available'=>1
                );
        }
        $tBody ['payload'] = $tPayload;

        //--------------------------------------------------//
        $tBody['extra_info'] = $params;
        //--------------------------------------------------//

        // Encode the body to JSON.
        $tBody = json_encode ($tBody);
        // Create the Socket Stream.
        $tContext = stream_context_create ();
        stream_context_set_option ($tContext, 'ssl', 'local_cert', $tCert);
        // Remove this line if you would like to enter the Private Key Passphrase manually.
        stream_context_set_option ($tContext, 'ssl', 'passphrase', $tPassphrase);
        // Open the Connection to the APNS Server.
        $tSocket = stream_socket_client ('ssl://'.$tHost.':'.$tPort, $error, $errstr, 30, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $tContext);
        //stream_set_blocking($tSocket, 0);
        // Check if we were able to open a socket.
        //var_dump($tSocket); die();
        if (!$tSocket)
        {
            $rtn["code"]    = "000";//means result OK
            $rtn["msg"]     = "Failed";
            $rtn["device_id"]     = $registration_id;
            $rtn["result"]  = $tResult;  
            return $rtn;
        }
        // exit ("APNS Connection Failed: $error $errstr" . PHP_EOL);
        // Build the Binary Notification.
        $tMsg = chr (0) . chr (0) . chr (32) . pack ('H*', $tToken) . pack ('n', strlen ($tBody)) . $tBody;
        // Send the Notification to the Server.
        $tResult = fwrite ($tSocket, $tMsg, strlen ($tMsg));

        //$freadData = $this->checkAppleErrorResponse($tSocket); 

        // Close the Connection to the Server.
        fclose ($tSocket);
        if ($tResult)
        {
            $rtn["code"]    = "000";//means result OK
            $rtn["msg"]     = "OK";
            $rtn["device_id"]     = $registration_id;
            $rtn["result"]  = $tResult; 
            return $rtn; 
        }else{
            $rtn["code"]    = "000";//means result OK
            $rtn["msg"]     = "Failed";
            $rtn["device_id"]     = $registration_id;
            $rtn["result"]  = $tResult;  
            return $rtn; 
        }
    }


    // FUNCTION to check if there is an error response from Apple
    // Returns TRUE if there was and FALSE if there was not
    public function checkAppleErrorResponse($fp) {
        //byte1=always 8, byte2=StatusCode, bytes3,4,5,6=identifier(rowID). 
        // Should return nothing if OK.

        //NOTE: Make sure you set stream_set_blocking($fp, 0) or else fread will pause your script and wait 
        // forever when there is no response to be sent. 

        $apple_error_response = fread($fp, 6);

        if ($apple_error_response) {
            // unpack the error response (first byte 'command" should always be 8)
            $error_response = unpack('Ccommand/Cstatus_code/Nidentifier', $apple_error_response); 

            if ($error_response['status_code'] == '0') {
                $error_response['status_code'] = '0-No errors encountered';
            } else if ($error_response['status_code'] == '1') {
                $error_response['status_code'] = '1-Processing error';
            } else if ($error_response['status_code'] == '2') {
                $error_response['status_code'] = '2-Missing device token';
            } else if ($error_response['status_code'] == '3') {
                $error_response['status_code'] = '3-Missing topic';
            } else if ($error_response['status_code'] == '4') {
                $error_response['status_code'] = '4-Missing payload';
            } else if ($error_response['status_code'] == '5') {
                $error_response['status_code'] = '5-Invalid token size';
            } else if ($error_response['status_code'] == '6') {
                $error_response['status_code'] = '6-Invalid topic size';
            } else if ($error_response['status_code'] == '7') {
                $error_response['status_code'] = '7-Invalid payload size';
            } else if ($error_response['status_code'] == '8') {
                $error_response['status_code'] = '8-Invalid token';
            } else if ($error_response['status_code'] == '255') {
                $error_response['status_code'] = '255-None (unknown)';
            } else {
                $error_response['status_code'] = $error_response['status_code'].'-Not listed';
            }

            echo '<br><b>+ + + + + + ERROR</b> Response Command:<b>' . $error_response['command'] . '</b>&nbsp;&nbsp;&nbsp;Identifier:<b>' . $error_response['identifier'] . '</b>&nbsp;&nbsp;&nbsp;Status:<b>' . $error_response['status_code'] . '</b><br>';

            echo 'Identifier is the rowID (index) in the database that caused the problem, and Apple will disconnect you from server. To continue sending Push Notifications, just start at the next rowID after this Identifier.<br>';

            return true;
        }

        return false;
    }

   /**
     * Send message to SmartPhone
     * $params [pushtype, msg, registration_id]
     */
    public function sendMessage(&$params){
        global $cbuilding_id,$cbuilding_name;
        $params["building_id"] = $cbuilding_id;
        $params["building_name"] = $cbuilding_name;
        //echo "<pre>"; print_r($params); echo "</pre>"; die();
        //$parm = array("msg"=>$params["msg"]);
        //if($params["registration_id"] && $params["msg"]){
        if($params["registration_id"] && $params){
            switch($params["pushtype"]){
                case "ios": 
                    $params['apns_msg']=stripslashes($params['apns_msg']);
                    $ret = $this->sendMessageIos($params["registration_id"], $params); 
                    break; 
                case "android": 
                    $params['gcm_msg']=stripslashes($params['gcm_msg']);
                    $ret = $this->sendMessageAndroid($params["registration_id"], $params); 
                    break; 
            }

            return $ret;
        }

    }
     
    /* 
     * Sample For database
     * regist phone Id from Phone to Mysql via controllers 
     * Look a tableSchema at the bottom 
     * @ $params["appType"] : android or ios.. 
     * @ $params["appId"] : //APA91bGEGu5NSyYDYp5OMO4mZ0j1n2DznGARaNFVcCYfLHvHat..... or 6b1653ad818a89fc6937f5067a9b372aec79edeb9504d6ef.... 
     **/ 
    public function registration($params){ 
        $pushtype       = $params["pushtype"]; 
        $idphone        = $params["idphone"]; 
        
        print_r($params);
        //{insert into database}
        echo json_encode($rtn); 
    } 
     
     
    /** 
     * Step 2. 
     * Send message to each iphone from web App.
     * @params : Array() : messages () 
     */ 
    public function send($params){ 
        //$sql    = "select pushtype, idphone from gcmapns "; 
       // $rows    = $CI->db->get_rows($sql); 
       //get data from database and save to $rows 
        if(is_array($rows)){ 
            foreach($rows as $key => $val){ 
                switch($val["pushtype"]){ 
                    case "ios": 
                        $rtn    = $this->sendMessageIos($val["idphone"], $params); 
                        break; 
                    case "android": 
                        $rtn    = $this->sendMessageAndroid($val["idphone"], $params); 
                        break; 
                }//switch($val["pushtype"]){ 
            }//foreach($rows as $key => $val){ 
        }//if(is_array($rows)){ 

         
    }//function send(){
            
         
     

                 
} 