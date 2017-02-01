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

    public function send_sms($limit=1) {
        // Do Processing
    } 
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

