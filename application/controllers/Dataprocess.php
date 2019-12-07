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
        date_default_timezone_set('Asia/Jakarta');
    }
    
    public function clean($string) {
        $string = strtolower($string);
        $string = trim($string, " ");
           $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
           $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

           return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
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
    
    public function deleteImages()
    {
        // $this->ceklogin();
        $delType = $_POST['jenis'];
        $loc = $_POST['location'];
        if($delType=='batch'){
            $delete = $this->crud->DeleteAll($loc);
            delete_files(FCPATH.'assets/img/'.$loc);
        }else{
            $idDel = $_POST['id'];
            $image = $_POST['filename'];
            $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
            $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
            $delete = $this->crud->Delete($loc, array('id' => $idDel));
            unlink(FCPATH.'assets/img/'.$loc.'/'.$image);
            unlink(FCPATH.'assets/img/'.$loc.'/'.$thumb);
        }
        
        if($delete){
            $this->session->set_flashdata('success', 'Gambar Berhasil Dihapus Dari '.ucfirst($loc));
        }else{
            $this->session->set_flashdata('error', 'Gambar Gagal Dihapus Dari '.ucfirst($loc));
        }
        redirect(base_url('admin/dashboard'));
    }
    /*
    | -------------------------------------------------------------------------
    | ARTIKEL
    | -------------------------------------------------------------------------
    */
    // TAMBAH ARTIKEL
    public function newArticle()
    {
        // $this->ceklogin();
        
        $data = array(
            'title' => $_POST['title'],
            'link' => $this->clean($_POST['title']),
            'date' => date("Y-m-d"),
            'content' => $_POST['content']
        );
        
        $uploaded = $this->crud->pict('article', 'files');
        if ($uploaded['status'] == 1) {
            $data['image'] = $this->upload->data('file_name');
        }
        $insert = $this->crud->Insert('article', $data);
        if($insert){
            $this->session->set_flashdata('success', 'Artikel Berhasil Ditambahkan');
        }else{
            $this->session->set_flashdata('error', 'Artikel Gagal Ditambahkan');
        }
        redirect(base_url('admin/article'));
    }
    // EDIT ARTIKEL
    public function editArtikel()
    {
        // $this->ceklogin();
        $oldImg = $_POST['old-img'];
        $data = array(
            'title' => $_POST['title-input'],
            'link' => $this->clean($_POST['title-input']),
            'content' => $_POST['content-editor']
        );
        // Jika mengganti gambar depan
        if(!empty($_POST['files'])){
            $data['image'] = $_POST['files'];
            
            // Jika gambar depan lama bukan blank
            if($oldImg !== 'blank.jpg'){
                $idDel = $_POST['id'];
                $image = $oldImg;
                $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
                $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
                unlink(FCPATH.'assets/img/article/'.$image);
                unlink(FCPATH.'assets/img/article/'.$thumb);
            }
        };
        $update = $this->crud->Update('article', $data, array('id'=>$_POST['id']));
        if($update){
            $this->session->set_flashdata('success', 'Artikel Berhasil Diubah');
        }else{
            $this->session->set_flashdata('error', 'Artikel Gagal Diubah');
        }
        redirect(base_url('admin/article'));
    }
    // // DELETE ARTIKEL
    // public function deleteArtikel()
    // {
    //     $this->ceklogin();
    //     $idDel = $_POST['id'];
    //     $jenisDel = $_POST['jenis-hapus'];
        
    //     if($jenisDel=='batch'){
    //         $delete = $this->crud->DeleteAll('article');
    //     }else{
    //         $delete = $this->crud->Delete('article', array('id' => $idDel));
    //     }
        
    //     if($delete){
    //         $this->session->set_flashdata('success', 'Artikel Berhasil Dihapus');
    //     }else{
    //         $this->session->set_flashdata('error', 'Artikel Gagal Dihapus');
    //     }
    //     redirect(base_url('admin/artikel'));
    // }
}

/* End of file Dataprocess.php */