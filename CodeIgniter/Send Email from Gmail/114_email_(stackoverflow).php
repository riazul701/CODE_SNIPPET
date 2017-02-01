<?php
// This is Working Example. If email sending problem, then write email address inside double quote.
$ci = get_instance();
$ci->load->library('email');
$config['protocol'] = "smtp";
$config['smtp_host'] = "ssl://smtp.gmail.com";
$config['smtp_port'] = "465";
$config['smtp_user'] = "blablabla@gmail.com"; 
$config['smtp_pass'] = "yourpassword";
$config['charset'] = "utf-8";
$config['mailtype'] = "html";
$config['newline'] = "\r\n";

$ci->email->initialize($config);

$ci->email->from('blablabla@gmail.com', 'Blabla');
$list = array('xxx@gmail.com');
$ci->email->to($list);
$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
$ci->email->subject('This is an email test');
$ci->email->message('It is working. Great!');
$ci->email->send();
