<?php
    if(isset($_SESSION['success'])){
        echo "<div class='alert alert-success' role='alert'>".$_SESSION['success']."</div>";
    }elseif(isset($_SESSION['error'])){
        echo "<div class='alert alert-danger' role='alert'>".$_SESSION['error']."</div>";
    }
?>
<div class="box">
<div id="form-article">
    <?php
        if(validation_errors() !== ''){
            echo "<div class='alert alert-danger' role='alert'>".validation_errors()."</div>";
        }
    ?>
    <?= form_open_multipart(base_url('dataprocess/newarticle'));?>
    <div class="form-group">
        <label for="title">Judul Artikel</label>
        <input type="text" name="title" class="form-control" id="title">
    </div>
    <div class="form-group">
        <label for="files">Gambar Depan</label>
        <input name="files" type='file' multiple/>
        <small style="color: #9a9a9a;">Max file size 2MB</small>  
    </div>
    <div class="form-group">
        <label for="content">Konten</label>
        <textarea id="content" name="content" rows="10" cols="80">
        </textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>
<!-- CK Editor -->
<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<!-- <script src="<?=base_url()?>assets/ckfinder/ckfinder.js"></script> -->
<script>
    // CKEDITOR.on( 'dialogDefinition', function( ev ) {
    //     var dialogName = ev.data.name;
    //     var dialogDefinition = ev.data.definition;
    //     if ( dialogName == 'image' ){
    //         var infoTab = dialogDefinition.getContents( 'info' );
    //         infoTab.remove( 'htmlPreview' );
    //     }
    // });
    let roxyFileman = '<?=base_url()?>assets/fileman/index.html';
    CKEDITOR.replace('content', {
        filebrowserBrowseUrl: roxyFileman,
        filebrowserImageBrowseUrl: roxyFileman+'?type=image',
        removeDialogTabs: 'link:upload;image:upload'
    });
    CKEDITOR.config.height = '380';
</script>