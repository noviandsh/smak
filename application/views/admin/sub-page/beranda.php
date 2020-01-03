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
<div class="box box-primary">
    <div class="box-inner">
        <h4><b>Sambutan kepala sekolah</b></h4>
        <div id="speech"><?php
                if(!empty($speech)){
                    echo $speech[0]['content'];
                }
            ?></div>
    </div>
    <div style="margin-left:10px;">
        <button data-toggle="modal" data-target="#modal-speech" type='button' class='btn btn-warning btn-s'>Edit</button>
    </div><br>
</div>
<div class="box box-success">
    <div class="box-inner">
        <h4><b>SLIDER</b></h4>

        <div class="images-container">
        <?php
            foreach($slider as $val){
                ?>
                <div class="images-box slider-group">
                    <button type="button" data-toggle="modal" data-target="#modal-delete" class="images-delete" data-id="<?=$val['id']?>" data-file="<?=$val['file']?>" data-location="slider"><i class="fa fa-trash"></i></button>
                    <a href="<?=base_url("assets/img/slider/").$val["file"]?>">
                        <div class="images" style="background-image: url('<?=base_url("assets/img/slider/").thumb($val["file"])?>')"></div>
                    </a>                    
                </div>
            <?php
            }
        ?>
    </div>
    </div>
    
    <div style="margin-left:10px;">
        <a data-toggle="modal" data-target="#modal-tambah" data-location="slider" type="button" class="btn btn-primary btn-s">Tambah Slider</a>
        <a  type="button" class="btn btn-danger btn-s" data-toggle="modal" data-target="#modal-delete"  data-file="semua" data-del="batch" data-location="slider">Hapus Semua</a>
    </div><br>
</div>


<div class="box box-warning">
    <div class="box-inner">
        <h4><b>Gallery</b></h4>

        <div class="images-container"> 
            <?php
                foreach($gallery as $val){
                    ?>
                    <div class="images-box gallery-group">
                        <button type="button" data-toggle="modal" data-target="#modal-delete" class="images-delete" data-id="<?=$val['id']?>" data-file="<?=$val['file']?>" data-location="gallery"><i class="fa fa-trash"></i></button>
                        <a href="<?=base_url("assets/img/gallery/").$val["file"]?>">
                            <div class="images" style="background-image: url('<?=base_url("assets/img/gallery/").thumb($val["file"])?>')"></div>
                        </a>                    
                    </div>
                <?php
                }
            ?>
        </div>
    </div>
    
    <div id="pagination">
        <ul class="tsc_pagination">
            <!-- Show pagination links -->
            <?php 
                foreach ($links as $link) {
                    echo "<li>". $link."</li>";
                } 
            ?>
        </ul>
    </div>
    
    <div style="margin-left:10px;">
        <a data-toggle="modal" data-target="#modal-tambah" data-location="gallery" type="button" class="btn btn-primary btn-s">Tambah Gallery</a>
        <a  type="button" class="btn btn-danger btn-s" data-toggle="modal" data-target="#modal-delete"  data-file="semua" data-del="batch" data-location="gallery">Hapus Semua</a>
    </div><br>
</div>
<!-- MODAL -->
<!-- modal speech -->
<div class="modal fade" id="modal-speech" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit Sambutan</h4>
        </div>
        <div class="modal-body">
            <?= form_open_multipart(base_url('dataprocess/editspeech'), array('id' => 'form-speech'));?>
                <div class="form-group">
                    <label for="edit-speech" class="control-label">Sambutan</label>
                    <textarea rows="20" type="text" class="form-control" id="edit-speech" name="edit-speech"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" id="edit-btn" class="btn btn-primary">Edit</button>
        </div>
        </div>
    </div>
</div>
<!-- modal tambah -->
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Tambah Testimoni</h4>
        </div>
        <div class="modal-body">
            <?= form_open_multipart(base_url('dataprocess/addimages'), array('id' => 'form-tambah'));?>
                <div class="form-group">
                    <input name="files[]" type='file' multiple/>
                    <small style="color: #9a9a9a;">Max file size 2MB</small>  
                </div>
                <input hidden type="text" name="location" id="images-location">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" id="submit-btn" class="btn btn-primary">Tambahkan</button>
        </div>
        </div>
    </div>
</div>
<!-- Modal Delete-->
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Apakah anda yakin akan menghapus <span style="color:red;" id="delete-name"></span> dari <span id="delete-location"></span>?</h4>
            <form style="display:none;" action="<?=base_url()?>dataprocess/deleteimages" method="post" id="form-delete">
                <input type="text" id="delete-id" name="id">
                <input type="text" id="delete-filename" name="filename">
                <input type="text" id="delete-type" name="jenis">
                <input type="text" id="form-location" name="location">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" id="delete-btn" class="btn btn-primary">Delete</button>
        </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/jquery.magnific-popup.js'); ?>"></script>
<script>
    $('.slider-group').magnificPopup({
        delegate: 'a', // child items selector, by clicking on it popup will open
        type: 'image',
        gallery: {enabled:true}
        // other options
    });
    
    $('.gallery-group').magnificPopup({
        delegate: 'a', // child items selector, by clicking on it popup will open
        type: 'image',
        gallery: {enabled:true}
        // other options
    });
    $('#modal-tambah').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget); // Button that triggered the modal
        let loc = button.data('location');
        $("#images-location").val(loc);
        $("#submit-btn").click(function(){
            $('#form-tambah').submit();
        });
    })
    $('#modal-speech').on('show.bs.modal', function (event){
        $("#edit-speech").val($('#speech').html());
        $("#edit-btn").click(function(){
            $('#form-speech').submit();
        });
    })
    $('#modal-delete').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget); // Button that triggered the modal
        let name = button.data('file'); // Extract info from data-file attributes
        let id = button.data('id'); // Extract info from data-id attributes
        let del = button.data('del'); // Extract info from data-del attributes
        let loc = button.data('location'); // Extract info from data-location attributes
        let modal = $(this);
        modal.find('#delete-name').text(name);
        modal.find('#delete-location').text(loc);
        modal.find('#form-location').val(loc);
        modal.find('#delete-id').val(id);
        modal.find('#delete-filename').val(name);
        modal.find('#delete-type').val(del);
        $("#delete-btn").click(function(){
            $('#form-delete').submit();
        });
    })
</script>