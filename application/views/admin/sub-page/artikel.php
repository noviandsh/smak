<?php
    if(isset($_SESSION['success'])){
        echo "<div class='alert alert-success' role='alert'>".$_SESSION['success']."</div>";
    }elseif(isset($_SESSION['error'])){
        echo "<div class='alert alert-danger' role='alert'>".$_SESSION['error']."</div>";
    }
?>
<div class="box box-warning">
    <div class="box-inner">
        <h4><b>Berita & Informasi</b></h4>
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Judul</th>
                <th scope="col">Menu</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($article as $a){
                    $title = ucwords($a['title']);
                    echo "<textarea hidden name='' id='content-".$a['id']."' cols='30' rows='10'>".$a['content']."</textarea><input hidden id='image-".$a['id']."'  value='".$a['image']."'/>
                        <tr>
                            <td>".$a['date']."</td>
                            <td>".$title."</td>
                            <td>
                                <button class='btn btn-primary btn-xs' data-toggle='modal' data-target='#modal-article' data-title='".$title."' data-id='".$a['id']."' data-menu='view'>
                                    <i class='fa fa-eye'></i> View
                                </button>
                                <button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#modal-article' data-title='".$title."' data-id='".$a['id']."' data-menu='edit'>
                                    <i class='fa fa-edit'></i> Edit
                                </button>
                                <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#modal-article' data-title='".$title."' data-id='".$a['id']."' data-menu='delete'> 
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
        <a href="<?=base_url()?>admin/newarticle" type="button" class="btn btn-primary btn-s">Tambah Gallery</a>
        <a  type="button" class="btn btn-danger btn-s" data-toggle="modal" data-target="#modal-delete"  data-file="semua" data-del="batch" data-location="gallery">Hapus Semua</a>
    </div><br>
</div>
<div class="box box-danger">
    <div class="box-inner">
        <h4><b>Kegiatan</b></h4>
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Judul</th>
                <th scope="col">Menu</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                </tr>
                <tr>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                </tr>
                <tr>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div style="margin-left:10px;">
        <a data-toggle="modal" data-target="#modal-tambah" data-location="gallery" type="button" class="btn btn-primary btn-s">Tambah Gallery</a>
        <a  type="button" class="btn btn-danger btn-s" data-toggle="modal" data-target="#modal-delete"  data-file="semua" data-del="batch" data-location="gallery">Hapus Semua</a>
    </div><br>
</div>
<!-- MODAL -->
<div class="modal fade" id="modal-article" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- MODAL HEADER -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span id="article-title"></span></h4>
                <input hidden type="text">
            </div>
            <div class="modal-body">
                <!-- MODAL BODY -->
                <div id="article-content">

                </div>
                <?= form_open(base_url('dataprocess/editartikel'), array('style'=>'display:none;', 'method'=>'POST', 'id'=>'edit-form')) ?>
                    <div class="form-group">
                        <label for="title-input" class="control-label">Judul</label>
                        <input type="text" class="form-control" id="title-input" name="title-input">
                        <input type="text" hidden name="id" id="id">
                    </div>
                    <div class="form-group">
                        <label for="image" class="control-label">Gambar Depan</label> 
                        <button style='display:none' class='cancel-btn btn btn-danger btn-xs'> 
                            <i class='fa fa-times'></i> Cancel
                        </button><br>
                        <img id="image" src="" alt="" style="max-width: 200px;max-height: 140px;">
                        <input id="file-input" name="files" type='file' multiple/>
                        <input type="text" name="old-img" id="old-img">
                        <small style="color: #9a9a9a;">Max file size 2MB</small>
                    </div>
                    <div class="form-group">
                        <label for="content-editor" class="control-label">Konten</label>
                        <textarea id="content-editor" name="content-editor" rows="10" cols="80">
                        </textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- MODAL FOOTER -->
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="edit-btn" class="btn btn-primary">Save changes</button>
                <button type="button" id="delete-btn" class="btn btn-primary">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- CK Editor -->
<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script>
    var firstImg;
    let roxyFileman = '<?=base_url()?>assets/fileman/index.html';
    CKEDITOR.replace('content-editor', {
        filebrowserBrowseUrl: roxyFileman,
        filebrowserImageBrowseUrl: roxyFileman+'?type=image',
        removeDialogTabs: 'link:upload;image:upload'
    });
    CKEDITOR.config.height = '380';

    $('#modal-article').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget); // Button that triggered the modal
        let title = button.data('title'); // Extract info from data-edit attributes
        let id = button.data('id'); // Extract info from data-id attributes
        let menu = button.data('menu'); // Extract info from data-del attributes
        let content = $('#content-'+id).val();
        let modal = $(this);
        if (menu === 'view') 
        {
            title = 'View '+title;
            modal.find('#article-content').html(content);
        }
        else if(menu === 'edit')
        {
            modal.find('#title-input').val(title);
            title = 'Edit '+title;
            $('#edit-form').show();
            CKEDITOR.instances['content-editor'].setData(content);
            modal.find('#image').attr('src', '<?=base_url()?>assets/img/article/'+$('#image-'+id).val());
            modal.find('#old-img').val($('#image-'+id).val());
            firstImg = $('#image').attr('src');
        }
        else
        {
            title = 'Delete '+title;
        }

        modal.find('#article-title').text(title);
        modal.find('#delete-id').val(id);
        $("#delete-btn").click(function(){
            $('#form-delete').submit();
        });
    });
    $('#modal-article').on('hidden.bs.modal', function (event){
        $('#file-input').val('');
        $('#edit-form').hide();
        $(this).find('#article-content').html('');
    });
    $('#file-input').on('change', function(){
        let reader = new FileReader();
        reader.onload = function(e){
            firstImg = $('#image').attr('src');
            $('#image').attr('src', e.target.result);
        }
        try {
            reader.readAsDataURL(this.files[0]);
            $('.cancel-btn').show();
        } catch (error) {
            $('#image').attr('src', firstImg);
            $('.cancel-btn').hide();
        }
    });
    $('.cancel-btn').on('click', function(e){
        e.preventDefault();
        $('#file-input').val();
        $('#image').attr('src', firstImg);
        $('.cancel-btn').hide();
    });
    $("#edit-btn").click(function(){
        $('#edit-form').submit();
    });
    $("#delete-btn").click(function(){
        $('#form-delete').submit();
    });
</script>