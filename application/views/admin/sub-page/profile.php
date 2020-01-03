<?php
    if(isset($_SESSION['success'])){
        echo "<div class='alert alert-success' role='alert'>".$_SESSION['success']."</div>";
    }elseif(isset($_SESSION['error'])){
        echo "<div class='alert alert-danger' role='alert'>".$_SESSION['error']."</div>";
    }
?>
<div class="box box-primary">
    <div class="box-inner">
        <h4><b>Halaman Profile</b></h4>
        <div id="profile"><?php
                if(!empty($profile)){
                    echo $profile[0]['content'];
                }
            ?></div>
    </div>
    <div style="margin-left:10px;">
        <button data-toggle="modal" data-target="#modal-profile" type='button' class='btn btn-warning btn-s'>Edit halaman</button>
    </div><br>
</div>
<!-- MODAL -->
<!-- modal profile -->
<div class="modal fade" id="modal-profile" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit halaman</h4>
        </div>
        <div class="modal-body">
            <?= form_open_multipart(base_url('dataprocess/editprofile'), array('id' => 'form-profile'));?>
                <div class="form-group">
                    <label for="edit-profile" class="control-label">Konten</label>
                    <textarea rows="20" type="text" class="form-control" id="edit-profile" name="edit-profile"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" id="edit-btn" class="btn btn-primary">Submit</button>
        </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/jquery.magnific-popup.js'); ?>"></script>
<!-- CK Editor -->
<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script>
    let roxyFileman = '<?=base_url()?>assets/fileman/index.html';
    CKEDITOR.replace('edit-profile', {
        filebrowserBrowseUrl: roxyFileman,
        filebrowserImageBrowseUrl: roxyFileman+'?type=image',
        removeDialogTabs: 'link:upload;image:upload'
    });
    $('#modal-profile').on('show.bs.modal', function (event){
        CKEDITOR.instances['edit-profile'].setData($('#profile').html());
        $("#edit-btn").click(function(){
            $('#form-profile').submit();
        });
    });
</script>