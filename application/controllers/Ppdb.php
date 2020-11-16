<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Ppdb extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('crud');
        $this->load->helper('form');
        // $this->load->library('encrypt');
        
        // if(!empty($this->session->username)){
        //     $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        // }
    }

    public function index()
    {
        $data['icon'] = array(
            'wa' => '<i class="fab fa-whatsapp"></i>',
            'phone' => '<i class="fas fa-phone"></i>',
            'email' => '<i class="far fa-envelope"></i>',
            'office' => '<i class="fas fa-fax"></i>',
            'address' => '<i class="fas fa-map-marker-alt"></i>',
            'fb' => '<i class="fab fa-facebook"></i>',
            'yt' => '<i class="fab fa-youtube"></i>',
            'ig' => '<i class="fab fa-instagram"></i>'
        );
        $this->load->helper('form');
        $data['flow'] = $this->crud->Get('flow_ppdb');
        $data['schedule'] = $this->crud->Get('schedule_ppdb');
        $data['ppdb'] = $this->crud->Get('ppdb')[0];
        $data['contact'] = $this->crud->Get('contact_ppdb');
        $this->load->view('ppdb/home', $data);
        // $this->load->model('mail');
        // $email = $this->mail->send('noviandsh@gmail.com', 'lah coba ding', 'lorem adnqwpoqd asd asd asdasdasdas dasdasd');

        // $config['mailtype'] = 'text';
        // $config['protocol'] = 'smtp';
        // $config['smtp_host'] = 'mail.smakyossudarsobatu.sch.id';
        // $config['smtp_user'] = 'ppdb@smakyossudarsobatu.sch.id';
        // $config['smtp_pass'] = 'emailsmakyoss';
        // $config['smtp_port'] = 26;
        // $config['newline'] = "\r\n";

        // $this->load->library('email', $config);

        // $this->email->from('ppdb@smakyossudarsobatu.sch.id', 'Panitia PPDB SMAK Yos Sudarso Batu');
        // $this->email->to('noviandsh@gmail.com');
        // $this->email->subject('lah coba ding');
        // $this->email->message('lorem adnqwpoqd asd asd asdasdasdas dasdasd');

        // if($this->email->send()) {
        //     $res = array(
        //         'code'=> 1,
        //         'msg'=> 'Email sent successfully'
        //     );
        // }
        // else {
        //     $res = array(
        //         'code'=> 0,
        //         'msg'=> $this->email->print_debugger()
        //     );
        // }
        // print_r($res);
    }
    public function myAccount($content='home')
    {
        if(empty($this->session->user)){
            redirect(base_url('ppdb'));
        }
        // print_r($this->session->user);
        $contentData['profile'] = $this->crud->GetWhere('reg_ppdb', array('id'=>$this->session->user['id']))[0];
        $data = $this->crud->GetWhere('data_ppdb', array('id'=>$this->session->user['id']));
        if(!empty($data)){
            $data = $data[0];
        }
        if ($content=='home') {
            $contentData['ppdb'] = $this->crud->Get('ppdb')[0];
            $contentData['bank'] = $this->crud->Get('bank_ppdb');
            if(isset($contentData['profile']['comment'])){
                valid2session('comment', $contentData['profile']['comment']);
                if($data && $contentData['profile']['status'] == 2){
                    $userdata = array(
                        'data-name' => $data['name'],
                        'data-nisn' => $data['nisn'],
                        'data-jk' => $data['sex'],
                        'data-place' => $data['pob'],
                        'data-date-year' => explode('-', $data['dob'])[0],
                        'data-date-month' => explode('-', $data['dob'])[1],
                        'data-date-day' => explode('-', $data['dob'])[2],
                        'data-parent' => $data['parent_name'],
                        'data-address' => $data['address'],
                        'data-city' => $data['city'],
                        'data-school' => $data['school_origin'],
                        'data-religion' => $data['religion'],
                        'data-mat' => $data['mat'],
                        'data-bind' => $data['bind'],
                        'data-bing' => $data['bing'],
                        'data-ipa' => $data['ipa'],
                        'data-akademik' => $data['akademik'],
                        'data-non-akademik' => $data['non_akademik'],
                        'data-option1' => $data['option1'],
                        'data-option2' => $data['option2']
                    );
                    $this->session->set_flashdata('form-data', $userdata);
                }
            }
            // print_r($contentData['profile']);
        }elseif($content=='profile'){
        }elseif($content=='data'){
            $contentData['data'] = $data;
            $contentData['jk'] = array(
                'l'=> 'Laki-laki',
                'p'=> 'Perempuan'
            );
        }
        $data['content'] = $this->load->view('ppdb/content-'.$content, $contentData, TRUE);
        $this->load->view('ppdb/ppdb-dashboard', $data);
    }
}

/* End of file Ppdb.php */
