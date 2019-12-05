<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('crud');
        $this->load->helper('form');
        
    }
    
    public function sessionCheck()
    {
        if(empty($this->session->username)){
			redirect(base_url('admin'));
        }
    }
    
    public function index()
    {
        $data['page'] = $this->load->view('admin/login', '', TRUE);
        $data['title'] = "Admin Login";
        $this->load->view('admin', $data);
    }
    public function dashboard()
    {
        $subData['slider'] = $this->crud->Get('slider');
        $subData['gallery'] = $this->crud->Get('gallery');
        $data['content'] = $this->load->view('admin/sub-page/beranda', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }
}

/* End of file Admin.php */
