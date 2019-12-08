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
    public function editArticle()
    {
        // $this->ceklogin();
        $oldImg = $_POST['edit-image-old-article'];
        $data = array(
            'title' => strtolower($_POST['edit-title-article']),
            'link' => $this->clean($_POST['edit-title-article']),
            'content' => $_POST['content-article']
        );
        // Jika mengganti gambar depan
        if(!empty($_FILES['edit-image-article']['name'])){
            $data['image'] = $_FILES['edit-image-article']['name'];
            $uploaded = $this->crud->pict('article', 'edit-image-article');
            // Jika gambar depan lama bukan blank
            if($oldImg !== 'blank.jpg'){
                $image = $oldImg;
                $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
                $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
                unlink(FCPATH.'assets/img/article/'.$image);
                unlink(FCPATH.'assets/img/article/'.$thumb);
            }
        }
        $update = $this->crud->Update('article', $data, array('id'=>$_POST['edit-id-article']));
        if($update){
            $this->session->set_flashdata('success', 'Artikel Berhasil Diubah');
        }else{
            $this->session->set_flashdata('error', 'Artikel Gagal Diubah');
        }
        redirect(base_url('admin/article'));
    }
    // DELETE ARTIKEL
    public function deleteArticle()
    {
        // $this->ceklogin();
        $id = $_POST['id'];
        $group = $_POST['group'];
        $img = $_POST['img'];
        $delete = $this->crud->Delete($group, array('id' => $id));
        
        if($delete){
            if($img !== 'blank.jpg'){
                $extension_pos = strrpos($img, '.'); // find position of the last dot, so where the extension starts
                $thumb = substr($img, 0, $extension_pos) . '_thumb' . substr($img, $extension_pos);
                unlink(FCPATH.'assets/img/'.$group.'/'.$img);
                unlink(FCPATH.'assets/img/'.$group.'/'.$thumb);
            }
            $this->session->set_flashdata('success', ucfirst($group).' Berhasil Dihapus');
        }else{
            $this->session->set_flashdata('error', ucfirst($group).' Gagal Dihapus');
        }
        redirect(base_url('admin/article'));
    }
    /*
    | -------------------------------------------------------------------------
    | EVENT
    | -------------------------------------------------------------------------
    */
    // TAMBAH ARTIKEL
    public function newEvent()
    {
        // $this->ceklogin();
        
        $data = array(
            'title' => $_POST['title'],
            'link' => $this->clean($_POST['title']),
            'startDate' => $_POST['start-date'],
            'endDate' => $_POST['end-date'],
            'location' => $_POST['location'],
            'description' => $_POST['content']
        );
        $uploaded = $this->crud->pict('event', 'files');
        if ($uploaded['status'] == 1) {
            $data['image'] = $this->upload->data('file_name');
        }
        $insert = $this->crud->Insert('event', $data);
        if($insert){
            $this->session->set_flashdata('success', 'Kegiatan Berhasil Ditambahkan');
        }else{
            $this->session->set_flashdata('error', 'Kegiatan Gagal Ditambahkan');
        }
        redirect(base_url('admin/article'));
    }
    // EDIT ARTIKEL
    public function editEvent()
    {
        // $this->ceklogin();
        $oldImg = $_POST['edit-image-old-event'];
        $data = array(
            'title' => strtolower($_POST['edit-title-event']),
            'link' => $this->clean($_POST['edit-title-event']),
            'startDate' => $_POST['start-date'],
            'endDate' => $_POST['end-date'],
            'location' => $_POST['location'],
            'description' => $_POST['content-event']
        );
        // Jika mengganti gambar depan
        if(!empty($_FILES['edit-image-event']['name'])){
            $data['image'] = $_FILES['edit-image-event']['name'];
            $uploaded = $this->crud->pict('event', 'edit-image-event');
            // Jika gambar depan lama bukan blank
            if($oldImg !== 'blank.jpg'){
                $image = $oldImg;
                $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
                $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
                unlink(FCPATH.'assets/img/event/'.$image);
                unlink(FCPATH.'assets/img/event/'.$thumb);
            }
        }
        $update = $this->crud->Update('event', $data, array('id'=>$_POST['edit-id-event']));
        if($update){
            $this->session->set_flashdata('success', 'Kegiatan Berhasil Diubah');
        }else{
            $this->session->set_flashdata('error', 'Kegiatan Gagal Diubah');
        }
        redirect(base_url('admin/article'));
    }
}

/* End of file Dataprocess.php */