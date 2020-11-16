<!DOCTYPE html>
<html lang="en">
<head>
    <title>PPDB SMAK Yos Sudarso Batu</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta content='Selamat datang di PPDB SMA Katolik Yos Sudarso Batu' name='description'/>
    <meta content='PPDB, SMA, Katolik, Yos Sudarso, Batu' name='keywords'/>
    <meta content='id' name='geo.country' />

    <meta content='PPDB SMAK Yos Sudarso Batu' property='og:title'/>
    <meta content='website' property='og:type'/>
    <meta content='<?php echo base_url();?>' property='og:url'/>
    <meta content='<?php echo base_url('assets/img/logo.png');?>' property='og:image'/>
    <meta content='Selamat datang di PPDB SMA Katolik Yos Sudarso Batu' property='og:description'/>
    <meta content='Smakyossudarsobatu.sch.id' property='og:site_name'/>
    <meta content='id_ID' property='og:locale'/>
    <meta content='en_GB' property='og:locale:alternate'/>
    <meta content='id_ID' property='og:locale:alternate'/>

    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/all.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/bootstrap.css">   
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/ppdb-style.css">
    <link rel="shortcut icon" type="text/css" href="<?php echo base_url('assets/img/logo.png');?>" >
</head>
<body>
    <div id="navbar">
        <div id="logo"><img class="logo" src="<?=base_url()?>assets/img/logo-lg.png" alt=""></div> <div id="title">PPDB SMAK Yos Sudarso Batu</div>
    </div>
    <div class="scrolling-wrapper">
        <div id="home-section" class="section active">
            <div class="content">
                <!-- <div>
                    <img class="logo" src="<?=base_url()?>assets/img/logo-lg.png" alt="">
                </div> -->
                <div>
                    <h1>
                        <span>PPDB Online</span>
                        <br>
                        <span>SMAK Yos Sudarso Batu</span>
                    </h1>
                    <p>
                        Halaman ini dipersiapkan sebagai pelengkap pusat informasi dan pengolahan seleksi data siswa peserta PPDB SMAK YOS SUDARSO BATU <?=$ppdb['year']?> secara online. Semua informasi mengenai jadwal, formulir serta alur PPDB dapat di cek melalui halaman ini.
                    </p>
                    <br>
                    
                    <?php
                        echo empty($this->session->user)?
                            "<a data-toggle='modal' data-target='#modal-ppdb' class='styled-btn' href='#'>Daftar Sekarang</a>
                            <a data-login='Password' data-toggle='modal' data-target='#modal-login' class='login-btn styled-btn' href='#'>Login Calon Peserta Didik</a>":
                            "<a class='styled-btn' href='".base_url('ppdb/myaccount')."'>Akun saya</a>";
                    ?>
                </div>
            </div>
        </div>
        <div id="flow-section" class="section hidden">
            <div class="content">
                <h1>Alur Pendaftaran</h1>
                <ol class="gradient-list">
                    <?php
                        foreach($flow as $val){
                            echo "<li>".$val['content']."</li>";
                        }
                    ?>
                </ol>
            </div>
        </div>
        <div id="schedule-section" class="section hidden">
            <div class="content">
                <h1>Jadwal PPDB</h1>
                    <div id="schedule-list">
                        <?php
                        foreach($schedule as $val){
                            echo "<div class='schedule-date'><div class='schedule-title'>".$val['title']."</div>".idDate($val['date_start'])." - ".idDate($val['date_end'])."</div>";
                        }
                        ?>
                    </div>
            </div>
        </div>
        <div id="brosur-section" class="section hidden">
            <div class="content">
                <a href="<?=base_url('assets/img/').$ppdb['brosur']?>" target="_blank">
                    <img src="<?=base_url('assets/img/').$ppdb['brosur']?>" alt="">
                </a>
            </div>
        </div>
        <div id="contact-section" class="section hidden">
            <div class="content">
                <h1>Kontak</h1>
                <ul>
                    <?php
                        foreach($contact as $val){
                            echo "<li>".$icon[$val['type']]." ".$val['contact']."</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div id="nav-menu">
            <ul>
                <li class="active">Beranda</li>
                <li>Alur Pendaftaran</li>
                <li>Jadwal</li>
                <li>Brosur</li>
                <li>Kontak</li>
            </ul>
        </div>
    </div>

    <div id="footer">
        <div id="copyright">Copyright © 2019 SMAK Yos Sudarso Batu | Developed by <a href="https://www.doyancoding.com">Doyancoding</a></div>
    </div>
    
    <!-- MODAL -->
    <!-- Modal Registration -->
    <div class="modal fade" id="modal-ppdb" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar PPDB SMAK Yos Sudarso Batu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" role="alert">
                        Pastikan data pendaftaran calon peserta didik baru yang diisikan sesuai dan asli
                    </div>
                    <?=valid_error('reg_validation', 'danger')?>
                    <!-- Modal Daftar Sekarang -->
                    <?= form_open_multipart(base_url('dataprocess/ppdbreg'), array('id' => 'form-reg'));?>
                        <div class="form-group">
                            <label for="reg-name">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="reg-name" id="reg-name" aria-describedby="helpId" placeholder="Nama lengkap calon siswa" value="<?=valid_value('reg-name')?>">
                        </div>
                        <div class="form-group">
                            <label for="reg-nisn">NISN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="reg-nisn" id="reg-nisn" aria-describedby="helpId" placeholder="Nomor induk siswa nasional" value="<?=valid_value('reg-nisn')?>">
                        </div>
                        <div class="form-group">
                            <label for="reg-email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="reg-email" id="reg-email" aria-describedby="emailHelpId" placeholder="Alamat email" value="<?=valid_value('reg-email')?>">
                            <small id="helpId" class="form-text text-muted">Pastikan alamat email aktif untuk menerima informasi pembayaran</small>
                        </div>
                        <div class="form-group">
                            <label for="reg-hp">No. Handphone/WA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="reg-hp" id="reg-hp" aria-describedby="helpId" placeholder="Nomor handphone/whatsapp" value="<?=valid_value('reg-hp')?>">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="check1">
                            <label class="form-check-label" for="check1">
                                Data yang sudah dikirimkan hanya digunakan untuk keperluan penerimaan siswa baru dan data tidak akan dipublikasikan serta dijaga kerahasiaannya oleh Panita PPDB.
                            </label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="check2">
                            <label class="form-check-label" for="check2">
                                Calon peserta didik baru yang sudah mendaftarkan diri melalui PPDB Online SMA Yos Sudarso Batu wajib menyerahkan dokumen atau kelengkapan berkas persyaratan yang sudah ditentukan oleh Panitia PPDB.
                            </label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="check3">
                            <label class="form-check-label" for="check3">
                                Data yang telah diisikan telah sesuai dan asli
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="submit-btn" type="button" class="btn btn-primary">Daftar sekarang</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal fade" id="modal-login" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login Calon Peserta Didik | PPDB SMAK Yos Sudarso Batu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" role="alert">
                        Login dengan Nomor pendaftaran dan Password yang dikirimkan ke email yang digunakan untuk mendaftar PPDB.
                    </div>
                    <?=valid_error('login_validation', 'danger')?>
                    <!-- Modal upload bukti -->
                    <?= form_open_multipart(base_url('dataprocess/ppdblogin'), array('id' => 'form-login'));?>
                        <div class="form-group">
                            <label for="reg-id">Nomor Pendaftaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="reg-id" id="reg-id" aria-describedby="helpId" placeholder="Nomor pendaftaran calon siswa" value="<?=valid_value('reg-id')?>">
                        </div>
                        <div class="form-group">
                            <label for="login-pass">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="login-pass" id="login-pass" aria-describedby="emailHelpId" placeholder="Masukkan Password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="submit-login-btn" type="button" class="btn btn-primary">Masuk</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal fade" id="modal-alert" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">PPDB SMAK Yos Sudarso Batu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <?php
                        if(!empty($this->session->regist)){
                            if($this->session->regist['stat'] == 1){
                                echo '<h3>Pendaftaran Berhasil</h3>
                                    <p>Silahkan cek email anda <u><b>'.$this->session->regist['email'].'</b></u> yang berisikan nomor pendaftaran dan password untuk login akun PPDB SMAK Yos Sudarso Batu.</p>';
                            }else{
                                echo '<h3>Email Sudah Terdaftar</h3>
                                    <p>Akun email <u><b>'.$this->session->regist['email'].'</b></u> sudah terdaftar, silahkan cek inbox email yang berisikan nomor pendaftaran dan password untuk login akun PPDB SMAK Yos Sudarso Batu.</p>
                                    <p>Jika tidak ada email masuk, <a href="">klik disini</a> untuk mengirim ulang.</p>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
	<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery-ui.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.mousewheel.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.magnific-popup.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.js"></script>
    <script src="<?=base_url()?>assets/js/ppdb.js"></script>
</body>
</html>