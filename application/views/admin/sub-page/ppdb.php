<?php
    if(isset($_SESSION['success'])){
        echo "<div class='alert alert-success' role='alert'>".$_SESSION['success']."</div>";
    }elseif(isset($_SESSION['error'])){
        echo "<div class='alert alert-danger' role='alert'>".$_SESSION['error']."</div>";
    }
?>
<div class="box box-primary">
    <div class="box-inner">
        <h4><b>Halaman PPDB</b></h4>
        <div id="ppdb"><?php
                if(!empty($ppdb)){
                    echo $ppdb[0]['content'];
                }
            ?></div>
    </div>
    <div style="margin-left:10px;">
        <button data-toggle="modal" data-target="#modal-ppdb" type='button' class='btn btn-warning btn-s'>Edit halaman</button>
    </div><br>
</div>
<!-- MODAL -->
<!-- modal ppdb -->
<div class="modal fade" id="modal-ppdb" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit halaman</h4>
        </div>
        <div class="modal-body">
            <?= form_open_multipart(base_url('dataprocess/editppdb'), array('id' => 'form-ppdb'));?>
                <div class="form-group">
                    <label for="edit-ppdb" class="control-label">Konten</label>
                    <textarea rows="20" type="text" class="form-control" id="edit-ppdb" name="edit-ppdb"></textarea>
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
    CKEDITOR.replace('edit-ppdb', {
        filebrowserBrowseUrl: roxyFileman,
        filebrowserImageBrowseUrl: roxyFileman+'?type=image',
        removeDialogTabs: 'link:upload;image:upload'
    });
    $('#modal-ppdb').on('show.bs.modal', function (event){
        CKEDITOR.instances['edit-ppdb'].setData($('#ppdb').html());
        $("#edit-btn").click(function(){
            $('#form-ppdb').submit();
        });
    });
</script>