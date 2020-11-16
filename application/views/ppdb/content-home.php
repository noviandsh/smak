<?php
    echo valid_error('comment', 'warning');
    echo valid_error('ppdb-failed', 'danger');
    echo valid_error('ppdb-success', 'success');
?>
<div class="box box-warning" style="padding:10px;">
    <?php
        switch($profile['status']){
            case 0:
    ?>
                <div class="alert alert-danger" role="alert" style="padding: 10px 20px !important;">
                    <h2>Anda belum melakukan pembayaran</h2>
                    <!-- <h4>Silahkan lakukan pembayaran sesuai dengan informasi yang telah dikirimkan ke Email yang telah didaftarkan. Lalu upload bukti pembayaran dengan menekan tombol dibawah ini.</h4> -->
                </div>
                <div class="alert alert-warning" role="alert" style="padding: 10px 20px !important;">
                    <h4>Silahkan lakukan pembayaran sebesar <big><u><b>Rp. <?=number_format($ppdb['cost'], 0, ".", ".")?></b></u></big> ke rekening berikut:</h4>
                        <?php
                            foreach($bank as $val){
                                echo "<div class='well well-sm' style='color:black;'>
                                        <b>".$val['bank']."</b><br>
                                        ".$val['account']." a/n ".$val['name']."
                                    </div>";
                            }
                        ?>
                    <h4>Lalu upload bukti pembayaran dengan menekan tombol dibawah ini.</h4>
                </div>
                <button data-toggle="modal" data-target="#modal-payment" type="button" class="btn btn-primary">Upload bukti pembayaran</button>

                <!-- modal ppdb -->
                <div data-backdrop="static" data-keyboard="false" class="modal fade" id="modal-payment" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-xs" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Upload bukti pembayaran</h4>
                        </div>
                        <div class="modal-body">
                            <?= form_open_multipart(base_url('dataprocess/payment'), array('id' => 'form-payment'));?>
                                <div class="form-group">
                                    <label for="exampleInputFile">Bukti Pembayaran</label>
                                    <input name="files" type="file" id="exampleInputFile">
                                    <p class="help-block">Pastikan gambar berekstensi .jpg .jpeg .png dan ukuran maksimal 2MB</p>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="button" id="payment-btn" class="btn btn-primary">Upload</button>
                        </div>
                        </div>
                    </div>
                </div>

    <?php
            break;
            case 1:
    ?>
                <div class="alert alert-warning" role="alert" style="padding: 10px 20px !important;">
                    <h2>Pembayaran anda sedang diverifikasi oleh panitia PPDB</h2>
                    <h4>Silahkan tunggu, pembayaran anda sedang dalam proses verifikasi oleh panitia PPDB.</h4>
                </div>
    <?php
            break;
            case 2:
    ?>
                <div class="alert alert-danger" role="alert" style="padding: 10px 20px !important;">
                    <h2>Anda belum mengisi biodata & nilai</h2>
                    <h4>Silahkan mengisi biodata & nilai calon peserta didik dengan menekan tombol dibawah ini.</h4>
                </div>
                <button data-toggle="modal" data-target="#modal-data" type="button" class="btn btn-primary">Isi biodata & nilai</button>

                <!-- modal ppdb -->
                <div data-backdrop="static" data-keyboard="false" class="modal fade" id="modal-data" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel"><b>Biodata & Nilai Calon Peserta Didik</b></h3>
                        </div>
                        <div class="modal-body">
                            <?=valid_error('biodata', 'danger')?>
                            <?= form_open_multipart(base_url('dataprocess/ppdbdata'), array('id' => 'form-data'));?>
                                <div class="well well-sm">
                                    <h4><b>Biodata calon peserta didik</b></h4>
                                    <div class="form-group">
                                        <label for="data-name">Nama lengkap</label>
                                        <input name="data-name" type="text" class="form-control" id="data-name" placeholder="Nama lengkap" value="<?=$this->session->user['name']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="data-nisn">NISN</label>
                                        <input name="data-nisn" type="text" class="form-control" id="data-nisn" placeholder="Nomor induk siswa nasional"  value="<?=$this->session->user['nisn']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="data-jk">Jenis kelamin</label>
                                        <select id="data-jk" data-value="<?=valid_value('data-jk')?>" name="data-jk" class="form-control">
                                            <option disabled selected>Jenis kelamin</option>
                                            <option value="l">Laki-laki</option>
                                            <option value="p">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="data-place">Tempat lahir</label>
                                        <input name="data-place" type="text" class="form-control" id="data-place" placeholder="Tempat lahir" value="<?=valid_value('data-place')?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="data-date">Tanggal lahir</label><br>
                                        <div style="padding-left:0;" class="col-xs-2">
                                            <select name="data-date-day" class="form-control" id="dobday"></select>
                                        </div>
                                        <div style="padding-left:0;" class="col-xs-2">
                                            <select name="data-date-month" class="form-control" id="dobmonth"></select>
                                        </div>
                                        <div style="padding-left:0;" class="col-xs-2">
                                            <select name="data-date-year" class="form-control" id="dobyear"></select>
                                        </div>
                                    </div><br><br>
                                    <div class="form-group">
                                        <label for="data-parent">Nama orang tua/wali</label>
                                        <input name="data-parent" type="text" class="form-control" id="data-parent" placeholder="Nama orang tua/wali" value="<?=valid_value('data-parent')?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="data-address">Alamat (Sesuai KTP)</label>
                                        <textarea name="data-address" placeholder="Alamat" class="form-control" id="data-address" rows="3"><?=valid_value('data-address')?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="data-city">Kota/kabupaten</label>
                                        <input name="data-city" type="text" class="form-control" id="data-city" placeholder="Kota/kabupaten" value="<?=valid_value('data-city')?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="data-school">Asal sekolah</label>
                                        <input name="data-school" type="text" class="form-control" id="data-school" placeholder="Asal sekolah" value="<?=valid_value('data-school')?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="data-nisn">Agama</label>
                                        <select id="data-religion" name="data-religion" class="form-control">
                                            <option disabled selected>Agama</option>
                                            <option value="islam">Islam</option>
                                            <option value="protestan">Protestan</option>
                                            <option value="katolik">Katolik</option>
                                            <option value="hindu">Hindu</option>
                                            <option value="buddha">Buddha</option>
                                            <option value="khonghuca">Khonghucu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="well well-sm">
                                    <h4><b>Nilai rapor semester 6</b></h4>
                                    <div class="form-group">
                                        <label for="data-mat">Matematika</label>
                                        <input name="data-mat" type="number" class="form-control" id="data-mat" placeholder="Nilai matematika" value="<?=valid_value('data-mat')?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="data-bind">Bahasa Indonesia</label>
                                        <input name="data-bind" type="number" class="form-control" id="data-bind" placeholder="Nilai bahasa Indonesia" value="<?=valid_value('data-bind')?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="data-bing">Bahasa Inggris</label>
                                        <input name="data-bing" type="number" class="form-control" id="data-bing" placeholder="Nilai bahasa inggris" value="<?=valid_value('data-bing')?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="data-ipa">IPA</label>
                                        <input name="data-ipa" type="number" class="form-control" id="data-ipa" placeholder="Nilai IPA" value="<?=valid_value('data-ipa')?>">
                                    </div>
                                </div>
                                <div class="well well-sm">
                                    <h4><b>Prestasi</b></h4>
                                    <div class="form-group">
                                        <label for="data-akademik">Prestasi Akademik</label>
                                        <textarea name="data-akademik" placeholder="Akademik" class="form-control" id="data-akademik" rows="3"><?=valid_value('data-akademik')?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="data-non-akademik">Prestasi Non Akademik</label>
                                        <textarea name="data-non-akademik" placeholder="Non Akademik" class="form-control" id="data-non-akademik" rows="3"><?=valid_value('data-non-akademik')?></textarea>
                                    </div>
                                </div>
                                <div class="well well-sm">
                                    <h4><b>Pemilihan Jurusan/Peminatan</b></h4>
                                    <div class="form-group">
                                        <label for="data-option1">Pilihan 1</label>
                                        <input name="data-option1" type="text" class="form-control" id="data-option1" placeholder="Pilihan pertama" value="<?=valid_value('data-option1')?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="data-option2">Pilihan 2</label>
                                        <input name="data-option2" type="text" class="form-control" id="data-option2" placeholder="Pilihan kedua" value="<?=valid_value('data-option2')?>">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="button" id="submit-data-btn" class="btn btn-primary">Kirim</button>
                        </div>
                        </div>
                    </div>
                </div>

    <?php
            break;
            case 3:
    ?>
                <div class="alert alert-warning" role="alert" style="padding: 10px 20px !important;">
                    <h2>Biodata & nilai anda sedang diverifiasi oleh panitia PPDB</h2>
                    <h4>Silahkan tunggu, biodata & nilai anda sedang dalam proses verifikasi oleh panitia PPDB.</h4>
                </div>
    <?php
            break;
            case 4:
    ?>
                <div class="alert alert-success" role="alert" style="padding: 10px 20px !important;">
                    <h2>Pendaftaran PPDB berhasil</h2>
                    <h4>Selamat, pendaftaran anda pada Penerimaan Peserta Didik Baru SMAK Yos Sudarso Batu berhasil.</h4>
                </div>
    <?php
            break;
        }
    ?>
</div>
<div class="box box-success" style="padding:10px;">
    <h4><b>Alur Pendaftaran</b></h4>
    <ul class="list-group">
        <li class="list-group-item list-group-item-danger">
            <div class="ppdb-check">
                <i class="fa fa-check" aria-hidden="true"></i>
            </div>
            1. Lakukan pembayaran pendaftaran PPDB
        </li>
        <li class="list-group-item list-group-item-warning">
            <div class="ppdb-check">
                <i class="fa fa-check" aria-hidden="true"></i>
            </div>
            2. Tunggu verifikasi pembayaran
        </li>
        <li class="list-group-item list-group-item-danger">
            <div class="ppdb-check">
                <i class="fa fa-check" aria-hidden="true"></i>
            </div>
            3. Isikan biodata & nilai calon peserta didik
        </li>
        <li class="list-group-item list-group-item-warning">
            <div class="ppdb-check">
                <i class="fa fa-check" aria-hidden="true"></i>
            </div>
            4. Tunggu verifikasi biodata & nilai
        </li>
        <li class="list-group-item list-group-item-success">
            <div class="ppdb-check">
                <i class="fa fa-check" aria-hidden="true"></i>
            </div>
            5. Pendaftaran PPDB berhasil
        </li>
    </ul>
</div>
<script src="<?=base_url()?>assets/js/dobPicker.js"></script>

<script>
    stats = <?=$profile['status']?>;
    check = $('.ppdb-check');
    // $('.ppdb-check').eq(stats).addClass('done');
    for (i = 0; i < stats; i++) {
        $('.ppdb-check').eq(i).addClass('done');
    }
    if (stats==4) {
        $('.ppdb-check').eq(stats).addClass('done');
    }

    $('#submit-data-btn').click(function(){
        $('#form-data').submit();
    });
    $('#payment-btn').click(function(){
        $('#form-payment').submit();
    });

    if($('.biodata').length>0){
        $('#modal-data').modal();
    }
    
    $.dobPicker({
        // Selectopr IDs
        daySelector:'#dobday',
        monthSelector:'#dobmonth',
        yearSelector:'#dobyear',

        // Default option values
        dayDefault:'Tanggal',
        monthDefault:'Bulan',
        yearDefault:'Tahun',
        
        // Minimum age
        minimumAge: 10,
        
        // Maximum age
        maximumAge: 40
    });
    let select = {
        jk : '#data-jk',
        day : '#dobday',
        month : '#dobmonth',
        year : '#dobyear',
        religion : '#data-religion'
    }
    let option = {
        jk : '<?=valid_value("data-jk")?>',
        day : '<?=valid_value("data-date-day")?>',
        month : '<?=valid_value("data-date-month")?>',
        year : '<?=valid_value("data-date-year")?>',
        religion : '<?=valid_value("data-religion")?>'
    };
    for (let key in option) {
        $(select[key]+" option[value='"+option[key]+"']").attr('selected','selected');
    }
</script>