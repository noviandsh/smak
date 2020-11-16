<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Dataprocess extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->helper(array('form', 'file'));
        $this->load->library(array('image_lib', 'form_validation'));
        $this->load->model('crud');
        date_default_timezone_set('Asia/Jakarta');
        // if(empty($this->session->username) && $this->uri->segment(2) != 'login'){
        //     show_404();
		// 	die();
        // }
    }
    
    public function sessionCheck($url)
    {
        if(empty($this->session->username)){
			redirect(base_url($url));
        }
    }
    
    public function clean($string) {
        $string = strtolower($string);
        $string = trim($string, " ");
           $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
           $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

           return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
    public function activityLog($type, $activity)
    {
        $data = array(
            'username' => $this->session->username,
            'date' => date("Y-m-d h:i:s"),
            'type' => $type,
            'activity' => $activity
        );
        $this->crud->Insert('user_log', $data);
    }

    /* 10000071104122
    | -------------------------------------------------------------------------
    | LOGIN
    | -------------------------------------------------------------------------
    */
    // PROSES LOGOUT
    public function logout()
    {
        $this->activityLog(
            'logout',
            'telah logout dari sistem'
        );
        $this->session->sess_destroy();
        redirect(base_url('admin'));
    }

    // PROSES LOGIN
    public function login()
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $getUser = $this->crud->GetWhere('user', array('username'=>$user));
        if(!empty($getUser)){
            if(password_verify($pass, $getUser[0]['password'])){
                $this->session->set_userdata('username', $getUser[0]['username']);
                $this->session->set_userdata('type', $getUser[0]['type']);
                $this->activityLog(
                    'login',
                    'telah login kedalam sistem'
                );
                redirect(base_url('admin/dashboard'));
            }else{
                echo "Password Salah";
            }
        }else{
            echo "Username Salah";
        }
    }

    // PROSES USERNAME TERSEDIA
    public function userCheck()
    {
        $user = $this->crud->GetCountWhere('user', array('username'=>$_POST['username']));
        if($user>0){
            echo "<span class='label label-danger'>Username tidak tersedia</span>";
        }else{
            echo "<span class='label label-success'>Username tersedia</span>";
        }
    }

    // PROSES DAFTAR AKUN BARU
    public function addAccount()
    {
        $user = $_POST['username'];
        $pass = password_hash($_POST['passwoord'], PASSWORD_DEFAULT);
        $regist = $this->crud->Insert('user', array(
            "username"=>$user,
            "password"=>$pass
        ));
        
        if($regist){
            $this->activityLog(
                'tambah akun',
                'menambahkan akun '.$user.' ke sistem'
            );
            $this->session->set_flashdata('success', 'Akun berhasil ditambahkan');
        }else{
            $this->session->set_flashdata('error', 'Akun gagal ditambahkan');
        }
        redirect(base_url('admin/account'));
    }
    // PROSES GANTI PASSWORD DAN USERNAME
    public function editAccount()
    {
        $data = array();
        if(isset($_POST['check-name'])){
            $data['username'] = $_POST['username'];
            $this->activityLog(
                'ubah password',
                'mengubah username '.$_POST['username']
            );
            if($this->session->username == $_POST['old-username']){
                $this->session->set_userdata('username', $_POST['username']);
            }
            $this->crud->Update('article', array(
                'author'=>$_POST['username']
            ), array(
                'author'=>$_POST['old-username']
            ));
            $this->crud->Update('event', array(
                'author'=>$_POST['username']
            ), array(
                'author'=>$_POST['old-username']
            ));
            $this->crud->Update('user_log', array(
                'username'=>$_POST['username']
            ), array(
                'username'=>$_POST['old-username']
            ));
        }
        if(isset($_POST['check-pass'])){
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $data['password'] = $pass;
            $this->activityLog(
                'ubah password',
                'mengubah password '.$_POST['username']
            );
        }
        $change = $this->crud->Update('user', $data, array('id'=>$_POST['id']));
        if($change){
            $this->session->set_flashdata('success', 'Akun berhasil diubah');
        }else{
            $this->session->set_flashdata('error', 'Akun gagal diubah');
        }
        redirect(base_url('admin/account'));
    }
    public function deleteAccount()
    {
        $delete = $this->crud->Delete('user', array('id'=>$_POST['id']));
        if($delete){
            $this->activityLog(
                'hapus akun',
                'menghapus akun '.$_POST['username']
            );
            $this->session->set_flashdata('success', 'Akun berhasil dihapus');
        }else{
            $this->session->set_flashdata('error', 'Akun gagal dihapus');
        }
        redirect(base_url('admin/account'));
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
            $this->activityLog(
                'tambah gambar',
                'menambah gambar '.$location
            );
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
            $this->activityLog(
                'hapus gambar',
                'menghapus semua gambar '.$loc
            );
        }else{
            $idDel = $_POST['id'];
            $image = $_POST['filename'];
            $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
            $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
            $delete = $this->crud->Delete($loc, array('id' => $idDel));
            unlink(FCPATH.'assets/img/'.$loc.'/'.$image);
            unlink(FCPATH.'assets/img/'.$loc.'/'.$thumb);
            $this->activityLog(
                'hapus gambar',
                'menghapus gambar '.$loc
            );
        }
        
        if($delete){
            $this->session->set_flashdata('success', 'Gambar Berhasil Dihapus Dari '.ucfirst($loc));
        }else{
            $this->session->set_flashdata('error', 'Gambar Gagal Dihapus Dari '.ucfirst($loc));
        }
        redirect(base_url('admin/dashboard'));
    }
    
    public function editSpeech()
    {
        $edit = $this->crud->Update('speech', array('content'=>$_POST['edit-speech']), array('id'=>'1'));
        if($edit){
            $this->activityLog(
                'ubah sambutan',
                'mengubah sambutan kepala sekolah'
            );
            $this->session->set_flashdata('success', 'Sambutan berhasil diubah');
        }else{
            $this->session->set_flashdata('error', 'Sambutan gagal diubah');
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
            $this->activityLog(
                'tambah informasi',
                'menambahkan informasi '.$_POST['title']
            );
            $this->session->set_flashdata('success', 'Artikel Berhasil Ditambahkan');
        }else{
            $this->session->set_flashdata('error', 'Artikel Gagal Ditambahkan');
        }
        redirect(base_url('admin/article'));
    }
    // EDIT ARTIKEL
    public function editArticle()
    {
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
            $this->activityLog(
                'ubah informasi',
                'mengubah informasi '.$_POST['edit-title-article']
            );
            $this->session->set_flashdata('success', 'Artikel Berhasil Diubah');
        }else{
            $this->session->set_flashdata('error', 'Artikel Gagal Diubah');
        }
        redirect(base_url('admin/article'));
    }
    // DELETE ARTIKEL
    public function deleteArticle()
    {
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
            
            $this->activityLog(
                'hapus '.$group,
                'menghapus '.$group.' dengan id '.$id
            );
            $this->session->set_flashdata('success', ucfirst($group).' Berhasil Dihapus');
        }else{
            $this->session->set_flashdata('error', ucfirst($group).' Gagal Dihapus');
        }
        redirect(base_url('admin/article'));
    }
    public function setPopup()
    {
        $id = $_POST['id'];
        $removeTrue = $this->crud->Update('article', array('popup'=>false), array('popup'=>true));
        $addPopup = $this->crud->Update('article', array('popup'=>true), array('id'=>$id));
        if($addPopup){
            $this->activityLog(
                'set popup',
                'men-set popup untuk informasi dengan id '.$id
            );
            $this->session->set_flashdata('success', 'Pop-up Berhasil Diubah');
        }else{
            $this->session->set_flashdata('error', 'Pop-up Gagal Diubah');
        }
        redirect(base_url('admin/article'));
    }
    public function removePopup()
    {
        $removeTrue = $this->crud->Update('article', array('popup'=>false), array('popup'=>true));
        if($removeTrue){
            $this->activityLog(
                'unset popup',
                'men-unset popup untuk informasi'
            );
            $this->session->set_flashdata('success', 'Pop-up berhasil dihapus');
        }else{
            $this->session->set_flashdata('error', 'Pop-up gagal dihapus');
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
            $this->activityLog(
                'tambah kegiatan',
                'menambahkan kegiatan '.$_POST['title']
            );
            $this->session->set_flashdata('success', 'Kegiatan Berhasil Ditambahkan');
        }else{
            $this->session->set_flashdata('error', 'Kegiatan Gagal Ditambahkan');
        }
        redirect(base_url('admin/article'));
    }
    // EDIT ARTIKEL
    public function editEvent()
    {
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
            $this->activityLog(
                'ubah kegiatan',
                'mengubah kegiatan '.$_POST['edit-title-event']
            );
            $this->session->set_flashdata('success', 'Kegiatan Berhasil Diubah');
        }else{
            $this->session->set_flashdata('error', 'Kegiatan Gagal Diubah');
        }
        redirect(base_url('admin/article'));
    }

    /*
    | -------------------------------------------------------------------------
    | TESTI
    | -------------------------------------------------------------------------
    */
    // TAMBAH TESTI
    public function newTesti()
    {
        $data = array(
            'name' => $_POST['name'],
            'year' => $_POST['year'],
            'home' => $_POST['home'],
            'testimoni' => $_POST['testi'],
        );
        
        $uploaded = $this->crud->pict('alumni', 'photo');
        if ($uploaded['status'] == 1) {
            $data['photo'] = $this->upload->data('file_name');
        }
        $insert = $this->crud->Insert('testi', $data);
        if($insert){
            $this->activityLog(
                'tambah testimoni',
                'menambahkan testimoni '.$_POST['name']
            );
            $this->session->set_flashdata('success', 'Testimoni Berhasil Ditambahkan');
        }else{
            $this->session->set_flashdata('error', 'Testimoni Gagal Ditambahkan');
        }
        redirect(base_url('admin/testi'));
    }
    // EDIT TESTI
    public function editTesti()
    {
        $oldImg = $_POST['image-old'];
        $data = array(
            'name' => strtolower($_POST['name']),
            'year' => $_POST['year'],
            'home' => $_POST['home'],
            'testimoni' => $_POST['testi']
        );
        // Jika mengganti gambar depan
        if(!empty($_FILES['image']['name'])){
            $data['photo'] = $_FILES['image']['name'];
            $uploaded = $this->crud->pict('alumni', 'image');
            // Jika gambar depan lama bukan blank
            if($oldImg !== 'blank.jpg'){
                $image = $oldImg;
                $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
                $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
                unlink(FCPATH.'assets/img/alumni/'.$image);
                unlink(FCPATH.'assets/img/alumni/'.$thumb);
            }
        }
        $update = $this->crud->Update('testi', $data, array('id'=>$_POST['id']));
        if($update){
            $this->activityLog(
                'ubah testimoni',
                'mengubah testimoni '.$_POST['name']
            );
            $this->session->set_flashdata('success', 'Testimoni Berhasil Diubah');
        }else{
            $this->session->set_flashdata('error', 'Testimoni Gagal Diubah');
        }
        redirect(base_url('admin/testi'));
    }
    // DELETE TESTI
    public function deleteTesti()
    {
        $id = $_POST['id'];
        $img = $_POST['img'];
        $delete = $this->crud->Delete('testi', array('id' => $id));
        
        if($delete){
            if($img !== 'blank.jpg'){
                $extension_pos = strrpos($img, '.'); // find position of the last dot, so where the extension starts
                $thumb = substr($img, 0, $extension_pos) . '_thumb' . substr($img, $extension_pos);
                unlink(FCPATH.'assets/img/alumni/'.$img);
                unlink(FCPATH.'assets/img/alumni/'.$thumb);
            }
            $this->activityLog(
                'hapus testimoni',
                'menghapus testimoni dengan id '.$id
            );
            $this->session->set_flashdata('success', 'Testimoni Berhasil Dihapus');
        }else{
            $this->session->set_flashdata('error', 'Testimoni Gagal Dihapus');
        }
        redirect(base_url('admin/testi'));
    }
    /*
    | -------------------------------------------------------------------------
    | PERSON
    | -------------------------------------------------------------------------
    */
    // TAMBAH PERSON
    public function addPerson()
    {
        $data = array(
            'name' => $_POST['name'],
            'nip' => $_POST['nip'],
            'position' => $_POST['position']
        );
        
        $uploaded = $this->crud->pict('person', 'image');
        if ($uploaded['status'] == 1) {
            $data['photo'] = $this->upload->data('file_name');
        }
        $insert = $this->crud->Insert('structure', $data);
        if($insert){
            $this->activityLog(
                'tambah struktur organisasi',
                'menambahkan struktur organisasi '.$_POST['name']
            );
            $this->session->set_flashdata('success', 'Struktur organisasi berhasil ditambahkan');
        }else{
            $this->session->set_flashdata('error', 'Struktur organisasi gagal ditambahkan');
        }
        redirect(base_url('admin/structure'));
    }
    // EDIT TESTI
    public function editPerson()
    {
        $oldImg = $_POST['image-old'];
        $data = array(
            'name' => $_POST['name'],
            'nip' => $_POST['nip'],
            'position' => $_POST['position']
        );
        // Jika mengganti gambar depan
        if(!empty($_FILES['image']['name'])){
            $uploaded = $this->crud->pict('person', 'image');
            $data['photo'] = $this->upload->data('file_name');
            print_r($uploaded);
            // Jika gambar depan lama bukan blank
            if($oldImg !== 'blank.jpg'){
                $image = $oldImg;
                $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
                $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
                unlink(FCPATH.'assets/img/person/'.$image);
                unlink(FCPATH.'assets/img/person/'.$thumb);
            }
        }
        $update = $this->crud->Update('structure', $data, array('id'=>$_POST['id']));
        if($update){
            $this->activityLog(
                'ubah struktur organisasi',
                'mengubah struktur organisasi '.$_POST['name']
            );
            $this->session->set_flashdata('success', 'Berhasil diubah');
        }else{
            $this->session->set_flashdata('error', 'Gagal diubah');
        }
        redirect(base_url('admin/structure'));
    }
    // DELETE TESTI
    public function deletePerson()
    {
        $id = $_POST['id'];
        $img = $_POST['img'];
        $delete = $this->crud->Delete('structure', array('id' => $id));
        
        if($delete){
            if($img !== 'blank.jpg'){
                $extension_pos = strrpos($img, '.'); // find position of the last dot, so where the extension starts
                $thumb = substr($img, 0, $extension_pos) . '_thumb' . substr($img, $extension_pos);
                unlink(FCPATH.'assets/img/person/'.$img);
                unlink(FCPATH.'assets/img/person/'.$thumb);
            }
            $this->activityLog(
                'hapus struktur organisasi',
                'menghapus struktur organisasi dengan id '.$_POST['id']
            );
            $this->session->set_flashdata('success', 'Struktur organisasi berhasil dihapus');
        }else{
            $this->session->set_flashdata('error', 'Struktur organisasi gagal dihapus');
        }
        redirect(base_url('admin/structure'));
    }
    public function deleteLog()
    {
        $delete = $this->crud->DeleteAll('user_log');
        
        if($delete){
            $this->session->set_flashdata('success', 'Log aktifitas berhasil dihapus');
        }else{
            $this->session->set_flashdata('error', 'Log aktifitas gagal dihapus');
        }
        redirect(base_url('admin/activity'));
    }
    
    // public function editPpdb()
    // {
    //     $edit = $this->crud->Update('ppdb', array('content'=>$_POST['edit-ppdb']), array('id'=>'1'));
    //     if($edit){
    //         $this->activityLog(
    //             'ubah ppdb',
    //             'mengubah halaman PPDB'
    //         );
    //         $this->session->set_flashdata('success', 'Halaman PPDB berhasil diubah');
    //     }else{
    //         $this->session->set_flashdata('error', 'Halaman PPDB gagal diubah');
    //     }
    //     redirect(base_url('admin/ppdb'));
    // }
    public function editProfile()
    {
        $edit = $this->crud->Update('profile', array('content'=>$_POST['edit-profile']), array('id'=>'1'));
        if($edit){
            $this->activityLog(
                'ubah profile',
                'mengubah halaman profile'
            );
            $this->session->set_flashdata('success', 'Halaman profile berhasil diubah');
        }else{
            $this->session->set_flashdata('error', 'Halaman profile gagal diubah');
        }
        redirect(base_url('admin/profile'));
    }

    /*
    | -------------------------------------------------------------------------
    | PPDB
    | -------------------------------------------------------------------------
    */

    // ppdb registration
    
    public function generate_string($strength = 16) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
    
        return $random_string;
    }
    public function ppdbreg()
    {
        $this->db->db_debug = FALSE;
        $count = sprintf("%03d", ($this->crud->GetCount('reg_ppdb')+1));
        $userdata = array(
            'id' => date("ymd").$count,
            'name' => xss($_POST['reg-name']),
            'nisn' => xss($_POST['reg-nisn']),
            'email' => xss($_POST['reg-email']),
            'no' => xss($_POST['reg-hp']),
            'pass' => $this->generate_string(6),
            'reg_date' => date("Y-m-d h:i:s")
        );
    
        $this->form_validation->set_rules('reg-name', 'Nama', 'required|alpha_numeric_spaces',
            array(
                'required' => '{field} wajib diisi',
                'alpha_numeric_spaces' => '{field} hanya dapat berisi huruf, angka dan spasi'
            ));

        $this->form_validation->set_rules('reg-nisn', 'NISN', 'required|numeric',
            array(
                'required' => '{field} wajib diisi',
                'numeric' => '{field} hanya dapat berisi angka'
            ));
            
        $this->form_validation->set_rules('reg-email', 'Email', 'required|valid_email',
            array(
                'required' => '{field} wajib diisi',
                'valid_email' => 'Format {field} tidak valid'
            ));

        $this->form_validation->set_rules('reg-hp', 'No. Handphone', 'required|numeric',
            array(
                'required' => '{field} wajib diisi',
                'numeric' => '{field} hanya dapat berisi angka'
            ));

        // form validation failed
        if ($this->form_validation->run() == FALSE){
            valid2session('reg_validation', validation_errors(), $_POST);
        }else{ // form validation success
            $regist = $this->crud->Insert('reg_ppdb', $userdata);
            $this->session->set_flashdata("regist", array(
                'stat' => $regist['stat'],
                'email' => $userdata['email']
            ));
        }
        redirect(base_url('ppdb'));
    }
    public function ppdblogin()
    {
        $type = xss($_POST['login-type']);
        $id = xss($_POST['reg-id']);
        $pass = xss($_POST['login-pass']);

        $this->form_validation->set_rules('reg-id', 'Nomor pendaftaran', 'required|numeric',
            array(
                'required' => '{field} wajib diisi',
                'numeric' => '{field} hanya dapat berisi angka'
            ));
            
        $this->form_validation->set_rules('login-pass', 'Password', 'required', array(
                'required' => '{field} wajib diisi'
            ));

        if ($this->form_validation->run() == FALSE){
            valid2session('login_validation', validation_errors(), $_POST);
        }else{ // form validation success
            $account = $this->crud->GetWhere('reg_ppdb', array('id'=>$id));
            if($account){
                if($pass == $account[0]['pass']){
                    $this->session->set_userdata('user', $account[0]);
                    redirect('ppdb/myaccount');
                }else{
                    // $this->session->set_flashdata('loginValidation', 'Password yang anda masukkan salah');
                    valid2session('login_validation', 'Password yang anda masukkan salah', $_POST);
                }
            }else{
                // $this->session->set_flashdata('loginValidation', 'No. Pendaftaran yang anda masukkan tidak terdaftar');
                valid2session('login_validation', 'No. Pendaftaran yang anda masukkan tidak terdaftar', $_POST);
            }
        }
        
        redirect(base_url('ppdb'));
    }
    public function ppdbData()
    {
        $userdata = array(
            'id' => $this->session->user['id'],
            'name' => xss($_POST['data-name']),
            'nisn' => xss($_POST['data-nisn']),
            'sex' => xss($_POST['data-jk']),
            'pob' => xss($_POST['data-place']),
            'dob' => xss($_POST['data-date-year'].'-'.$_POST['data-date-month'].'-'.$_POST['data-date-day']),
            'parent_name' => xss($_POST['data-parent']),
            'address' => xss($_POST['data-address']),
            'city' => xss($_POST['data-city']),
            'school_origin' => xss($_POST['data-school']),
            'religion' => xss($_POST['data-religion']),
            'mat' => xss($_POST['data-mat']),
            'bind' => xss($_POST['data-bind']),
            'bing' => xss($_POST['data-bing']),
            'ipa' => xss($_POST['data-ipa']),
            'akademik' => xss($_POST['data-akademik']),
            'non_akademik' => xss($_POST['data-non-akademik']),
            'option1' => xss($_POST['data-option1']),
            'option2' => xss($_POST['data-option2'])
        );
        $validAlphaNumericSpace = array(
            'required' => '{field} wajib diisi',
            'alpha_numeric_spaces' => '{field} hanya dapat berisi huruf, angka dan spasi'
        );
        $validNumeric = array(
            'required' => '{field} wajib diisi',
            'numeric' => '{field} hanya dapat berisi angka'
        );
        // VALIDASI NAMA
        $this->form_validation->set_rules('data-name', 'Nama', 'required|alpha_numeric_spaces', $validAlphaNumericSpace);
        // VALIDASI NISN
        $this->form_validation->set_rules('data-nisn', 'NISN', 'required|numeric', $validNumeric);
        // VALIDASI JENIS KELAMIN
        $this->form_validation->set_rules('data-jk', 'Jenis kelamin', 'required|alpha',
            array(
                'required' => '{field} wajib diisi',
            ));
        // VALIDASI TEMPAT LAHIR
        $this->form_validation->set_rules('data-place', 'Tempat lahir', 'required|alpha_numeric_spaces', $validAlphaNumericSpace);
        // VALIDASI TANGGAL LAHIR
        $this->form_validation->set_rules('data-date-day', 'Tanggal', 'required|numeric', $validNumeric);
        $this->form_validation->set_rules('data-date-month', 'Bulan', 'required|numeric', $validNumeric);
        $this->form_validation->set_rules('data-date-year', 'Tahun', 'required|numeric', $validNumeric);
        // VALIDASI NAMA ORANG TUA
        $this->form_validation->set_rules('data-parent', 'Nama orang tua wali', 'required|alpha_numeric_spaces', $validAlphaNumericSpace);
        // VALIDASI ALAMAT
        $this->form_validation->set_rules('data-address', 'Alamat', 'required|alpha_numeric_spaces', $validAlphaNumericSpace);
        // VALIDASI KOTA
        $this->form_validation->set_rules('data-city', 'Kota kabupaten', 'required|alpha_numeric_spaces', $validAlphaNumericSpace);
        // VALIDASI ASAL SEKOLAH
        $this->form_validation->set_rules('data-school', 'Asal sekolah', 'required|alpha_numeric_spaces', $validAlphaNumericSpace);
        // VALIDASI AGAMA
        $this->form_validation->set_rules('data-religion', 'Agama', 'required|alpha_numeric_spaces', $validAlphaNumericSpace);
        // VALIDASI MATEMATIKA
        $this->form_validation->set_rules('data-mat', 'Nilai Matematika', 'required|numeric', $validNumeric);
        // VALIDASI B INDONESIA
        $this->form_validation->set_rules('data-bind', 'Nilai Bahasa Indonesia', 'required|numeric', $validNumeric);
        // VALIDASI B INGGRIS
        $this->form_validation->set_rules('data-bing', 'Nilai Bahasa Inggris', 'required|numeric', $validNumeric);
        // VALIDASI IPA
        $this->form_validation->set_rules('data-ipa', 'Nilai IPA', 'required|numeric', $validNumeric);
        // VALIDASI AKADEMIK
        $this->form_validation->set_rules('data-akademik', 'Prestasi Akademik', 'required|alpha_numeric_spaces', $validAlphaNumericSpace);
        // VALIDASI NON AKADEMIK
        $this->form_validation->set_rules('data-non-akademik', 'Prestasi Non Akademik', 'required|alpha_numeric_spaces', $validAlphaNumericSpace);
        // VALIDASI PILIHAN 1
        $this->form_validation->set_rules('data-option1', 'Pilihan 1', 'required|alpha_numeric_spaces', $validAlphaNumericSpace);
        // VALIDASI PILIHAN 2
        $this->form_validation->set_rules('data-option2', 'Pilihan 2', 'required|alpha_numeric_spaces', $validAlphaNumericSpace);

        if ($this->form_validation->run() == FALSE){
            valid2session('biodata', validation_errors(), $_POST);
        }else{ // form validation success
            $dataExist = $this->crud->GetWhere('data_ppdb', array('id'=>$userdata['id']));
            if($dataExist){
                $biodata = $this->crud->Update('data_ppdb', $userdata, array('id'=>$userdata['id']));
            }else{
                $biodata = $this->crud->Insert('data_ppdb', $userdata);
            }
            $status = $this->crud->Update('reg_ppdb',
                array(
                    'status' => 3,
                    'data_date' => date("Y-m-d h:i:s"),
                    'comment' => null
                ),
                array(
                    'id' => $this->session->user['id']
                ));
            // $this->session->set_flashdata("regist", array(
            //     'stat' => $regist['stat'],
            //     'email' => $userdata['email']
            // ));
        }
        redirect(base_url('ppdb/myaccount'));
    }
    public function payment()
    {
        $upload = $this->crud->pict('payment', 'files');
        if($upload['status']){
            $dataUpload = $this->crud->Update('reg_ppdb', array(
                    'payment' => $this->upload->data('file_name'),
                    'status' => 1,
                    'pay_date' => date("Y-m-d h:i:s"),
                    'comment' => null
                ),
                array(
                    'id' => $this->session->user['id']
                ));
            if($dataUpload){
                valid2session('ppdb-success', 'Upload bukti pembayaran berhasil');
            }else{
                valid2session('ppdb-failed', 'Upload bukti pembayaran gagal, silahkan ulangi kembali');
            }
        }else{
            valid2session('ppdb-failed', 'Upload bukti pembayaran gagal, silahkan ulangi kembali');
        }
        redirect(base_url('ppdb/myaccount'));
        // print_r($upload);
    }
    
    // PROSES LOGOUTPPDB
    public function ppdblogout()
    {
        $this->session->sess_destroy();
        redirect(base_url('ppdb'));
    }
    public function ppdbpass()
    {
        $change = $this->crud->Update('reg_ppdb', array('pass'=>$_POST['password']), array('id'=>$this->session->user['id']));
        $this->session->set_flashdata('pass-change', 'Password berhasil diubah');
        redirect(base_url('ppdb/myaccount/profile'));        
    }
    public function ppdbtable($where=null)
    {
        if($where){
            $regist = $this->crud->GetWhereIn('reg_ppdb', 'status', explode('-', $where));
        }else{
            $regist = $this->crud->Get('reg_ppdb');
        }
        
        if(empty($this->session->username)){
            echo '404';
        }else{
            echo json_encode(array('data'=>$regist));
        }
    }
    public function ppdbbio($id)
    {
        $sex = array(
            'l'=>'Laki-laki',
            'p'=>'Perempuan'
        );
        $biodata = $this->crud->GetWhere('data_ppdb', array('id'=>$id));
        $biodata[0]['name'] = ucwords($biodata[0]['name']);
        $biodata[0]['sex'] = $sex[$biodata[0]['sex']];
        $biodata[0]['pob'] = ucwords($biodata[0]['pob']);
        $biodata[0]['dob'] = idDate($biodata[0]['dob']);
        $biodata[0]['parent_name'] = ucwords($biodata[0]['parent_name']);
        $biodata[0]['city'] = ucwords($biodata[0]['city']);
        $biodata[0]['religion'] = ucwords($biodata[0]['religion']);
        if(empty($this->session->username)){
            echo '404';
        }else{
            echo json_encode($biodata);
        }
    }
    public function ppdbverify()
    {
        $type = $_POST['type'];
        $status = $_POST['status'];
        $id = $_POST['id'];
        $comment = $_POST['comment'];
        if($type=='payment'){
            if($status=='refuse'){
                $img = $_POST['img'];
                $data = array(
                    'payment'=> null,
                    'status'=> 0,
                    'pay_date'=> null,
                    'comment'=> "Bukti pembayaran ditolak. ".$comment
                );
                $this->session->set_flashdata('ppdb-error', 'Bukti pembayaran dengan No. Pendaftaran '.$id.' berhasil ditolak');
                unlink(FCPATH.'assets/img/payment/'.$img);
                $extension_pos = strrpos($img, '.'); // find position of the last dot, so where the extension starts
                $thumb = substr($img, 0, $extension_pos) . '_thumb' . substr($img, $extension_pos);
                unlink(FCPATH.'assets/img/payment/'.$img);
                unlink(FCPATH.'assets/img/payment/'.$thumb);
            }elseif($status=='accept'){
                $data = array(
                    'status'=>2,
                    'comment'=> "Bukti pembayaran diterima. ".$comment
                );
                $this->session->set_flashdata('ppdb-success', 'Bukti pembayaran dengan No. Pendaftaran '.$id.' berhasil diterima');
            }
        }else if($type=='data'){
            if($status=='refuse'){
                $data = array(
                    'status'=> 2,
                    'data_date'=> null,
                    'comment'=> "Biodata & nilai ditolak. ".$comment
                );
                $this->session->set_flashdata('ppdb-error', 'Biodata & nilai dengan No. Pendaftaran '.$id.' berhasil ditolak');
            }elseif($status=='accept'){
                $data = array(
                    'status'=>4
                );
                $this->session->set_flashdata('ppdb-success', 'Biodata & nilai dengan No. Pendaftaran '.$id.' berhasil diterima');
            }
        }else{
            if($status=='refuse'){
                $data = array(
                    'comment'=> "Permintaan untuk mengubah biodata & nilai ditolak.",
                    'change_data'=>0
                );
                $this->session->set_flashdata('ppdb-error', 'Permintaan ubah biodata & nilai dengan No. Pendaftaran '.$id.' berhasil ditolak');
            }elseif($status=='accept'){
                $data = array(
                    'status'=> 2,
                    'data_date'=> null,
                    'comment'=> "Permintaan untuk mengubah biodata & nilai disetujui.",
                    'change_data'=>0
                );
                $this->session->set_flashdata('ppdb-success', 'Permintaan ubah biodata & nilai dengan No. Pendaftaran '.$id.' berhasil diterima');
            }
        }
        // print_r($type);
        $this->crud->Update('reg_ppdb', $data, array('id'=>$id));
        // redirect(base_url('admin/ppdb'));

    }
    public function ppdbdelete(){
        $id = explode(',', $_POST['deleteID']);
        // $id = array();
        // foreach($_POST['id'] as $x){
        //     array_push($id, $x);
        // }
        print_r($id);
        $delete = $this->crud->DeleteBatch('reg_ppdb', 'id', $id);
        $this->crud->DeleteBatch('data_ppdb', 'id', $id);
        $this->session->set_flashdata('ppdb-success', 'Berhasil menghapus data yang dipilih');
        redirect(base_url('admin/ppdb'));
    }
    public function ppdbrequestchange(){
        $id = $this->session->user['id'];
        $update = $this->crud->Update('reg_ppdb', array('comment'=>null,'change_data'=>1), array('id'=>$id));
        redirect(base_url('ppdb/myaccount/data'));
    }
    public function exporttoxls()
    {
        $sex = array(
            'l'=>'Laki-laki',
            'p'=>'Perempuan'
        );
        $column = "A";
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        for($i=$column;$column <= "V";$column++){
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        $sheet->getStyle('A1:V2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('O1:R1');
        $sheet->mergeCells('S1:T1');
        $sheet->mergeCells('U1:V1');
        $sheet->setCellValue('A1', 'Biodata calon peserta didik');
        $sheet->setCellValue('O1', 'Nilai rapor semester 6');
        $sheet->setCellValue('S1', 'Prestasi');
        $sheet->setCellValue('U1', 'Pemilihan jurusan/peminatan');

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'No. Pendaftaran');
        $sheet->setCellValue('C2', 'Nama');
        $sheet->setCellValue('D2', 'NISN');
        $sheet->setCellValue('E2', 'Email');
        $sheet->setCellValue('F2', 'No. Handphone');
        $sheet->setCellValue('G2', 'Jenis kelamin');
        $sheet->setCellValue('H2', 'Tempat lahir');
        $sheet->setCellValue('I2', 'Tanggal Lahir');
        $sheet->setCellValue('J2', 'Nama Orang Tua/Wali');
        $sheet->setCellValue('K2', 'Alamat');
        $sheet->setCellValue('L2', 'Kota/kabupaten');
        $sheet->setCellValue('M2', 'Asal sekolah');
        $sheet->setCellValue('N2', 'Agama');
        $sheet->setCellValue('O2', 'Matematika');
        $sheet->setCellValue('P2', 'B. Indonesia');
        $sheet->setCellValue('Q2', 'B. Inggris');
        $sheet->setCellValue('R2', 'IPA');
        $sheet->setCellValue('S2', 'Akademik');
        $sheet->setCellValue('T2', 'Non-akademik');
        $sheet->setCellValue('U2', 'Pilihan 1');
        $sheet->setCellValue('V2', 'Pilihan 2');
        
        $ppdbData = $this->crud->Get('data_ppdb');
        $ppdbProfile = $this->crud->Get('reg_ppdb');
        $no = 1;
        $x = 3;
        foreach($ppdbData as $data)
        {
            $sheet->setCellValue('A'.$x, $no++);
            foreach($ppdbProfile as $profile){
                if($profile['id']==$data['id']){
                    $sheet->setCellValue('B'.$x, $profile['id']);
                    $sheet->setCellValue('C'.$x, $profile['name']);
                    $sheet->setCellValue('D'.$x, $profile['nisn']);
                    $sheet->setCellValue('E'.$x, $profile['email']);
                    $sheet->setCellValue('F'.$x, $profile['no']);
                }
                $sheet->setCellValue('G'.$x, $sex[$data['sex']]);
                $sheet->setCellValue('H'.$x, $data['pob']);
                $sheet->setCellValue('I'.$x, idDate($data['dob']));
                $sheet->setCellValue('J'.$x, $data['parent_name']);
                $sheet->setCellValue('K'.$x, $data['address']);
                $sheet->setCellValue('L'.$x, $data['city']);
                $sheet->setCellValue('M'.$x, $data['school_origin']);
                $sheet->setCellValue('N'.$x, $data['religion']);
                $sheet->setCellValue('O'.$x, $data['mat']);
                $sheet->setCellValue('P'.$x, $data['bind']);
                $sheet->setCellValue('Q'.$x, $data['bing']);
                $sheet->setCellValue('R'.$x, $data['ipa']);
                $sheet->setCellValue('S'.$x, $data['akademik']);
                $sheet->setCellValue('T'.$x, $data['non_akademik']);
                $sheet->setCellValue('U'.$x, $data['option1']);
                $sheet->setCellValue('V'.$x, $data['option2']);
            }
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data-PPDB_'.date("Y-m-d");
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function ppdbadd($table)
    {
        $p = $_POST;
        $tableName = array(
            'bank'=> 'Rekening bank',
            'flow'=> 'Alur pendaftaran',
            'schedule'=> 'Jadwal',
            'contact'=> 'Kontak'
        );
        switch ($table) {
            case 'bank':
                $data = array(
                    'bank'=> $p['add-bank-name'],
                    'name'=> $p['add-name'],
                    'account'=> $p['add-account']
                );
                break;
            case 'flow':
                $data = array(
                    'content'=> $p['add-flow']
                );
                break;
            case 'schedule':
                $data = array(
                    'title'=> $p['add-title'],
                    'date_start'=> $p['add-start-date'],
                    'date_end'=> $p['add-end-date']
                );
                break;
            case 'contact':
                $data = array(
                    'type'=> $p['add-type'],
                    'contact'=> $p['add-contact']
                );
                break;
            
            default:
                echo '404';
                break;
        }
        $insert = $this->crud->Insert($table.'_ppdb', $data);
        if($insert){
            $this->session->set_flashdata('ppdb-success', 'Berhasil menambahkan '.$tableName[$table].' baru');
        }
        redirect(base_url('admin/ppdbpage'));
    }
    public function editppdb($table, $id)
    {
        $p = $_POST;
        $tableName = array(
            'bank'=> 'Rekening bank',
            'flow'=> 'Alur pendaftaran',
            'schedule'=> 'Jadwal',
            'contact'=> 'Kontak'
        );
        switch ($table) {
            case 'bank':
                $data = array(
                    'bank'=> $p['change-bank'],
                    'name'=> $p['change-name'],
                    'account'=> $p['change-account']
                );
                break;
            case 'flow':
                $data = array(
                    'content'=> $p['edit-flow']
                );
                break;
            case 'schedule':
                $data = array(
                    'title'=> $p['change-title'],
                    'date_start'=> $p['change-start-date'],
                    'date_end'=> $p['change-end-date']
                );
                break;
            case 'contact':
                $data = array(
                    'type'=> $p['add-type'],
                    'contact'=> $p['change-contact']
                );
                break;
            case 'year':
                $update = $this->crud->Update('ppdb', array('year'=>$p['year1'].'/'.$p['year2']), array('id'=>$id));
                if($update){
                    $this->session->set_flashdata('ppdb-success', 'Berhasil mengubah tahun ajar');
                }
                redirect(base_url('admin/ppdbpage'));
                exit();
                break;
            case 'brosur':
                $upload = $this->crud->pict('', 'files');
                $data = array(
                    'brosur' => $this->upload->data('file_name')
                );
                $update = $this->crud->Update('ppdb', $data, array('id'=>1));
                
                if($update){
                    $this->session->set_flashdata('ppdb-success', 'Berhasil mengubah brosur');
                }
                redirect(base_url('admin/ppdbpage'));
                exit();
                break;
            case 'cost':
                $update = $this->crud->Update('ppdb', array('cost'=>$p['change-cost']), array('id'=>1));
                if($update){
                    $this->session->set_flashdata('ppdb-success', 'Berhasil mengubah biaya pendaftaran');
                }
                redirect(base_url('admin/ppdbpage'));
                exit();
                break;
            default:
                echo '404';
                break;
        }
        $update = $this->crud->Update($table.'_ppdb', $data, array('id'=>$id));
        if($update){
            $this->session->set_flashdata('ppdb-success', 'Berhasil mengubah '.$tableName[$table]);
        }
        redirect(base_url('admin/ppdbpage'));
    }
    public function deleteppdb($table, $id)
    {
        $tableName = array(
            'bank'=> 'Rekening bank',
            'flow'=> 'Alur pendaftaran',
            'schedule'=> 'Jadwal',
            'contact'=> 'Kontak'
        );
        $delete = $this->crud->Delete($table.'_ppdb', array('id'=>$id));
        $this->session->set_flashdata('ppdb-success', 'Berhasil menghapus '.$tableName[$table]);
        redirect(base_url('admin/ppdbpage'));
    }
}

/* End of file Dataprocess.php */