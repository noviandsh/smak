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
        <h4><b>Testimoni Alumni</b></h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Foto</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alumni</th>
                    <th scope="col">Asal</th>
                    <th scope="col">Menu</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($testi as $a){
                    $name = ucwords($a['name']);
                    echo "<textarea hidden id='testi-".$a['id']."' cols='30' rows='10'>".$a['testimoni']."</textarea>
                        <tr>
                            <td><img class='testi-photo' id='photo-".$a['id']."' src='".base_url('assets/img/alumni/'.thumb($a['photo']))."' alt=''></td>
                            <td>".$name."</td>
                            <td id='year-".$a['id']."'>".$a['year']."</td>
                            <td id='home-".$a['id']."'>".$a['home']."</td>
                            <td>
                                <button class='btn btn-primary btn-xs' data-toggle='modal' data-target='#modal-testi' data-name='".$name."' data-id='".$a['id']."' data-menu='view'>
                                    <i class='fa fa-eye'></i> View
                                </button>
                                <button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#modal-testi' data-photo='".$a['photo']."' data-name='".$name."' data-id='".$a['id']."' data-menu='edit'>
                                    <i class='fa fa-edit'></i> Edit
                                </button>
                                <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#modal-testi' data-photo='".$a['photo']."' data-name='".$name."' data-id='".$a['id']."' data-menu='delete'> 
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
        <a href="<?=base_url()?>admin/newtesti" type="button" class="btn btn-primary btn-s">Tambah Testimoni</a>
    </div><br>
</div>

<!-- MODAL -->
<div class="modal fade" id="modal-testi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- MODAL HEADER -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><b><span id="testi-name"></span></b></h4>
                <input hidden type="text">
            </div>
            <div class="modal-body">
                <!-- MODAL BODY -->
                <!-- view testi -->
                <div id="testi-content">

                </div>
                <!-- edit testi -->
                <?= form_open_multipart(base_url('dataprocess/edittesti'), array('style'=>'display:none;', 'method'=>'POST', 'id'=>'edit-form-testi')) ?>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control" id="name">
                        <input  type="text" name="id" id="id">
                    </div>
                    <div class="form-group">
                        <label for="year">Alumni Tahun</label>
                        <input type="number" name="year" class="form-control" id="year">
                    </div>
                    <div class="form-group">
                        <label for="home">Asal</label>
                        <input type="text" name="home" class="form-control" id="home">
                    </div>
                    <div class="form-group">
                        <label for="image" class="control-label">Foto</label> 
                        <button style='display:none' class='cancel-btn btn btn-danger btn-xs'> 
                            <i class='fa fa-times'></i> Cancel
                        </button><br>
                        <img id="image-old-preview" src="" alt="" style="max-width: 200px;max-height: 140px;">
                        <input id="image" name="image" type='file'/>
                        <input  type="text" name="image-old" id="image-old">
                        <small style="color: #9a9a9a;">Max file size 2MB</small>
                    </div>
                    <div class="form-group testi-textarea">
                        <label for="testi">Testimoni</label>
                        <textarea class="form-control" id="testi" name="testi" rows="3"></textarea>
                    </div>
                </form>
                
                <!-- delete testi -->
                <form style="display:unset;" action="<?=base_url()?>dataprocess/deletetesti" method="post" id="delete-form">
                    <input type="text"  id="delete-id" name="id">
                    <input type="text"  id="delete-img" name="img">
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
    $('#modal-testi').on('show.bs.modal', function (event){
        // attribute form button
        let button = $(event.relatedTarget); // Button that triggered the modal
        let name = button.data('name'); // Extract info from data-edit attributes
        let id = button.data('id'); // Extract info from data-id attributes
        let menu = button.data('menu'); // Extract info from data-del attributes
        let del = button.data('del'); // Extract info from data-del attributes
        let photo = button.data('photo');
        let content = $('#testi-'+id).val();
        let modal = $(this);

        if (menu === 'view') 
        {
            // View Modal Open
            modal.find('#testi-content').html(content);
        }
        else if(menu === 'edit')
        {
            // Edit Modal Open
            $('#edit-btn').show();
            $('#edit-form-testi').show();
            modal.find('#name').val(name);
            modal.find('#id').val(id);
            name = 'Edit | '+name;
            modal.find('#testi').val(content);
            modal.find('#year').val($('#year-'+id).html());
            modal.find('#home').val($('#home-'+id).html());
            modal.find('#image-old-preview').attr('src', $('#photo-'+id).attr('src'));
            modal.find('#image-old').val(photo);
            firstImg = '<?=base_url()?>assets/img/alumni/'+photo;
        }
        else
        {
            // Delete Modal Open
            $('#delete-btn').show();
            name = 'Delete '+name;
            modal.find('#delete-id').val(id);
            modal.find('#delete-img').val(photo);
        }

        modal.find('#testi-name').text(name);
        modal.find('#delete-id').val(id);
        $("#delete-btn").click(function(){
            $('#form-delete').submit();
        });
    });

    $('#modal-testi').on('hidden.bs.modal', function (event){
        $('#file-input').val('');
        $('#edit-form-testi').hide();
        $('#edit-form-event').hide();
        $(this).find('#testi-content').html('');
        $('#edit-btn').hide();
        $('#delete-btn').hide();
    });

    $('#image').on('change', function(){
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
    
    $("#edit-btn").click(function(){
        $('#edit-form-testi').submit();
    });
    $("#delete-btn").click(function(){
        $('#delete-form').submit();
    });
</script>