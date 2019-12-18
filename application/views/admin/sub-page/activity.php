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
        <h4><b>Manajemen Akun</b></h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Username</th>
                    <th scope="col">Kegiatan</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($log as $a){
                    echo "<tr>
                            <td>".date("j F, Y - g:i a", strtotime($a['date']))."</td>
                            <td>".$a['username']."</td>
                            <td>".$a['type']."</td>
                            <td>".$a['activity']."</td>
                        </tr>";
                    
                }
            ?>
            </tbody>
        </table>
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
        <a href="<?=base_url('dataprocess/deletelog')?>" class="btn btn-primary btn-s" id="delete-btn">Hapus semua</a>
    </div><br>
</div>