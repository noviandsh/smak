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
        <h4><b>Struktur organisasi</b></h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Foto</th>
                    <th scope="col">Nama</th>
                    <th scope="col">NIP</th>
                    <th scope="col">Posisi</th>
                    <th scope="col">Menu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($person as $a){
                        $name = ucwords($a['name']);
                        echo "<tr>
                                <td><img class='person-photo' id='photo-".$a['id']."' src='".base_url('assets/img/person/'.thumb($a['photo']))."' alt=''></td>
                                <td>".$name."</td>
                                <td id='nip-".$a['id']."'>".$a['nip']."</td>
                                <td id='position-".$a['id']."'>".$a['position']."</td>
                                <td>
                                    <button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#modal-person' data-photo='".$a['photo']."' data-name='".$name."' data-id='".$a['id']."' data-menu='edit'>
                                        <i class='fa fa-edit'></i> Edit
                                    </button> ";
                        if($a['position'] !== 'kepala sekolah'){
                            echo    " <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#modal-person' data-photo='".$a['photo']."' data-name='".$name."' data-id='".$a['id']."' data-menu='delete'> 
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
</div>

<!-- MODAL -->
<div class="modal fade" id="modal-person" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- MODAL HEADER -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><b><span id="person-name"></span></b></h4>
                <input hidden type="text">
            </div>
            <div class="modal-body">
                <!-- MODAL BODY -->
                <!-- edit person -->
                <?= form_open_multipart('#', array('style'=>'display:none;', 'method'=>'POST', 'id'=>'edit-form-person')) ?>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control" id="name">
                        <input hidden type="text" name="id" id="id">
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="number" name="nip" class="form-control" id="nip">
                    </div>
                    <div class="form-group">
                        <label for="position">Jabatan</label>
                        <input type="text" name="position" class="form-control" id="position">
                    </div>
                    <div class="form-group">
                        <label for="image" class="control-label">Foto</label> 
                        <button style='display:none' class='cancel-btn btn btn-danger btn-xs'> 
                            <i class='fa fa-times'></i> Cancel
                        </button><br>
                        <img id="image-old-preview" src="" alt="" style="max-width: 200px;max-height: 140px;">
                        <input id="image" name="image" type='file'/>
                        <input hidden type="text" name="image-old" id="image-old">
                        <small style="color: #9a9a9a;">Max file size 2MB</small>
                    </div>
                </form>
                
                <!-- delete person -->
                <form style="display:none;" action="<?=base_url()?>dataprocess/deleteperson" method="post" id="delete-form">
                    <input type="text"  id="delete-id" name="id">
                    <input type="text"  id="delete-img" name="img">
                </form>
            </div>
            <div class="modal-footer">
                <!-- MODAL FOOTER -->
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button style="display:none;" type="button" id="add-btn" class="btn btn-success">Submit</button>
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
    $('#modal-person').on('show.bs.modal', function (event){
        // attribute form button
        let button = $(event.relatedTarget); // Button that triggered the modal
        let name = button.data('name'); // Extract info from data-edit attributes
        let id = button.data('id'); // Extract info from data-id attributes
        let menu = button.data('menu'); // Extract info from data-del attributes
        let del = button.data('del'); // Extract info from data-del attributes
        let photo = button.data('photo');
        let modal = $(this);

        if(menu === 'edit')
        {
            // Edit Modal Open
            $('#edit-btn').show();
            $('#edit-form-person').show();
            modal.find('#name').val(name);
            modal.find('#id').val(id);
            name = 'Edit | '+name;
            modal.find('#nip').val($('#nip-'+id).html());
            modal.find('#position').val($('#position-'+id).html());
            modal.find('#image-old-preview').attr('src', $('#photo-'+id).attr('src'));
            modal.find('#image-old').val(photo);
            firstImg = '<?=base_url()?>assets/img/person/'+photo;
        }else if(menu === 'add'){
            $('#add-btn').show();
            $('#edit-form-person').show();
            name = 'Tambah struktur organisasi';
        }else
        {
            // Delete Modal Open
            $('#delete-btn').show();
            name = 'Delete '+name;
            modal.find('#delete-id').val(id);
            modal.find('#delete-img').val(photo);
        }

        modal.find('#person-name').text(name);
        modal.find('#delete-id').val(id);
        $("#delete-btn").click(function(){
            $('#form-delete').submit();
        });
    });

    $('#modal-person').on('hidden.bs.modal', function (event){
        $('#file-input').val('');
        $('#edit-form-person').hide();
        $('#edit-btn').hide();
        $('#delete-btn').hide();
    });

    $('#image').on('change', function(){
        console.log(this.files[0].size);
        let reader = new FileReader();
        reader.onload = function(e){
            $('#image-old-preview').attr('src', e.target.result);
        }
        try {
            reader.readAsDataURL(this.files[0]);
            $('.cancel-btn').show();
        } catch (error) {
            $('#image-old-preview').attr('src', firstImg);
            $('.cancel-btn').hide();
        }
    });

    $('.cancel-btn').on('click', function(e){
        e.preventDefault();
        $('#image').val('');
        $('#image-old-preview').attr('src', firstImg);
        $('.cancel-btn').hide();
    });
    
    $("#add-btn").click(function(){
        $('#edit-form-person').attr('action', '<?=base_url()?>dataprocess/addperson')
        $('#edit-form-person').submit();
    });
    $("#edit-btn").click(function(){
        $('#edit-form-person').attr('action', '<?=base_url()?>dataprocess/editperson')
        $('#edit-form-person').submit();
    });
    $("#delete-btn").click(function(){
        $('#delete-form').submit();
    });
</script>