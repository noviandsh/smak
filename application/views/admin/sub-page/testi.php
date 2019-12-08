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
                    echo "<textarea hidden name='' id='testi-".$a['id']."' cols='30' rows='10'>".$a['testimoni']."</textarea>
                        <tr>
                            <td><img class='testi-photo' id='photo-".$a['id']."' src='".base_url('assets/img/alumni/'.thumb($a['photo']))."' alt=''></td>
                            <td>".$name."</td>
                            <td>".$a['year']."</td>
                            <td>".$a['home']."</td>
                            <td>
                                <button class='btn btn-primary btn-xs' data-toggle='modal' data-target='#modal-testi' data-name='".$name."' data-id='".$a['id']."' data-menu='view'>
                                    <i class='fa fa-eye'></i> View
                                </button>
                                <button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#modal-testi' data-name='".$name."' data-id='".$a['id']."' data-menu='edit'>
                                    <i class='fa fa-edit'></i> Edit
                                </button>
                                <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#modal-testi' data-name='".$name."' data-id='".$a['id']."' data-menu='delete'> 
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
                        <label for="edit-title-testi" class="control-label">Judul</label>
                        <input type="text" class="form-control" id="edit-title-testi" name="edit-title-testi">
                        <input  type="text" name="edit-id-testi" id="edit-id-testi">
                    </div>
                    <div class="form-group">
                        <label for="edit-image-testi" class="control-label">Gambar Depan</label> 
                        <button style='display:none' class='cancel-btn btn btn-danger btn-xs' group="testi"> 
                            <i class='fa fa-times'></i> Cancel
                        </button><br>
                        <img id="image-old-testi" src="" alt="" style="max-width: 200px;max-height: 140px;">
                        <input id="edit-image-testi" name="edit-image-testi" type='file' group="testi"/>
                        <input  type="text" name="edit-image-old-testi" id="edit-image-old-testi">
                        <small style="color: #9a9a9a;">Max file size 2MB</small>
                    </div>
                    <div class="form-group">
                        <label for="content-testi" class="control-label">Konten</label>
                        <textarea id="content-testi" name="content-testi" rows="10" cols="80">
                        </textarea>
                    </div>
                </form>
                <!-- delete testi -->
                <form style="display:unset;" action="<?=base_url()?>dataprocess/deletetesti" method="post" id="delete-form">
                    <input type="text"  id="delete-id" name="id">
                    <input type="text"  id="delete-group" name="group">
                    <input type="text"  id="delete-img" name="img">
                </form>
            </div>
            <div class="modal-footer">
                <!-- MODAL FOOTER -->
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button style="display:none;" type="button" id="edit-btn" class="btn btn-primary" group="">Save changes</button>
                <button style="display:none;" type="button" id="delete-btn" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL -->

<script src="<?=base_url('assets/js/jquery-ui.js')?>"></script>
<script src="<?=base_url('assets/js/jquery-ui-timepicker-addon.js')?>"></script>
<!-- CK Editor -->
<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script>
    var firstImg;
    let roxyFileman = '<?=base_url()?>assets/fileman/index.html';
    CKEDITOR.replace('content-testi', {
        filebrowserBrowseUrl: roxyFileman,
        filebrowserImageBrowseUrl: roxyFileman+'?type=image',
        removeDialogTabs: 'link:upload;image:upload'
    });
    CKEDITOR.replace('content-event', {
        filebrowserBrowseUrl: roxyFileman,
        filebrowserImageBrowseUrl: roxyFileman+'?type=image',
        removeDialogTabs: 'link:upload;image:upload'
    });
    CKEDITOR.config.height = '380';

    $('#modal-testi').on('show.bs.modal', function (event){
        // attribute form button
        let button = $(event.relatedTarget); // Button that triggered the modal
        let title = button.data('title'); // Extract info from data-edit attributes
        let id = button.data('id'); // Extract info from data-id attributes
        let menu = button.data('menu'); // Extract info from data-del attributes
        let del = button.data('del'); // Extract info from data-del attributes
        let group = button.data('group');

        let content = $('#'+group+'-'+id).val();
        let modal = $(this);

        if (menu === 'view') 
        {
            // View Modal Open
            modal.find('#testi-content').html(content);
            modal.find('#testi-content').prepend($('<img src="<?=base_url()?>assets/img/'+group+'/'+$('#img-'+group+'-'+id).val()+'"/>').css('max-width','100%'));
        }
        else if(menu === 'edit')
        {
            // Edit Modal Open
            $('#edit-btn').show();
            $('#edit-form-'+group).show();
            modal.find('#edit-title-'+group).val(title);
            modal.find('#edit-id-'+group).val(id);
            title = 'Edit | '+title;
            CKEDITOR.instances['content-'+group].setData(content);
            modal.find('#image-old-'+group).attr('src', '<?=base_url()?>assets/img/'+group+'/'+$('#img-'+group+'-'+id).val());
            modal.find('#edit-image-old-'+group).val($('#img-'+group+'-'+id).val());
            firstImg = $('#image-old-'+group).attr('src');
            modal.find('#edit-btn').attr('group', group);
        }
        else
        {
            // Delete Modal Open
            $('#delete-btn').show();
            title = 'Delete '+title;
            modal.find('#delete-id').val(id);
            modal.find('#delete-group').val(group);
            modal.find('#delete-img').val($('#img-'+group+'-'+id).val());
        }

        modal.find('#testi-title').text(title);
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

    $('#edit-image-event, #edit-image-testi').on('change', function(){
        let group = $(this).attr('group');
        let reader = new FileReader();
        reader.onload = function(e){
            firstImg = $('#image-old-'+group).attr('src');
            $('#image-old-'+group).attr('src', e.target.result);
        }
        try {
            reader.readAsDataURL(this.files[0]);
            $('.cancel-btn').show();
        } catch (error) {
            $('#image-old-'+group).attr('src', firstImg);
            $('.cancel-btn').hide();
        }
    });

    $('.cancel-btn').on('click', function(e){
        let group = $(this).attr('group');
        e.preventDefault();
        $('#edit-image-'+group).val('');
        $('#image-old-'+group).attr('src', firstImg);
        $('.cancel-btn').hide();
    });
    
    $("#edit-btn").click(function(){
        $('#edit-form-'+$(this).attr('group')).submit();
    });
    $("#delete-btn").click(function(){
        $('#delete-form').submit();
    });
    // DATE PICKER FUNCTION
    
    let tgl = new Date();
    tgl.setHours(tgl.getHours()+1);
    $("#start-date").datetimepicker({ 
        minDate: tgl,
        changeMonth: true,
        dateFormat: "yy-mm-dd",
        onSelect: function(date){
            let selectedDate = new Date(date);
            let msecsInADay = 86400000;
            let endDate = new Date(selectedDate.getTime() + msecsInADay);

            //Set Minimum Date of EndDatePicker After Selected Date of StartDatePicker
            $("#end-date").datepicker( "option", "minDate", endDate );
        }
    });
    $("#end-date").datetimepicker({ 
        dateFormat: 'yy-mm-dd',
        changeMonth: true
    });
</script>