<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dataprocess extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->helper(array('form', 'file'));
        $this->load->library('image_lib');
        $this->load->model('crud');
    }
    
    public function login()
    {
        $where = array(
            'username' => $_POST['username'],
            'password' => $_POST['password']
        );
        $data = $this->crud->GetWhere('user', $where);
        if(count($data) > 0){
            $this->session->set_userdata('username', $data[0]['username']);
            redirect(base_url('admin/dashboard'));
        }else{
            $this->session->set_flashdata('error', 'Incorrect Username or Password');
            redirect(base_url('admin'));
        }
    }
    /*
    | -------------------------------------------------------------------------
    | BERANDA
    | -------------------------------------------------------------------------
    */
    public function addImages()
    {   
        // $this->ceklogin();
        $location = $_POST['location'];
        $uploaded = $this->crud->multiUpload($location, 'files');
        
        if ($uploaded['status'] == 1) {
            $newImages = $this->crud->InsertBatch($location, $uploaded['data']);
            $this->session->set_flashdata('success', 'Berhasil Menambahkan Gambar Baru di '.ucfirst($location));
        }else{
            $this->session->set_flashdata('error', 'Gagal Menambahkan Gambar Baru di '.ucfirst($location).$uploaded['error']);
        }
        redirect(base_url('admin/dashboard'));
        
        
    }
}

/* End of file Dataprocess.php */