<?php

public function send_email($email_to, $email_subject, $email_message) {
        $from_email = 'test@domain-name.com';
        //configure email settings
        $config = Array(
            'mailtype'  => 'html',
            'protocol' => 'smtp',
            'smtp_host' => 'mail.domain-name.com',
            'smtp_port' => 465,
            'smtp_crypto' => 'ssl',
            'smtp_user' => 'test@domain-name.com',
            'smtp_pass' => 'your-password',
            'charset'   => 'utf-8',
            'mailpath' => '/usr/sbin/sendmail',
            'charset'   => 'iso-8859-1',
            'newline'   => "\r\n",
            'wordwrap' => TRUE,
            'smtp_auth' => TRUE
        );
        $this->load->library('email', $config);
        //$this->email->set_mailtype("html");

        //send mail
        $this->email->from($from_email,'Company Name');
        $this->email->to("$email_to");
        $this->email->subject($email_subject);
        $this->email->message($email_message);

        $email_result = $this->email->send();
    }
