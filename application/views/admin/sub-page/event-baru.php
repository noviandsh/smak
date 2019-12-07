<?php
    if(isset($_SESSION['success'])){
        echo "<div class='alert alert-success' role='alert'>".$_SESSION['success']."</div>";
    }elseif(isset($_SESSION['error'])){
        echo "<div class='alert alert-danger' role='alert'>".$_SESSION['error']."</div>";
    }
?>
<div class="box">
<div id="form-event">
    <?php
        if(validation_errors() !== ''){
            echo "<div class='alert alert-danger' role='alert'>".validation_errors()."</div>";
        }
    ?>
    <?= form_open_multipart(base_url('dataprocess/newevent'));?>
        <div class="form-group">
            <label for="title">Judul Artikel</label>
            <input type="text" name="title" class="form-control" id="title">
        </div>
        <div class="form-group">
            <label for="files">Gambar Depan</label>
            <input name="files" type='file'/>
            <small style="color: #9a9a9a;">Max file size 2MB</small>  
        </div>
        <div class="form-group">
            <label for="startDate">Mulai & Selesai</label><br>
            <input readonly="readonly" type="text" id="start-date" name="start-date" placeholder="Waktu Mulai"> - 
            <input readonly="readonly" type="text" id="end-date" name="end-date" placeholder="Waktu Selesai">
        </div>
        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" name="location" class="form-control" id="location">
        </div>
        <div class="form-group">
            <label for="content">Deskripsi</label>
            <textarea id="content" name="content" rows="10" cols="80">
            </textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>

<script src="<?=base_url('assets/js/jquery-ui.js')?>"></script>
<script src="<?=base_url('assets/js/jquery-ui-timepicker-addon.js')?>"></script>
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