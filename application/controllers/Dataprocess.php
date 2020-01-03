<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dataprocess extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->helper(array('form', 'file'));
        $this->load->library(array('image_lib', 'encrypt'));
        $this->load->model('crud');
        date_default_timezone_set('Asia/Jakarta');
        if(empty($this->session->username) && $this->uri->segment(2) != 'login'){
            show_404();
			die();
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
    public function coba()
    {
        echo 'hwhwhw';
    }
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
    
    public function editPpdb()
    {
        $edit = $this->crud->Update('ppdb', array('content'=>$_POST['edit-ppdb']), array('id'=>'1'));
        if($edit){
            $this->activityLog(
                'ubah ppdb',
                'mengubah halaman PPDB'
            );
            $this->session->set_flashdata('success', 'Halaman PPDB berhasil diubah');
        }else{
            $this->session->set_flashdata('error', 'Halaman PPDB gagal diubah');
        }
        redirect(base_url('admin/ppdb'));
    }
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
}

/* End of file Dataprocess.php */