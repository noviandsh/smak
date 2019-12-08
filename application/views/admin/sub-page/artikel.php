<?php
    if(isset($_SESSION['success'])){
        echo "<div class='alert alert-success' role='alert'>".$_SESSION['success']."</div>";
    }elseif(isset($_SESSION['error'])){
        echo "<div class='alert alert-danger' role='alert'>".$_SESSION['error']."</div>";
    }
    function dateSplit($date){
        $dates = explode(" ", $date);
        
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
                    echo "<textarea hidden name='' id='article-".$a['id']."' cols='30' rows='10'>".$a['content']."</textarea><input hidden id='img-article-".$a['id']."'  value='".$a['image']."'/>
                        <tr>
                            <td>".date("j F, Y", strtotime($a['date']))."</td>
                            <td>".$title."</td>
                            <td>
                                <button class='btn btn-primary btn-xs' data-toggle='modal' data-target='#modal-article' data-title='".$title."' data-id='".$a['id']."' data-menu='view' data-group='article'>
                                    <i class='fa fa-eye'></i> View
                                </button>
                                <button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#modal-article' data-title='".$title."' data-id='".$a['id']."' data-menu='edit' data-group='article'>
                                    <i class='fa fa-edit'></i> Edit
                                </button>
                                <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#modal-article' data-title='".$title."' data-id='".$a['id']."' data-menu='delete' data-group='article'> 
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
        <a href="<?=base_url()?>admin/newarticle" type="button" class="btn btn-primary btn-s">Tambah Berita & Informasi</a>
    </div><br>
</div>
<div class="box box-danger">
    <div class="box-inner">
        <h4><b>Kegiatan</b></h4>
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">Judul</th>
                <th scope="col">Mulai</th>
                <th scope="col">Selesai</th>
                <th scope="col">Lokasi</th>
                <th scope="col">Menu</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($event as $a){
                    $title = ucwords($a['title']);
                    echo "<textarea hidden name='' id='event-".$a['id']."' cols='30' rows='10'>".$a['description']."</textarea><input hidden id='img-event-".$a['id']."' value='".$a['image']."'/><input hidden id='start-date-".$a['id']."' value='".$a['startDate']."'/><input hidden id='end-date-".$a['id']."' value='".$a['endDate']."'/><input hidden id='event-loc-".$a['id']."' value='".$a['location']."'/>
                        <tr>
                            <td>".$title."</td>
                            <td>".date("j F, Y - g:i a", strtotime($a['startDate']))."</td>
                            <td>".date("j F, Y - g:i a", strtotime($a['endDate']))."</td>
                            <td>".$a['location']."</td>
                            <td>
                                <button class='btn btn-primary btn-xs' data-toggle='modal' data-target='#modal-article' data-title='".$title."' data-id='".$a['id']."' data-menu='view' data-group='event'>
                                    <i class='fa fa-eye'></i> View
                                </button>
                                <button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#modal-article' data-title='".$title."' data-id='".$a['id']."' data-menu='edit' data-group='event'>
                                    <i class='fa fa-edit'></i> Edit
                                </button>
                                <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#modal-article' data-title='".$title."' data-id='".$a['id']."' data-menu='delete' data-group='event'> 
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
        <a href="<?=base_url()?>admin/newevent" type="button" class="btn btn-primary btn-s">Tambah Kegiatan</a>
    </div><br>
</div>
<!-- MODAL -->
<div class="modal fade" id="modal-article" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- MODAL HEADER -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><b><span id="article-title"></span></b></h4>
                <input hidden type="text">
            </div>
            <div class="modal-body">
                <!-- MODAL BODY -->
                <!-- view article -->
                <div id="article-content">

                </div>
                <!-- edit article -->
                <?= form_open_multipart(base_url('dataprocess/editarticle'), array('style'=>'display:none;', 'method'=>'POST', 'id'=>'edit-form-article')) ?>
                    <div class="form-group">
                        <label for="edit-title-article" class="control-label">Judul</label>
                        <input type="text" class="form-control" id="edit-title-article" name="edit-title-article">
                        <input  type="text" name="edit-id-article" id="edit-id-article">
                    </div>
                    <div class="form-group">
                        <label for="edit-image-article" class="control-label">Gambar Depan</label> 
                        <button style='display:none' class='cancel-btn btn btn-danger btn-xs' group="article"> 
                            <i class='fa fa-times'></i> Cancel
                        </button><br>
                        <img id="image-old-article" src="" alt="" style="max-width: 200px;max-height: 140px;">
                        <input id="edit-image-article" name="edit-image-article" type='file' group="article"/>
                        <input  type="text" name="edit-image-old-article" id="edit-image-old-article">
                        <small style="color: #9a9a9a;">Max file size 2MB</small>
                    </div>
                    <div class="form-group">
                        <label for="content-article" class="control-label">Konten</label>
                        <textarea id="content-article" name="content-article" rows="10" cols="80">
                        </textarea>
                    </div>
                </form>
                <!-- edit event -->
                <?= form_open_multipart(base_url('dataprocess/editevent'), array('style'=>'display:none;', 'method'=>'POST', 'id'=>'edit-form-event'));?>
                    <div class="form-group">
                        <label for="edit-title-event">Judul Kegiatan</label>
                        <input type="text" name="edit-title-event" class="form-control" id="edit-title-event">
                        <input  type="text" name="edit-id-event" id="edit-id-event">
                    </div>
                    <div class="form-group">
                        <label for="edit-image-event" class="control-label">Gambar Depan</label> 
                        <button style='display:none' class='cancel-btn btn btn-danger btn-xs' group="event"> 
                            <i class='fa fa-times'></i> Cancel
                        </button><br>
                        <img id="image-old-event" src="" alt="" style="max-width: 200px;max-height: 140px;">
                        <input id="edit-image-event" name="edit-image-event" type='file' group="event"/>
                        <input  type="text" name="edit-image-old-event" id="edit-image-old-event">
                        <small style="color: #9a9a9a;">Max file size 2MB</small>
                    </div>
                    <div class="form-group">
                        <label for="startDate">Mulai & Selesai</label><br>
                        <input readonly="readonly" type="text" id="start-date" name="start-date" placeholder="Waktu Mulai" class="form-control">
                        <input readonly="readonly" type="text" id="end-date" name="end-date" placeholder="Waktu Selesai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="location">Lokasi</label>
                        <input type="text" name="location" class="form-control" id="location">
                    </div>
                    <div class="form-group">
                        <label for="content-event">Deskripsi</label>
                        <textarea id="content-event" name="content-event" rows="10" cols="80">
                        </textarea>
                    </div>
                </form>
                <!-- delete article -->
                <form style="display:unset;" action="<?=base_url()?>dataprocess/deletearticle" method="post" id="delete-form">
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
    CKEDITOR.replace('content-article', {
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

    $('#modal-article').on('show.bs.modal', function (event){
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
            modal.find('#article-content').html(content);
            modal.find('#article-content').prepend($('<img src="<?=base_url()?>assets/img/'+group+'/'+$('#img-'+group+'-'+id).val()+'"/>').css('max-width','100%'));
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
            if(group == 'event'){
                modal.find('#start-date').val($('#start-date-'+id).val().slice(0, 16));
                modal.find('#end-date').val($('#end-date-'+id).val().slice(0, 16));
                modal.find('#location').val($('#event-loc-'+id).val());
            }
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

        modal.find('#article-title').text(title);
        modal.find('#delete-id').val(id);
        $("#delete-btn").click(function(){
            $('#form-delete').submit();
        });
    });

    $('#modal-article').on('hidden.bs.modal', function (event){
        $('#file-input').val('');
        $('#edit-form-article').hide();
        $('#edit-form-event').hide();
        $(this).find('#article-content').html('');
        $('#edit-btn').hide();
        $('#delete-btn').hide();
    });

    $('#edit-image-event, #edit-image-article').on('change', function(){
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