<?php
    if(isset($_SESSION['success'])){
        echo "<div class='alert alert-success' role='alert'>".$_SESSION['success']."</div>";
    }elseif(isset($_SESSION['error'])){
        echo "<div class='alert alert-danger' role='alert'>".$_SESSION['error']."</div>";
    }
    function thumb($image){
        $extension_pos = strrpos($image, '.'); // find position of the last dot, so where the extension starts
        $thumb = substr($image, 0, $extension_pos) . '_thumb' . substr($image, $extension_pos);
        return $thumb;
    }
?>
<div class="box box-warning">
    <div class="box-inner">
        <h4><b>Manajemen Akun</b></h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Menu</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($account as $a){
                    echo "<tr>
                            <td>".$a['id']."</td>
                            <td id='user-".$a['id']."'>".$a['username']."</td>
                            <td>
                                <button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#modal-account' data-id='".$a['id']."' data-menu='edit'>
                                    <i class='fa fa-edit'></i> Ubah password
                                </button>";
                    if($a['type']){
                        echo    " <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#modal-account' data-id='".$a['id']."' data-menu='delete'> 
                                    <i class='fa fa-trash'></i> Hapus
                                </button>
                            </td>
                        </tr>";
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
    
    <div style="margin-left:10px;">
        <button class="btn btn-primary btn-s" data-toggle='modal' data-target='#modal-account' data-menu='new'>Tambah Akun</button>
    </div><br>
</div>

<!-- MODAL -->
<div class="modal fade" id="modal-account" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- MODAL HEADER -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><b><span id="account-name"></span></b></h4>
                <input hidden type="text">
            </div>
            <div class="modal-body">
                <!-- MODAL BODY -->
                <!-- add account -->
                <?= form_open_multipart(base_url('dataprocess/addaccount'), array('style'=>'display:none;', 'method'=>'POST', 'id'=>'new-form-account')) ?>
                    <div class="form-group">
                        <label for="new-username">Username </label> <span id="new-user-availability-status"></span>
                        <input type="text" name="username" class="form-control" id="new-username" onChange="userCheck('new')">
                    </div>
                    <div class="form-group">
                        <label for="new-password">Password Baru </label> <span id="pass-match-status" style="display:none;" class="label label-danger">Password tidak cocok</span>
                        <input type="password" name="password" class="form-control" id="new-password" onChange="passCheck()">
                    </div>
                    <div class="form-group">
                        <label for="new-repassword">Masukkan Lagi Password Baru</label>
                        <input type="password" name="repassword" class="form-control" id="new-repassword" onChange="passCheck()">
                    </div>
                </form>

                <!-- edit account -->
                <?= form_open_multipart(base_url('dataprocess/editaccount'), array('style'=>'display:none;', 'method'=>'POST', 'id'=>'edit-form-account')) ?>
                    <div id="repassword-check" style="display:none;" class='alert alert-danger' role='alert'>Password Tidak Sama</div>
                    <div class="checkbox">
                        <label>
                            <input id="check-name" name='check-name' type="checkbox"> Ganti username
                        </label><br>
                        <label>
                            <input id="check-pass" name='check-pass' type="checkbox"> Ganti password
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="edit-username">Username </label> <span id="edit-user-availability-status"></span>
                        <input type="text" name="username" class="form-control" id="edit-username" onChange="userCheck('edit')" readonly>
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" name="password" class="form-control" id="password" readonly>
                        <input hidden type="text" name="id" id="id">
                        <input hidden type="text" name="old-username" id="old-username">
                    </div>
                    <div class="form-group">
                        <label for="repassword">Masukkan Lagi Password Baru</label>
                        <input type="password" name="repassword" class="form-control" id="repassword" readonly>
                    </div>
                </form>
                
                <!-- delete account -->
                <form style="display:none;" action="<?=base_url()?>dataprocess/deleteaccount" method="post" id="delete-form">
                    <input type="text"  id="delete-id" name="id">
                    <input type="text" name="username" id="delete-user">
                </form>
            </div>
            <div class="modal-footer">
                <!-- MODAL FOOTER -->
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button disabled style="display:none;" type="button" id="new-btn" class="btn btn-success">Submit</button>
                <button style="display:none;" type="button" id="edit-btn" class="btn btn-primary">Save changes</button>
                <button style="display:none;" type="button" id="delete-btn" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL -->

<!-- CK Editor -->
<script>
    var firstImg;
    $('#modal-account').on('show.bs.modal', function (event){
        // attribute form button
        let button = $(event.relatedTarget); // Button that triggered the modal
        let id = button.data('id'); // Extract info from data-id attributes
        let username = $('#user-'+id).text(); // Extract info from data-edit attributes
        let menu = button.data('menu'); // Extract info from data-del attributes
        let del = button.data('del'); // Extract info from data-del attributes
        let pass = button.data('rev');
        let modal = $(this);

        if (menu === 'view') 
        {
            // View Modal Open
            modal.find('#account-content').html('Password: <b>'+pass+'</b>');
        }
        else if(menu === 'edit')
        {
            // Edit Modal Open
            $('#edit-btn').show();
            $('#edit-form-account').show();
            modal.find('#id').val(id);
            modal.find('#old-username').val(username);
            modal.find('#edit-username').val(username);
            username = 'Edit | '+username;
        }
        else if(menu === 'new')
        {
            // Edit Modal Open
            $('#new-btn').show();
            $('#new-form-account').show();
            username = 'Tambah Akun Baru';
        }
        else
        {
            // Delete Modal Open
            $('#delete-btn').show();
            modal.find('#delete-user').val(username);
            modal.find('#delete-id').val(id);
            username = 'Delete '+username;
        }

        modal.find('#account-name').text(username);
        modal.find('#delete-id').val(id);
        $("#delete-btn").click(function(){
            $('#form-delete').submit();
        });
    });

    $('#modal-account').on('hidden.bs.modal', function (event){
        $('#file-input').val('');
        $('#edit-form-account').hide();
        $('#new-form-account').hide();
        $(this).find('#account-content').html('');
        $('#edit-btn').hide();
        $('#delete-btn').hide();
        $('#new-btn').hide();
    });
    
    $("#edit-btn").click(function(){
        if ($('#password').val() === $('#repassword').val()) {
            $('#repassword-check').hide();
            $('#edit-form-account').submit();
        }else{
            $('#repassword-check').show();
        }
    });
    $("#delete-btn").click(function(){
        $('#delete-form').submit();
    });
    $("#new-btn").click(function(){
        $('#new-form-account').submit();
    });
    function passCheck() {
        let pass = $('#new-password').val();
        let repass = $('#new-repassword').val();
        if(pass !== '' && repass !== ''){
            if(pass == repass){
                console.log('sama');
                $('#new-btn').prop('disabled', false);
                $('#pass-match-status').hide();
            }else{
                console.log('bedo');
                $('#new-btn').prop('disabled', true);
                $('#pass-match-status').show();
            }
        }else{
            $('#new-btn').prop('disabled', true);
            $('#pass-match-status').show();
        }
    }
    $('#check-name').change(function () { 
        $('#edit-username').prop('readonly', !$(this).is(':checked'));
    })
    $('#check-pass').change(function () { 
        $('#password').prop('readonly', !$(this).is(':checked'));
        $('#repassword').prop('readonly', !$(this).is(':checked'));
    })
    function userCheck(form) {
        $.ajax({
            url: "<?=base_url()?>dataprocess/userCheck",
            data:'username='+$("#"+form+"-username").val(),
            type: "POST",
            beforeSend: function () {
                $("#"+form+"-user-availability-status").html("<span class='label label-warning'>Memeriksa ketersediaan username</span>");
            },
            success:function(data){
                $("#"+form+"-user-availability-status").html(data);
            },
            error:function (){}
        });
    }
</script>