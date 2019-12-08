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

    public function article()
    {
        $subData['article'] = $this->crud->Get('article');
        $subData['event'] = $this->crud->Get('event');
        $data['content'] = $this->load->view('admin/sub-page/artikel', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }

    public function newArticle()
    {
        $data['content'] = $this->load->view('admin/sub-page/artikel-baru', '', TRUE);
        $this->load->view('admin/dashboard', $data);
    }
    public function newEvent()
    {
        $data['content'] = $this->load->view('admin/sub-page/event-baru', '', TRUE);
        $this->load->view('admin/dashboard', $data);
    }
    
    public function testi()
    {
        $subData['testi'] = $this->crud->Get('testi');
        $data['content'] = $this->load->view('admin/sub-page/testi', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }
    public function newTesti()
    {
        $data['content'] = $this->load->view('admin/sub-page/testi-baru', '', TRUE);
        $this->load->view('admin/dashboard', $data);
    }
}

/* End of file Admin.php */
