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
    <?= form_open_multipart(base_url('dataprocess/newtesti'));?>
    <div class="form-group">
        <label for="name">Nama</label>
        <input type="text" name="name" class="form-control" id="name">
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
        <label for="photo">Foto</label>
        <input name="photo" type='file'/>
        <small style="color: #9a9a9a;">Max file size 2MB</small>  
    </div>
    <div class="form-group testi-textarea">
        <label for="testi">Testimoni</label>
        <textarea class="form-control" id="testi" name="testi" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>