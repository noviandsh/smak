<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mail extends CI_Model {
    
    public function send($email, $sub, $msg)
    {
        $config['mailtype'] = 'text';
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.smakyossudarsobatu.sch.id';
        $config['smtp_user'] = 'ppdb@smakyossudarsobatu.sch.id';
        $config['smtp_pass'] = 'emailsmakyoss';
        $config['smtp_port'] = 587;
        $config['newline'] = "\r\n";

        $this->load->library('email', $config);

        $this->email->from('ppdb@smakyossudarsobatu.sch.id', 'Panitia PPDB SMAK Yos Sudarso Batu');
        $this->email->to($email);
        $this->email->subject($sub);
        $this->email->message($msg);

        if($this->email->send()) {
            $res = array(
                'code'=> 1,
                'msg'=> 'Email sent successfully'
            );
        }
        else {
            $res = array(
                'code'=> 0,
                'msg'=> $this->email->print_debugger()
            );
        }
        return $res;
    }
}

/* End of file Mail.php */   