<?php

class cron_sms_raw
{
    public $db_username, $db_password, $db_dbname, $mysqli, $combined_sql;

    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
        $this->combined_sql = '';
        $this->db_username = 'root';
        $this->db_password = '';
        $this->db_dbname = 'sms';
        $this->mysqli = new mysqli('localhost', $this->db_username, $this->db_password, $this->db_dbname);
        if ($this->mysqli->connect_errno) {
            printf("Connect failed: %s\n", $this->mysqli->connect_error);
            exit();
        }
    }

    public function index()
    {
        echo '';
    }

    public function credit_check($user_id = '', $cron_sms_row)
    {
//        $this->mysqli = new mysqli('localhost', $this->db_username, $this->db_password, $this->db_dbname);
        $user_credit = trim($cron_sms_row['user_credit']);
        if($user_credit > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function duplicate_check_entry($api_used = '', $cron_sms_row) {
//        $this->mysqli = new mysqli('localhost', $this->db_username, $this->db_password, $this->db_dbname);
//        $cron_sms = $this->mysqli->query("SELECT * FROM `cron_sms` WHERE `cron_sms_id` = $cron_sms_id")->fetch_assoc();
        $data = array(
            'cron_sms_id' => $cron_sms_row['cron_sms_id'],
            'user_id' => $cron_sms_row['user_id'],
            'send_sms_id' => $cron_sms_row['send_sms_id'],
            'to_number' => $cron_sms_row['to_number'],
            'api_used' => $api_used,
            'date' => date('Y-m-d H:i:s')
        );

        $this->combined_sql .= "INSERT INTO `sms_duplicate_check` (`cron_sms_id`, `user_id`, `send_sms_id`, `to_number`, `api_used`, `date`) VALUES (\"{$data['cron_sms_id']}\", \"{$data['user_id']}\", \"{$data['send_sms_id']}\", \"{$data['to_number']}\", \"{$data['api_used']}\", \"{$data['date']}\");";
    }

    /**
     * Identify mobile number operator
     *
     * Operator identify is required for choosing api
     */
    public function operator_identify($number = '') {
        $number = trim($number);
        $number_length = strlen($number);
        if($number_length > 11) {
            $mobile_operator = 'unknown';
            return $mobile_operator;
        }
        if (preg_match('/[+88]*011(\d){8}/', $number)) {
            $mobile_operator = 'citycell';
        } elseif (preg_match('/[+88]*015(\d){8}/', $number)) {
            $mobile_operator = 'teletalk';
        } elseif (preg_match('/[+88]*016(\d){8}/', $number)) {
            $mobile_operator = 'airtel';
        } elseif (preg_match('/[+88]*017(\d){8}/', $number)) {
            $mobile_operator = 'grameenphone';
        } elseif (preg_match('/[+88]*018(\d){8}/', $number)) {
            $mobile_operator = 'robi';
        } elseif (preg_match('/[+88]*019(\d){8}/', $number)) {
            $mobile_operator = 'banglalink';
        } else {
            $mobile_operator = 'unknown';
        }
        return $mobile_operator;
    }

    /**
     * API choice based on mobile operator from 'user' table
     * @param string $mobile_operator
     * @return string
     */
    public function api_choose($mobile_operator = '', $user_id, $user_table, $customer_api_table) {
//        $this->mysqli = new mysqli('localhost', $this->db_username, $this->db_password, $this->db_dbname);
        //        $user_id = $this->session->userdata('user_id');  // cron does not have session
        $mobile_operator = trim($mobile_operator);
        switch($mobile_operator) {
            case 'citycell':
                $citycell_index = array_search("$user_id", array_column($user_table, 'id'));
                $pick_api_id = trim($user_table["$citycell_index"]['api_011']);
                break;
            case 'teletalk':
                $teletalk_index = array_search("$user_id", array_column($user_table, 'id'));
                $pick_api_id = trim($user_table["$teletalk_index"]['api_015']);
                break;
            case 'airtel':
                $airtel_index = array_search("$user_id", array_column($user_table, 'id'));
                $pick_api_id = trim($user_table["$airtel_index"]['api_016']);
                break;
            case 'grameenphone':
                $grameenphone_index = array_search("$user_id", array_column($user_table, 'id'));
                $pick_api_id = trim($user_table["$grameenphone_index"]['api_017']);
                break;
            case 'robi':
                $robi_index = array_search("$user_id", array_column($user_table, 'id'));
                $pick_api_id = trim($user_table["$robi_index"]['api_018']);
                break;
            case 'banglalink':
                $banglalink_index = array_search("$user_id", array_column($user_table, 'id'));
                $pick_api_id = trim($user_table["$banglalink_index"]['api_019']);
                break;
            default:
                $pick_api_id = 'unknown';
        }
        if(($pick_api_id == 0) && ($pick_api_id != 'unknown')) {
//            $selected_api_id = trim($this->mysqli->query("SELECT `customer_api_id` FROM `customer_api` WHERE `default_api`='yes'")->fetch_row()[0]);
            $customer_default_api_index = array_search('yes', array_column($customer_api_table, 'default_api'));
            $selected_api_id = trim($customer_api_table["$customer_default_api_index"]['customer_api_id']);
        } else {
            $selected_api_id = $pick_api_id;
        }
        $customer_selected_api_index = array_search("$selected_api_id", array_column($customer_api_table, 'customer_api_id'));
        $selected_api_name = trim($customer_api_table["$customer_selected_api_index"]['name']);
        return $selected_api_name;
    }

    public function api_last_sms_count($api_name = '', $cron_sms_row) {
//        $this->mysqli = new mysqli('localhost', $this->db_username, $this->db_password, $this->db_dbname);
        $single_sms_count = trim($cron_sms_row['single_sms_count']);
        if($api_name == 'grameenphone') {
            $grameenphone_last = trim($cron_sms_row['gp_last_sms_count']);
            $grameenphone_last_next = $grameenphone_last + $single_sms_count;
            $this->combined_sql .= "UPDATE `customer_api` SET `last_sms_count`=\"{$grameenphone_last_next}\" WHERE `name`='grameenphone';";

        } elseif($api_name == 'robi') {
            $robi_last = trim($cron_sms_row['robi_last_sms_count']);
            $robi_last_next = $robi_last + $single_sms_count;
            $this->combined_sql .= "UPDATE `customer_api` SET `last_sms_count`=\"{$robi_last_next}\" WHERE `name`='robi';";

        } elseif($api_name == 'infobip') {
            $infobip_last = trim($cron_sms_row['infobip_last_sms_count']);
            $infobip_last_next = $infobip_last + $single_sms_count;
            $this->combined_sql .= "UPDATE `customer_api` SET `last_sms_count`=\"{$infobip_last_next}\" WHERE `name`='infobip';";

        } elseif($api_name == 'banglaphone') {
            $banglaphone_last = trim($cron_sms_row['banglaphone_last_sms_count']);
            $banglaphone_last_next = $banglaphone_last + $single_sms_count;
            $this->combined_sql .= "UPDATE `customer_api` SET `last_sms_count`=\"{$banglaphone_last_next}\" WHERE `name`='banglaphone';";

        } else {
            // Do Nothing
        }
    }

    /**
     * Send SMS using Infobip.com SMS API
     * @param $cron_sms_id
     * @param $sms_to
     * @param $sms_message
     * @link http://www.infobip.com
     */
    public function infobip_sms_api($infobip_username, $infobip_password, $infobip_sms_contain) {
//        $this->mysqli = new mysqli('localhost', $this->db_username, $this->db_password, $this->db_dbname);
        $username = trim($infobip_username);
        $password = trim($infobip_password);
        foreach($infobip_sms_contain as $cron_sms_row) {
//        $cron_sms_row = $this->mysqli->query("SELECT * FROM `cron_sms` WHERE `cron_sms_id`=\"{$cron_sms_id}\"")->fetch_assoc();
        $cron_sms_id = trim($cron_sms_row['cron_sms_id']);
        $user_id = trim($cron_sms_row['user_id']);
        $sms_to = trim($cron_sms_row['to_number']);
        $sms_message = trim($cron_sms_row['message']);
        // user has insufficient credit
        $credit_answer = $this->credit_check($user_id, $cron_sms_row);
        if(!$credit_answer) {
            $this->combined_sql .= "UPDATE `cron_sms` SET `soft_error_text`='insufficient_credit' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
            continue;
        }
        if(!$credit_answer) { return; }
        // get masking name
        $bl_tt_masking_enable = trim($cron_sms_row['user_bl_tt_masking_confirm']);

        if(($cron_sms_row['bl_tt_masking_id'] == 0) || ($bl_tt_masking_enable == 'no')) { // Defatult banglalink and teletalk masking
            $masking_name = trim($cron_sms_row['bl_tt_default_masking']);
        } else {
            $masking_name = trim($cron_sms_row['bl_tt_masking_name']);
        }
        // SMS sending code

        $to = '88'.$sms_to;
        $from = $masking_name;
//            $messageId = 'midone'; // if message id is used, then api message id will not be returned
        $text = $sms_message;
        $notifyUrl = 'notifyurlone';
        $notifyContentType = 'notifycontenttypeone';
        $callbackData = 'callbackdataone';
        $postUrl = "https://api.infobip.com/sms/1/text/advanced";
        // creating an object for sending SMS
//            $destination = array("messageId" => $messageId,
//                "to" => $to);
        $destination = array("to" => $to);
        $message = array("from" => $from,
            "destinations" => array($destination),
            "text" => $text,
            "notifyUrl" => $notifyUrl,
            "notifyContentType" => $notifyContentType,
            "callbackData" => $callbackData
        );
        $postData = array("messages" => array($message));
        $postDataJson = json_encode($postData);
        $ch = curl_init();
        $header = array("Content-Type:application/json", "Accept:application/json");
        curl_setopt($ch, CURLOPT_URL, $postUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
        // response of the POST request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseBody = json_decode($response);
        curl_close($ch);
        if ($httpCode >= 200 && $httpCode < 300) { // SMS accepted by API
            $sms_count = $responseBody->messages[0]->smsCount;
            $message_id = $responseBody->messages[0]->messageId;
            $this->combined_sql .= "UPDATE `cron_sms` SET `api_message_id`=\"{$message_id}\", `api_sms_count`=\"{$sms_count}\", `api_sms_accepted`='yes', `api_used`='infobip', `api_current_credit`='0' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
        } else { // Error occurred
            $error_text = $responseBody->requestError->serviceException->text;
            $this->combined_sql .= "UPDATE `cron_sms` SET `api_used`='infobip', `api_error_text`=\"{$error_text}\", `api_sms_accepted`='no' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
        }

        $this->combined_sql .= "UPDATE `cron_sms` SET `api_used`='infobip' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
        $this->api_last_sms_count('infobip',$cron_sms_row);
        $this->duplicate_check_entry('infobip', $cron_sms_row);

//        return 'Message sent using infobip api';
        }
    }

    /**
     * Send SMS using GrameenPhone SMS API
     * @param $cron_sms_id
     * @param $sms_to
     * @param $sms_message
     * @return string
     */
    public function grameenphone_sms_api($gp_username, $gp_password, $gp_sms_contain) {
//        $this->mysqli = new mysqli('localhost', $this->db_username, $this->db_password, $this->db_dbname);
        // credential information
        $gp_api_username = $gp_username;
        $gp_api_password = $gp_password;
        foreach($gp_sms_contain as $cron_sms_row) {
//            var_dump($cron_sms_row);
//            continue;
//        $cron_sms_row = $this->mysqli->query("SELECT * FROM `cron_sms` WHERE `cron_sms_id`=\"{$cron_sms_id}\"")->fetch_assoc();
        $cron_sms_id = trim($cron_sms_row['cron_sms_id']);
        $user_id = trim($cron_sms_row['user_id']);
        $sms_to = trim($cron_sms_row['to_number']);
        $sms_message = trim($cron_sms_row['message']);
        // user has insufficient credit
        $credit_answer = $this->credit_check($user_id, $cron_sms_row);
        if(!$credit_answer) {
            $this->combined_sql .= "UPDATE `cron_sms` SET `soft_error_text`='insufficient_credit' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
            continue;
        }
        if(!$credit_answer) { return; }
        $gp_masking_enable = trim($cron_sms_row['user_gp_masking_confirm']);
        // get masking name
        if(($cron_sms_row['gp_masking_id'] == 0) || ($gp_masking_enable == 'no')) { // gp default masking
            $gp_masking_name = trim($cron_sms_row['gp_default_masking']);
        } else {
            $gp_masking_name = trim($cron_sms_row['gp_masking_name']);
        }
        $gp_masking_name = urlencode($gp_masking_name);

        // Get message type (1 for text, 2 for flash, 3 for unicode[bangla])
        $unicode_sms = trim($cron_sms_row['unicode_sms']);
        if($unicode_sms == 'yes') {  // Message has unicode character
            $soft_message_type = '3';
            $sms_message = bin2hex(iconv('UTF-8', 'UTF-16BE', "$sms_message"));
        } else {
            $soft_message_type = '1';
            $sms_message = urlencode($sms_message);
        }

        // ssl code
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        // Get previous balance from api
        $previous_balance_url =  'https://cmp.grameenphone.com/gpcmpapi/messageplatform/controller.home?username='."$gp_api_username".'&password='."$gp_api_password".'&apicode=3&msisdn=0&countrycode=0&cli=0&messagetype=0&message=0&messageid=0';
        $previous_balance_answer = file_get_contents("$previous_balance_url", false, stream_context_create($arrContextOptions));
        $previous_balance_answer_array = explode(',', $previous_balance_answer);
        $previous_balance = trim($previous_balance_answer_array[1]);
        $api_url = 'https://cmp.grameenphone.com/gpcmpapi/messageplatform/controller.home?';
        $api_url .= 'username='."$gp_api_username".'&';
        $api_url .= 'password='."$gp_api_password".'&';
        $api_url .= 'apicode='.'1'.'&';
        $api_url .= 'msisdn='."$sms_to".'&';
        $api_url .= 'countrycode='.'880'.'&';
        $api_url .= 'cli='."$gp_masking_name".'&';
        $api_url .= 'messagetype='."$soft_message_type".'&';
        $api_url .= 'message='."$sms_message".'&';
        $api_url .= 'messageid='.'0';
        $api_sms_answer_string = file_get_contents("$api_url", false, stream_context_create($arrContextOptions));
        $api_sms_answer_array = explode(',', $api_sms_answer_string);
        $api_sms_status = trim($api_sms_answer_array[0]);
        $api_sms_message_id = trim($api_sms_answer_array[1]);
        // Get next balance from api
        $next_balance_url =  'https://cmp.grameenphone.com/gpcmpapi/messageplatform/controller.home?username='."$gp_api_username".'&password='."$gp_api_password".'&apicode=3&msisdn=0&countrycode=0&cli=0&messagetype=0&message=0&messageid=0';
        $next_balance_answer = file_get_contents("$next_balance_url", false, stream_context_create($arrContextOptions));
        $next_balance_answer_array = explode(',', $next_balance_answer);
        $next_balance = trim($next_balance_answer_array[1]);
        if(is_numeric($next_balance)) {
            $current_credit = $next_balance;
        }
        if((is_numeric($previous_balance)) && (is_numeric($next_balance))) {
            $sms_count = $previous_balance - $next_balance;
        } else {
            $sms_count = 0;
        }

        if($api_sms_status == 200) { // SMS accepted by API
            $this->combined_sql .= "UPDATE `cron_sms` SET `api_message_id`=\"{$api_sms_message_id}\", `api_sms_count`=\"{$sms_count}\", `api_sms_accepted`='yes', `api_used`='grameenphone', `api_current_credit`=\"{$current_credit}\" WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
        } else {  // Error occurred
            $this->combined_sql .= "UPDATE `cron_sms` SET `api_used`='grameenphone', `api_error_text`=\"{$api_sms_answer_array[1]}\", `api_sms_accepted`='no' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
        }

        $this->combined_sql .= "UPDATE `cron_sms` SET `api_used`='grameenphone' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
        $this->api_last_sms_count('grameenphone', $cron_sms_row);
        $this->duplicate_check_entry('grameenphone', $cron_sms_row);
        }
    }

    /**
     * Send SMS using Robi SMS API
     * @param $cron_sms_id
     * @param $sms_to
     * @param $sms_message
     */
    public function robi_sms_api($robi_username, $robi_password, $robi_sms_contain) {
//        $this->mysqli = new mysqli('localhost', $this->db_username, $this->db_password, $this->db_dbname);
        // credential information
        $robi_api_username = trim($robi_username);
        $robi_api_password = trim($robi_password);
        foreach($robi_sms_contain as $cron_sms_row) {
//        $cron_sms_row = $this->mysqli->query("SELECT * FROM `cron_sms` WHERE `cron_sms_id`=\"{$cron_sms_id}\"")->fetch_assoc();
        $cron_sms_id = trim($cron_sms_row['cron_sms_id']);
        $user_id = trim($cron_sms_row['user_id']);
        $sms_to = trim($cron_sms_row['to_number']);
        $sms_message = trim($cron_sms_row['message']);
        // user has insufficient credit
        $credit_answer = $this->credit_check($user_id, $cron_sms_row);
        if(!$credit_answer) {
            $this->combined_sql .= "UPDATE `cron_sms` SET `soft_error_text`='insufficient_credit' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
            continue;
        }
        if(!$credit_answer) { return; }
        $robi_masking_enable = trim($cron_sms_row['user_robi_masking_confirm']);
        // get masking name
        if(($cron_sms_row['robi_masking_id'] == 0) || ($robi_masking_enable == 'no')) { // Default robi masking
            $robi_masking_name = trim($cron_sms_row['robi_default_masking']);
        } else {
            $robi_masking_name = trim($cron_sms_row['robi_masking_name']);
        }
        $robi_masking_name = urlencode($robi_masking_name);
        $sms_message = urlencode($sms_message);
        $api_url = 'https://bmpws.robi.com.bd/ApacheGearWS/SendTextMessage?';
        $api_url .= 'Username='."$robi_api_username".'&';
        $api_url .= 'Password='."$robi_api_password".'&';
        $api_url .= 'From='."$robi_masking_name".'&';
        $api_url .= 'To='."$sms_to".'&';
        $api_url .= 'Message='."$sms_message";
        $api_answer_xml = file_get_contents("$api_url");
        $api_answer_object = simplexml_load_string($api_answer_xml);
//        $api_answer_array = (array)$api_answer_object->ServiceClass;
        if (($api_answer_xml != false) && ("$api_answer_object->ErrorCode" == 0)) { // SMS accepted by API
            $this->combined_sql .= "UPDATE `cron_sms` SET `api_message_id`=\"{$api_answer_object->MessageId}\", `api_sms_count`=\"{$api_answer_object->SMSCount}\", `api_sms_accepted`='yes', `api_used`='robi', `api_current_credit`=\"{$api_answer_object->CurrentCredit}\" WHERE `cron_sms_id`=\"{$cron_sms_id}\";";

            // Api credit to 'customer_api' table for robi
            $this->combined_sql .= "UPDATE `customer_api` SET `api_credit`=\"{$api_answer_object->CurrentCredit}\" WHERE `name`='robi';";
        } else { // Error occurred
                $this->combined_sql .= "UPDATE `cron_sms` SET `api_used`='robi', `api_error_text`=\"{$api_answer_object->ErrorText}\", `api_sms_accepted`='no' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
        }
        // count sms to deduct user credit
        if(isset($api_answer_object->SMSCount)) {
            $sms_count = $api_answer_object->SMSCount;
        } else {
            // SMSCount is not set from api
            $sms_count = 0;
        }

        $this->combined_sql .= "UPDATE `cron_sms` SET `api_used`='robi' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";

        $this->api_last_sms_count('robi', $cron_sms_row);
        $this->duplicate_check_entry('robi', $cron_sms_row);
        }
    }

    /**
     * Send SMS using BanglaPhone SMS API
     * @param $cron_sms_id
     * @param $sms_to
     * @param $sms_message
     */
    public function banglaphone_sms_api($banglaphone_username, $banglaphone_password, $banglaphone_sms_contain) {
//        $this->mysqli = new mysqli('localhost', $this->db_username, $this->db_password, $this->db_dbname);
        // credential information
        $banglaphone_api_username = trim($banglaphone_username);
        $banglaphone_api_password = trim($banglaphone_password);
        foreach($banglaphone_sms_contain as $cron_sms_row) {
//        $cron_sms_row = $this->mysqli->query("SELECT * FROM `cron_sms` WHERE `cron_sms_id`=\"{$cron_sms_id}\"")->fetch_assoc();
        $cron_sms_id = trim($cron_sms_row['cron_sms_id']);
        $user_id = trim($cron_sms_row['user_id']);
        $sms_to = trim($cron_sms_row['to_number']);
        $sms_message = trim($cron_sms_row['message']);
        // user has insufficient credit
        $credit_answer = $this->credit_check($user_id, $cron_sms_row);
        if(!$credit_answer) {
            $this->combined_sql .= "UPDATE `cron_sms` SET `soft_error_text`='insufficient_credit' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
            continue;
        }
        if(!$credit_answer) { return; }


        $sms_message = urlencode($sms_message);
        $api_url = 'http://180.210.190.230:7878/httpapi/sendsms?';
        $api_url .= 'userId='."$banglaphone_api_username".'&';
        $api_url .= 'password='."$banglaphone_api_password".'&';
        $api_url .= 'smsText='."$sms_message".'&';
        $api_url .= 'commaSeperatedReceiverNumbers='."$sms_to";

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $api_answer_json = file_get_contents("$api_url", false, stream_context_create($arrContextOptions));
        $api_answer_object = json_decode($api_answer_json);

        if (($api_answer_json != false) && ("$api_answer_object->isError" == false)) { // SMS accepted by API
            $this->combined_sql .= "UPDATE `cron_sms` SET `api_message_id`=\"{$api_answer_object->insertedSmsIds}\", `api_sms_accepted`='yes', `api_used`='banglaphone' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
        } else { // Error occurred
            $this->combined_sql .= "UPDATE `cron_sms` SET `api_used`='banglaphone', `api_error_text`=\"{$api_answer_object->message}\", `api_sms_accepted`='no' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
        }

        $this->combined_sql .= "UPDATE `cron_sms` SET `api_used`='banglaphone' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
        $this->api_last_sms_count('banglaphone', $cron_sms_row);
        $this->duplicate_check_entry('banglaphone', $cron_sms_row);
        }
    }

    /**
     * Send SMS using API. This is main working function.
     *
     * This function is called from cron job in server
     *
     * @param int $limit
     */
    public function send_sms($limit=1) {
        // **Creating Database Connection
        $this->mysqli = new mysqli('localhost', $this->db_username, $this->db_password, $this->db_dbname);
        $this->mysqli->set_charset("utf8");


        // **Check any process 'remain' in 'cron_sms' table, if not then exit.
        $sms_query = $this->mysqli->query("SELECT * FROM `cron_sms` WHERE `process`='remain' ORDER BY `cron_sms_id` ASC");
        $sms_row_count = $sms_query->num_rows;
        // If there is no process remain then exit
        if($sms_row_count == 0) {
            echo 'No Remaining Process';
            return;
        }

        // **Collect 'send_sms_id' that is 'paused' or 'scheduled' but not 'cleaned' (from DB)
        $paused_scheduled_array = array();
        // Get 'paused' but not 'cleaned'
        $paused_send_sms_query = $this->mysqli->query("SELECT * FROM `send_sms` WHERE `ongoing_status` = 'paused' AND `cron_sms_clean` != 'cleaned'");
        while ($paused_send_sms_row = $paused_send_sms_query->fetch_assoc()) {
            $paused_scheduled_array[] = $paused_send_sms_row['send_sms_id'];
        }
        // Get 'scheduled' but not 'cleaned'
        $current_date_time = date('Y-m-d H:i:s');
        $scheduled_send_sms_query = $this->mysqli->query("SELECT * FROM `send_sms` WHERE `schedule_campaign` = 'yes' AND `schedule_date` > '{$current_date_time}' AND `cron_sms_clean` != 'cleaned'");
        while ($scheduled_send_sms_row = $scheduled_send_sms_query->fetch_assoc()) {
            $paused_scheduled_array[] = $scheduled_send_sms_row['send_sms_id'];
        }

        $paused_scheduled_sms_id = implode(',',$paused_scheduled_array);

        if($paused_scheduled_sms_id == '') {
            $paused_scheduled_sql_text = '';
        } else {
            $paused_scheduled_sql_text = " AND `send_sms_id` NOT IN ({$paused_scheduled_sms_id})";
        }


        // **Get distinct user from "cron_sms" table. Distribute each user same number of sms.
        $user_id_array = array();
        if($user_id_sql_result = $this->mysqli->query("SELECT DISTINCT `user_id` FROM `cron_sms` WHERE `process` = 'remain'")) {
            while($user_id_sql_row = $user_id_sql_result->fetch_assoc()) {
                $user_id_array[] = $user_id_sql_row['user_id'];
            }
        }

        $total_user_id_count = count($user_id_array);
        $per_user_limit = ceil($limit / $total_user_id_count);
        $select_sql = '';
        $update_sql = '';
        for($user_id_counter = 1; $user_id_counter <= $total_user_id_count; $user_id_counter++) {
            $user_id_array_index = $user_id_counter - 1;
            if($user_id_counter == $total_user_id_count) {
                $select_sql .=  "(SELECT * FROM `cron_sms` WHERE `process` = 'remain' AND `user_id` = {$user_id_array[$user_id_array_index]}{$paused_scheduled_sql_text} ORDER BY `cron_sms_id` ASC LIMIT $per_user_limit);";
                $update_sql .= "UPDATE `cron_sms` SET `process` = 'done' WHERE `process` = 'remain' AND `user_id` = {$user_id_array[$user_id_array_index]}{$paused_scheduled_sql_text} ORDER BY `cron_sms_id` ASC LIMIT $per_user_limit;";
            } else {
                $select_sql .=  "(SELECT * FROM `cron_sms` WHERE `process` = 'remain' AND `user_id` = {$user_id_array[$user_id_array_index]}{$paused_scheduled_sql_text} ORDER BY `cron_sms_id` ASC LIMIT $per_user_limit) UNION ";
                $update_sql .= "UPDATE `cron_sms` SET `process` = 'done' WHERE `process` = 'remain' AND `user_id` = {$user_id_array[$user_id_array_index]}{$paused_scheduled_sql_text} ORDER BY `cron_sms_id` ASC LIMIT $per_user_limit;";
            }

        }
        $cron_sms_data_sql = $select_sql.$update_sql;


        // **Execute multi_query and get data from "cron_sms" table
        if ($this->mysqli->multi_query($cron_sms_data_sql)) {
            do {
                /* store first result set */
                if ($cron_sms_data_result = $this->mysqli->store_result()) {
                    while ($cron_sms_data_row = $cron_sms_data_result->fetch_assoc()) {
                        $cron_sms_table[] = array(
                            'cron_sms_id' => $cron_sms_data_row['cron_sms_id'],
                            'bl_tt_masking_id' => $cron_sms_data_row['bl_tt_masking_id'],
                            'gp_masking_id' => $cron_sms_data_row['gp_masking_id'],
                            'robi_masking_id' => $cron_sms_data_row['robi_masking_id'],
                            'to_number' => $cron_sms_data_row['to_number'],
                            'user_id' => $cron_sms_data_row['user_id'],
                            'send_sms_id' => $cron_sms_data_row['send_sms_id']
                        );
                    }
                    $cron_sms_data_result->free();
                }
            } while ($this->mysqli->next_result());
        }


        // Get distinct "send_sms_id" from $cron_sms_table
        foreach($cron_sms_table as $cron_sms_table_single) {
            $distinct_send_sms_id_temp[] = $cron_sms_table_single['send_sms_id'];
        }
        $distinct_send_sms_id_temp = array_unique($distinct_send_sms_id_temp);
        $distinct_send_sms_id = implode(',',$distinct_send_sms_id_temp);

        // **Get data from "send_sms" table
        $send_sms_data_sql = "SELECT * FROM `send_sms` WHERE `send_sms_id` IN ({$distinct_send_sms_id})";
        if ($send_sms_data_result = $this->mysqli->query($send_sms_data_sql)) {

            /* fetch associative array */
            while ($send_sms_data_row = $send_sms_data_result->fetch_assoc()) {
                $send_sms_table[] = array(
                    'send_sms_id' => $send_sms_data_row['send_sms_id'],
                    'message' => $send_sms_data_row['message'],
                    'user_id' => $send_sms_data_row['user_id'],
                    'unicode_sms' => $send_sms_data_row['unicode_sms'],
                    'single_sms_count' => $send_sms_data_row['single_sms_count']
                );
            }

            /* free result set */
            $send_sms_data_result->free();
        }


        // **Get data from "bl_tt_masking" table
        $bl_tt_masking_sql = "SELECT * FROM `bl_tt_masking`";
        if ($bl_tt_masking_result = $this->mysqli->query($bl_tt_masking_sql)) {

            /* fetch associative array */
            while ($bl_tt_masking_row = $bl_tt_masking_result->fetch_assoc()) {
                $bl_tt_masking_table[] = array(
                    'bl_tt_masking_id' => $bl_tt_masking_row['bl_tt_masking_id'],
                    'bl_tt_masking_name' => $bl_tt_masking_row['bl_tt_masking_name'],
                    'default_masking' => $bl_tt_masking_row['default_masking']
                );
            }

            /* free result set */
            $bl_tt_masking_result->free();
        }

        // **Get data from "gp_masking" table
        $gp_masking_sql = "SELECT * FROM `gp_masking`";
        if ($gp_masking_result = $this->mysqli->query($gp_masking_sql)) {

            /* fetch associative array */
            while ($gp_masking_row = $gp_masking_result->fetch_assoc()) {
                $gp_masking_table[] = array(
                    'gp_masking_id' => $gp_masking_row['gp_masking_id'],
                    'gp_masking_name' => $gp_masking_row['gp_masking_name'],
                    'default_masking' => $gp_masking_row['default_masking']
                );
            }

            /* free result set */
            $gp_masking_result->free();
        }

        // **Get data from "robi_masking" table
        $robi_masking_sql = "SELECT * FROM `robi_masking`";
        if ($robi_masking_result = $this->mysqli->query($robi_masking_sql)) {

            /* fetch associative array */
            while ($robi_masking_row = $robi_masking_result->fetch_assoc()) {
                $robi_masking_table[] = array(
                    'robi_masking_id' => $robi_masking_row['robi_masking_id'],
                    'robi_masking_name' => $robi_masking_row['robi_masking_name'],
                    'default_masking' => $robi_masking_row['default_masking']
                );
            }

            /* free result set */
            $robi_masking_result->free();
        }

        // **Get data from "user" table
        $user_sql = "SELECT * FROM `user`";
        if ($user_result = $this->mysqli->query($user_sql)) {

            /* fetch associative array */
            while ($user_row = $user_result->fetch_assoc()) {
                $user_table[] = array(
                    'id' => $user_row['id'],
                    'user_name' => $user_row['user_name'],
                    'password' => $user_row['password'],
                    'user_level' => $user_row['user_level'],
                    'api_011' => $user_row['api_011'],
                    'api_015' => $user_row['api_015'],
                    'api_016' => $user_row['api_016'],
                    'api_017' => $user_row['api_017'],
                    'api_018' => $user_row['api_018'],
                    'api_019' => $user_row['api_019'],
                    'credit' => $user_row['credit'],
                    'gp_masking' => $user_row['gp_masking'],
                    'robi_masking' => $user_row['robi_masking'],
                    'bl_tt_masking' => $user_row['bl_tt_masking']
                );
            }

            /* free result set */
            $user_result->free();
        }

        // **Get data from "customer_api" table
        $customer_api_sql = "SELECT * FROM `customer_api`";
        if ($customer_api_result = $this->mysqli->query($customer_api_sql)) {

            /* fetch associative array */
            while ($customer_api_row = $customer_api_result->fetch_assoc()) {
                $customer_api_table[] = array(
                    'customer_api_id' => $customer_api_row['customer_api_id'],
                    'name' => $customer_api_row['name'],
                    'display_name' => $customer_api_row['display_name'],
                    'api_user_name' => trim($customer_api_row['api_user_name']),
                    'api_password' => trim($customer_api_row['api_password']),
                    'default_api' => $customer_api_row['default_api'],
                    'last_sms_count' => $customer_api_row['last_sms_count'],
                    'api_credit' => $customer_api_row['api_credit']
                );
            }

            /* free result set */
            $customer_api_result->free();
        }

        // Get Credential from "customer_api" table
        $customer_api_gp_index = array_search('grameenphone', array_column($customer_api_table, 'name'));
        $gp_username = $customer_api_table["$customer_api_gp_index"]['api_user_name'];
        $gp_password = $customer_api_table["$customer_api_gp_index"]['api_password'];
        $gp_last_sms_count = $customer_api_table["$customer_api_gp_index"]['last_sms_count'];

        $customer_api_robi_index = array_search('robi', array_column($customer_api_table, 'name'));
        $robi_username = $customer_api_table["$customer_api_robi_index"]['api_user_name'];
        $robi_password = $customer_api_table["$customer_api_robi_index"]['api_password'];
        $robi_last_sms_count = $customer_api_table["$customer_api_robi_index"]['last_sms_count'];

        $customer_api_infobip_index = array_search('infobip', array_column($customer_api_table, 'name'));
        $infobip_username = $customer_api_table["$customer_api_infobip_index"]['api_user_name'];
        $infobip_password = $customer_api_table["$customer_api_infobip_index"]['api_password'];
        $infobip_last_sms_count = $customer_api_table["$customer_api_infobip_index"]['last_sms_count'];

        $customer_api_banglaphone_index = array_search('banglaphone', array_column($customer_api_table, 'name'));
        $banglaphone_username = $customer_api_table["$customer_api_banglaphone_index"]['api_user_name'];
        $banglaphone_password = $customer_api_table["$customer_api_banglaphone_index"]['api_password'];
        $banglaphone_last_sms_count = $customer_api_table["$customer_api_banglaphone_index"]['last_sms_count'];


        // **Creating Main Array to Send SMS
        foreach($cron_sms_table as $cron_sms_table_every) {
            // From "bl_tt_masking" table
            $bl_tt_masking_index_obtain = array_search("{$cron_sms_table_every['bl_tt_masking_id']}", array_column($bl_tt_masking_table, 'bl_tt_masking_id'));
            $bl_tt_masking_name_obtain = $bl_tt_masking_table["$bl_tt_masking_index_obtain"]['bl_tt_masking_name'];
            $bl_tt_default_masking_index_obtain = array_search('yes', array_column($bl_tt_masking_table, 'default_masking'));
            $bl_tt_default_masking_obtain = $bl_tt_masking_table["$bl_tt_default_masking_index_obtain"]['bl_tt_masking_name'];

            // From "gp_masking" table
            $gp_masking_index_obtain = array_search("{$cron_sms_table_every['gp_masking_id']}", array_column($gp_masking_table, 'gp_masking_id'));
            $gp_masking_name_obtain = $gp_masking_table["$gp_masking_index_obtain"]['gp_masking_name'];
            $gp_default_masking_index_obtain = array_search('yes', array_column($gp_masking_table, 'default_masking'));
            $gp_default_masking_obtain = $gp_masking_table["$gp_default_masking_index_obtain"]['gp_masking_name'];

            // From "robi_masking" table
            $robi_masking_index_obtain = array_search("{$cron_sms_table_every['robi_masking_id']}", array_column($robi_masking_table, 'robi_masking_id'));
            $robi_masking_name_obtain = $robi_masking_table["$robi_masking_index_obtain"]['robi_masking_name'];
            $robi_default_masking_index_obtain = array_search('yes', array_column($robi_masking_table, 'default_masking'));
            $robi_default_masking_obtain = $robi_masking_table["$robi_default_masking_index_obtain"]['robi_masking_name'];

            // From "send_sms" table
            $send_sms_index_obtain = array_search("{$cron_sms_table_every['send_sms_id']}", array_column($send_sms_table, 'send_sms_id'));
            $message_obtain = $send_sms_table["$send_sms_index_obtain"]['message'];
            $unicode_sms_obtain = $send_sms_table["$send_sms_index_obtain"]['unicode_sms'];
            $single_sms_count_obtain = $send_sms_table["$send_sms_index_obtain"]['single_sms_count'];

            // From "user" table
            $user_index_obtain = array_search("{$cron_sms_table_every['user_id']}", array_column($user_table,'id'));
            $user_bl_tt_masking_confirm = $user_table["$user_index_obtain"]['bl_tt_masking'];
            $user_gp_masking_confirm = $user_table["$user_index_obtain"]['gp_masking'];
            $user_robi_masking_confirm = $user_table["$user_index_obtain"]['robi_masking'];
            $user_credit_obtain =  $user_table["$user_index_obtain"]['credit'];


            // Storing value to Main Array
            $selected_sms_contain[] = array(
                'cron_sms_id' => $cron_sms_table_every['cron_sms_id'],
                'bl_tt_masking_id' => $cron_sms_table_every['bl_tt_masking_id'],
                'bl_tt_masking_name' => $bl_tt_masking_name_obtain,
                'bl_tt_default_masking' => $bl_tt_default_masking_obtain,
                'user_bl_tt_masking_confirm' => $user_bl_tt_masking_confirm,
                'gp_masking_id' => $cron_sms_table_every['gp_masking_id'],
                'gp_masking_name' => $gp_masking_name_obtain,
                'gp_default_masking' => $gp_default_masking_obtain,
                'user_gp_masking_confirm' => $user_gp_masking_confirm,
                'robi_masking_id' => $cron_sms_table_every['robi_masking_id'],
                'robi_masking_name' => $robi_masking_name_obtain,
                'robi_default_masking' => $robi_default_masking_obtain,
                'user_robi_masking_confirm' => $user_robi_masking_confirm,
                'to_number' => $cron_sms_table_every['to_number'],
                'user_id' => $cron_sms_table_every['user_id'],
                'send_sms_id' => $cron_sms_table_every['send_sms_id'],
                'message' => $message_obtain,
                'unicode_sms' => $unicode_sms_obtain,
                'single_sms_count' => $single_sms_count_obtain,
                'gp_last_sms_count' => $gp_last_sms_count,
                'robi_last_sms_count' => $robi_last_sms_count,
                'infobip_last_sms_count' => $infobip_last_sms_count,
                'banglaphone_last_sms_count' => $banglaphone_last_sms_count,
                'user_credit' => $user_credit_obtain
            );
        }




        $gp_sms_contain = array();
        $robi_sms_contain = array();
        $infobip_sms_contain = array();
        $banglaphone_sms_contain = array();
        $unknown_api_sms_contain = array();
//        echo 'This code is never executed if Remain Process is empty';
        foreach ($selected_sms_contain as $selected_sms_pick) {
            $mobile_operator = $this->operator_identify($selected_sms_pick['to_number']);
            $selected_api_name = $this->api_choose($mobile_operator, $selected_sms_pick['user_id'], $user_table, $customer_api_table);
            $this->mysqli->set_charset('UTF8');
            switch($selected_api_name) {
                case 'grameenphone':
//                    $api_answer = $this->grameenphone_sms_api($cron_sms_id, $sms_to, $sms_message, $send_sms_id);
                    $gp_sms_contain[] = $selected_sms_pick;
                    break;
                case 'robi':
//                    $api_answer = $this->robi_sms_api($cron_sms_id, $sms_to, $sms_message, $send_sms_id);
                    $robi_sms_contain[] = $selected_sms_pick;
                    break;
                case 'infobip':
//                    $api_answer = $this->infobip_sms_api($cron_sms_id, $sms_to, $sms_message, $send_sms_id);
                    $infobip_sms_contain[] = $selected_sms_pick;
                    break;
                case 'banglaphone':
//                    $api_answer = $this->banglaphone_sms_api($cron_sms_id, $sms_to, $sms_message, $send_sms_id);
                    $banglaphone_sms_contain[] = $selected_sms_pick;
                    break;
                default:
//                    $api_answer = 'unknown api';
                    $unknown_api_sms_contain[] = $selected_sms_pick;
            }
        } // End of foreach
//        echo $api_answer;



        // Send sms using Grameenphone Api
        if(count($gp_sms_contain) > 0) {
            $this->grameenphone_sms_api($gp_username, $gp_password, $gp_sms_contain);
        }
        // Send sms using Robi Api
        if(count($robi_sms_contain) > 0) {
            $this->robi_sms_api($robi_username, $robi_password, $robi_sms_contain);
        }
        // Send sms using Infobip Api
        if(count($infobip_sms_contain) > 0) {
            $this->infobip_sms_api($infobip_username, $infobip_password, $infobip_sms_contain);
        }
        // Send sms using Banglaphone Api
        if(count($banglaphone_sms_contain) > 0) {
            $this->banglaphone_sms_api($banglaphone_username, $banglaphone_password, $banglaphone_sms_contain);
        }
        // Log to database for 'Unknown Api'
        if(count($unknown_api_sms_contain) > 0) {
            foreach($unknown_api_sms_contain as $unknown_api_sms_every) {
            $cron_sms_id = trim($unknown_api_sms_every['cron_sms_id']);
            $this->combined_sql .= "UPDATE `cron_sms` SET `api_sms_accepted`='no', `api_used`='unknown' WHERE `cron_sms_id`=\"{$cron_sms_id}\";";
            }
        }
//        echo $this->combined_sql;
        $this->mysqli->multi_query("$this->combined_sql");
    } // End of function

//    public function test_code()
//    {
//    }

}

$cron_sms_obj = new cron_sms_raw();

// This section is for browser.
// $_GET works only with web interface, using a browser
//if(isset($_GET['limit'])) {
//    $limit_var_trim = trim($_GET['limit']);
//    $limit = (int)$limit_var_trim;
//} else {
//    $limit = 1;
//}

// This section is for php command line interface (cli) and for php CRON job
// $argv works with php command line interface (cli) and with php CRON job (CPanel CRON job)
if(isset($argv[1])) {
    $limit_var_trim = trim($argv[1]);
    $limit = (int)$limit_var_trim;
} else {
    $limit = 1;
}

$cron_sms_obj->send_sms($limit);

//$cron_sms_obj->test_code();