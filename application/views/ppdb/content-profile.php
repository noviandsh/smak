<?=valid_error('pass-change', 'success')?>
<div class="box box-success" style="padding:10px;">
    <h4><b>Data diri calon peserta didik</b></h4>
    <table id="myTable" class="custom display table table-bordered table-hover">
        <tr>
            <th>No. Pendaftaran</th>
            <td><?=$profile['id']?></td>
        </tr>
        <tr>
            <th>Nama</th>
            <td><?=$profile['name']?></td>
        </tr>
        <tr>
            <th>NISN</th>
            <td><?=$profile['nisn']?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?=$profile['email']?></td>
        </tr>
        <tr>
            <th>No. Handphone</th>
            <td><?=$profile['no']?></td>
        </tr>
        <tr>
            <th>Bukti Pembayaran</th>
            <td><?php echo $profile['payment'] ? 
            '<a class="popup-link" href="'.base_url('assets/img/payment/').$profile['payment'].'"><img src="'.base_url('assets/img/payment/').$profile['payment'].'"></a>' : 
            '<button type="button" class="btn btn-warning btn-xs">Upload bukti pembayaran</button>';?></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><button data-toggle="modal" data-target="#modal-password"  type='button' class='btn btn-warning btn-xs'>Ubah password</button></td>
        </tr>
    </table>
</div>

<!-- modal ppdb -->
<div data-backdrop="static" data-keyboard="false" class="modal fade" id="modal-password" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Ubah password</h4>
        </div>
        <div class="modal-body">
                <?= form_open_multipart(base_url('dataprocess/ppdbpass'), array('method'=>'POST', 'id'=>'form-pass')) ?>
                    <div class="form-group">
                        <label for="new-password">Password Baru </label> <span id="pass-match-status" style="display:none;" class="label label-danger">Password tidak cocok</span>
                        <input type="password" name="password" class="form-control" id="new-password" onChange="passCheck()">
                    </div>
                    <div class="form-group">
                        <label for="new-repassword">Masukkan Lagi Password Baru</label>
                        <input type="password" name="repassword" class="form-control" id="new-repassword" onChange="passCheck()">
                    </div>
                </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" id="pass-btn" class="btn btn-primary" disabled>Ubah</button>
        </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>assets/DataTables/datatables.min.js"></script>
<script src="<?php echo base_url('assets/js/jquery.magnific-popup.js'); ?>"></script>
<script>
    $('.popup-link').magnificPopup({
        type: 'image',
        // other options
    });
    $('#pass-btn').click(function(){
        $('#form-pass').submit();
    });
    
    function passCheck() {
        let pass = $('#new-password').val();
        let repass = $('#new-repassword').val();
        if(pass !== '' && repass !== ''){
            if(pass == repass){
                console.log('sama');
                $('#pass-btn').prop('disabled', false);
                $('#pass-match-status').hide();
            }else{
                console.log('bedo');
                $('#pass-btn').prop('disabled', true);
                $('#pass-match-status').show();
            }
        }else{
            $('#pass-btn').prop('disabled', true);
            $('#pass-match-status').show();
        }
    }
</script>