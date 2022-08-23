<?php
// There is problem with this example
$from_email = 'test-mail@gmail.com';
$subject = 'Invoice';
$message="$homepage";
//configure email settings
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.gmail.com'; //smtp host name
$config['smtp_port'] = '465'; //smtp port number
$config['smtp_user'] = $from_email;
$config['smtp_pass'] = 'ripon104205'; //$from_email password
$config['mailtype'] = 'html';
$config['charset'] = 'iso-8859-1';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n"; //use double quotes
$this->email->initialize($config);
