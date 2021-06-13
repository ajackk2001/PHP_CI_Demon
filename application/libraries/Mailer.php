<?php

class Mailer
{
    public function __construct()
    {
        $this->CI 	            =	& get_instance();
        $this->CI->load->model('Mail_model');
        $this->CI->load->helper('string');
        $this->MailInfo         =   $this->CI->Mail_model->get(['id'=>1])[0];
        $this->mail             =   new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->SMTPAuth   =   true;
        $this->mail->SMTPSecure =   $this->MailInfo->port_type;
        $this->mail->Host       =   $this->MailInfo->host;
        $this->mail->Port       =   $this->MailInfo->port;
        $this->mail->CharSet    =   'utf8';
        $this->mail->Username   =   $this->MailInfo->username;
        $this->mail->Password   =   $this->MailInfo->password;
        $this->mail->setFrom($this->MailInfo->username,$this->MailInfo->from_to);
    }
  
}

?>