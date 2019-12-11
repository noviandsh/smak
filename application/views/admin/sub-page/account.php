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
                                    <i class='fa fa-edit'></i> Change
                                </button>
                                <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#modal-account' data-id='".$a['id']."' data-menu='delete'> 
                                    <i class='fa fa-trash'></i> Hapus
                                </button>
                            </td>
                        </tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
    
    <div style="margin-left:10px;">
        <a href="<?=base_url()?>admin/newaccount" type="button" class="btn btn-primary btn-s">Tambah Testimoni</a>
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
                <!-- edit account -->
                <?= form_open_multipart(base_url('dataprocess/changepass'), array('style'=>'display:none;', 'method'=>'POST', 'id'=>'edit-form-account')) ?>
                    <div id="repassword-check" style="display:none;" class='alert alert-danger' role='alert'>Password Tidak Sama</div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" name="password" class="form-control" id="password">
                        <input  type="text" name="id" id="id">
                    <div class="form-group">
                        <label for="repassword">Masukkan Lagi Password Baru</label>
                        <input type="password" name="repassword" class="form-control" id="repassword">
                    </div>
                    </div>
                </form>
                
                <!-- delete account -->
                <form style="display:none;" action="<?=base_url()?>dataprocess/deleteaccount" method="post" id="delete-form">
                    <input type="text"  id="delete-id" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <!-- MODAL FOOTER -->
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
            modal.find('#name').val(username);
            modal.find('#id').val(id);
            username = 'Edit | '+username;
        }
        else
        {
            // Delete Modal Open
            $('#delete-btn').show();
            username = 'Delete '+username;
            modal.find('#delete-id').val(id);
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
        $('#edit-form-event').hide();
        $(this).find('#account-content').html('');
        $('#edit-btn').hide();
        $('#delete-btn').hide();
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
</script>