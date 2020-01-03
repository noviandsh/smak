<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('crud');
        $this->load->helper('form');
        $this->load->library('encrypt');
        
        if(!empty($this->session->username)){
            $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        }
    }
    
    public function sessionCheck($url)
    {
        if(empty($this->session->username)){
			redirect(base_url($url));
        }
    }
    
    public function index()
    {
        if(!empty($this->session->username)){
            redirect(base_url('admin/dashboard'));
        }
        $data['page'] = $this->load->view('admin/login', '', TRUE);
        $data['title'] = "Admin Login";
        $this->load->view('admin', $data);
    }

    public function dashboard()
    {
        $this->sessionCheck('admin');
        
        $this->load->library('pagination');
        $data['val'] = $this->crud->Get('gallery');
        $total = count($data['val']);
        $config = array();
        $config['use_page_numbers'] = TRUE; // Use pagination number for anchor URL.
        $config['num_links'] =  $total;//Set that how many number of pages you want to view.
        $config['cur_tag_open'] = '<a class="current">'; // Open tag for CURRENT link.
        $config['cur_tag_close'] = '</a>'; // Close tag for CURRENT link.
        $config['next_link'] = 'Next'; // By clicking on performing NEXT pagination.
        $config['prev_link'] = 'Previous'; // By clicking on performing PREVIOUS pagination.
        $config['base_url'] = base_url('/admin/dashboard/');
        $config['total_rows'] = $total;
        $config['per_page'] = 18;
        $config['first_url'] = base_url('/admin/dashboard/1'); 
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        if (empty($from)) {
            $from = 1;
        }
        $subData['gallery'] = $this->crud->dataSort('gallery', $config['per_page'], $from, 'id', 'DESC');
        $str_links = $this->pagination->create_links();
        $subData["links"] = explode('&nbsp;',$str_links );
        
        $subData['speech'] = $this->crud->Get('speech');
        $subData['slider'] = $this->crud->Get('slider');
        $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        $data['content'] = $this->load->view('admin/sub-page/beranda', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }

    public function article()
    {
        $this->sessionCheck('admin');
        $this->load->library('pagination');
        // news pagination
        $data['val'] = $this->crud->Get('article');
        $total = count($data['val']);
        $config = array();
        $config['use_page_numbers'] = TRUE; // Use pagination number for anchor URL.
        $config['num_links'] =  $total;//Set that how many number of pages you want to view.
        $config['cur_tag_open'] = '<a class="current">'; // Open tag for CURRENT link.
        $config['cur_tag_close'] = '</a>'; // Close tag for CURRENT link.
        $config['next_link'] = 'Next'; // By clicking on performing NEXT pagination.
        $config['prev_link'] = 'Previous'; // By clicking on performing PREVIOUS pagination.
        $config['base_url'] = base_url('/admin/article/info');
        $config['total_rows'] = $total;
        $config['per_page'] = 10;
        $config['first_url'] = base_url('/admin/article/info/1'); 
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);
        if (empty($from)) {
            $from = 1;
        }
        $subData['article'] = $this->crud->dataSort('article', $config['per_page'], $from, 'id', 'DESC');
        $str_links = $this->pagination->create_links();
        $subData["links"] = explode('&nbsp;',$str_links );

        // event pagination
        $data['val2'] = $this->crud->Get('event');
        $total2 = count($data['val2']);
        $config2 = array();
        $config2['use_page_numbers'] = TRUE; // Use pagination number for anchor URL.
        $config2['num_links'] =  $total2;//Set that how many number of pages you want to view.
        $config2['cur_tag_open'] = '<a class="current">'; // Open tag for CURRENT link.
        $config2['cur_tag_close'] = '</a>'; // Close tag for CURRENT link.
        $config2['next_link'] = 'Next'; // By clicking on performing NEXT pagination.
        $config2['prev_link'] = 'Previous'; // By clicking on performing PREVIOUS pagination.
        $config2['base_url'] = base_url('/admin/article/event/');
        $config2['total_rows'] = $total2;
        $config2['per_page'] = 10;
        $config2['first_url'] = base_url('/admin/article/event/1'); 
        $from2 = $this->uri->segment(4);
        $this->pagination->initialize($config2);
        if (empty($from2)) {
            $from2 = 1;
        }
        $subData['event'] = $this->crud->dataSort('event', $config2['per_page'], $from2, 'id', 'DESC');
        $str_links = $this->pagination->create_links();
        $subData["links2"] = explode('&nbsp;',$str_links );

        // $subData['article'] = $this->crud->Get('article');
        // $subData['event'] = $this->crud->Get('event');
        $subData['popup'] = $this->crud->GetWhere('article', array('popup'=>true));
        $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        $data['content'] = $this->load->view('admin/sub-page/artikel', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }

    public function newArticle()
    {
        $this->sessionCheck('admin');
        $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        $data['content'] = $this->load->view('admin/sub-page/artikel-baru', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }
    public function newEvent()
    {
        $this->sessionCheck('admin');
        $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        $data['content'] = $this->load->view('admin/sub-page/event-baru', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }
    
    public function testi()
    {
        $this->sessionCheck('admin');

        $this->load->library('pagination');
        $data['val'] = $this->crud->Get('testi');
        $total = count($data['val']);
        $config = array();
        $config['use_page_numbers'] = TRUE; // Use pagination number for anchor URL.
        $config['num_links'] =  $total;//Set that how many number of pages you want to view.
        $config['cur_tag_open'] = '<a class="current">'; // Open tag for CURRENT link.
        $config['cur_tag_close'] = '</a>'; // Close tag for CURRENT link.
        $config['next_link'] = 'Next'; // By clicking on performing NEXT pagination.
        $config['prev_link'] = 'Previous'; // By clicking on performing PREVIOUS pagination.
        $config['base_url'] = base_url('/admin/testi/');
        $config['total_rows'] = $total;
        $config['per_page'] = 10;
        $config['first_url'] = base_url('/admin/testi/1'); 
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        if (empty($from)) {
            $from = 1;
        }
        $subData['testi'] = $this->crud->dataSort('testi', $config['per_page'], $from, 'id', 'DESC');
        $str_links = $this->pagination->create_links();
        $subData["links"] = explode('&nbsp;',$str_links );

        $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        $data['content'] = $this->load->view('admin/sub-page/testi', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }
    public function newTesti()
    {
        $this->sessionCheck('admin');
        $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        $data['content'] = $this->load->view('admin/sub-page/testi-baru', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }
    public function account()
    {
        $this->sessionCheck('admin');
        if($this->session->type != 0){
            redirect(base_url('admin/dashboard'));
        }
        $subData['account'] = $this->crud->Get('user');
        $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        $data['content'] = $this->load->view('admin/sub-page/account', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }
    public function activity()
    {
        $this->sessionCheck('admin');
        if($this->session->type != 0){
            redirect(base_url('admin/dashboard'));
        }

        $this->load->library('pagination');
        $data['val'] = $this->crud->Get('user_log');
        $total = count($data['val']);
        $config = array();
        $config['use_page_numbers'] = TRUE; // Use pagination number for anchor URL.
        $config['num_links'] =  $total;//Set that how many number of pages you want to view.
        $config['cur_tag_open'] = '<a class="current">'; // Open tag for CURRENT link.
        $config['cur_tag_close'] = '</a>'; // Close tag for CURRENT link.
        $config['next_link'] = 'Next'; // By clicking on performing NEXT pagination.
        $config['prev_link'] = 'Previous'; // By clicking on performing PREVIOUS pagination.
        $config['base_url'] = base_url('/admin/activity/');
        $config['total_rows'] = $total;
        $config['per_page'] = 15;
        $config['first_url'] = base_url('/admin/activity/1'); 
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        if (empty($from)) {
            $from = 1;
        }
        $subData['log'] = $this->crud->dataSort('user_log', $config['per_page'], $from, 'id', 'DESC');
        $str_links = $this->pagination->create_links();
        $subData["links"] = explode('&nbsp;',$str_links );

        $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        $data['content'] = $this->load->view('admin/sub-page/activity', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }
    public function structure()
    {
        $this->sessionCheck('admin');
        $subData['person'] = $this->crud->Get('structure');
        $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        $data['content'] = $this->load->view('admin/sub-page/structure', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }
    public function ppdb()
    {
        $this->sessionCheck('admin');
        $subData['ppdb'] = $this->crud->Get('ppdb');
        $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        $data['content'] = $this->load->view('admin/sub-page/ppdb', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }
    public function profile()
    {
        $this->sessionCheck('admin');
        $subData['profile'] = $this->crud->Get('profile');
        $subData['admin'] = $this->crud->GetWhere('user', array('username'=>$this->session->username));
        $data['content'] = $this->load->view('admin/sub-page/profile', $subData, TRUE);
        $this->load->view('admin/dashboard', $data);
    }
}

/* End of file Admin.php */
