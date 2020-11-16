<div id="biodata-content" class="box box-danger" style="padding:10px;">
    <h3><b>Biodata dan nilai calon peserta didik</b></h3>
    <?php if(!empty($data) && $profile['status'] > 2): 
            if($profile['change_data']==1){
                echo "<span class='label status label-primary'>Permintaan anda untuk mengubah biodata & nilai sedang menunggu persetujuan panitia PPDB</span>";
            }else{
                echo '<span class="label status label-primary">
                    Jika ada data yang salah, <a style="color:#f9de21;" href="'.base_url().'dataprocess/ppdbrequestchange">Klik disini</a> untuk meminta panitia PPDB mengubah biodata & nilai yang salah.
                    </span>';
            }
        ?>
    
    <table id="myTable1" class="custom display table table-bordered table-hover">
        <h4><b>Biodata calon peserta didik</b></h4>
        <tr>
            <th>Nama</th>
            <td><?=$data['name']?></td>
        </tr>
        <tr>
            <th>NISN</th>
            <td><?=$data['nisn']?></td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td><?=$jk[$data['sex']]?></td>
        </tr>
        <tr>
            <th>Tempat Lahir</th>
            <td><?=ucwords($data['pob'])?></td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th>
            <td><?=idDate($data['dob'])?></td>
        </tr>
        <tr>
            <th>Nama Orang Tua/Wali</th>
            <td><?=$data['parent_name']?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><?=$data['address']?></td>
        </tr>
        <tr>
            <th>Kota/Kabupaten</th>
            <td><?=$data['city']?></td>
        </tr>
        <tr>
            <th>Asal Sekolah</th>
            <td><?=$data['school_origin']?></td>
        </tr>
        <tr>
            <th>Agama</th>
            <td><?=ucwords($data['religion'])?></td>
        </tr>
    </table>
    <table id="myTable2" class="custom display table table-bordered table-hover">
        <h4><b>Nilai rapor semester 6</b></h4>
        <tr>
            <th>Matematika</th>
            <td><?=$data['mat']?></td>
        </tr>
        <tr>
            <th>Bahasa Indonesia</th>
            <td><?=$data['bind']?></td>
        </tr>
        <tr>
            <th>Bahasa Inggris</th>
            <td><?=$data['bing']?></td>
        </tr>
        <tr>
            <th>IPA</th>
            <td><?=$data['ipa']?></td>
        </tr>
    </table>
    <table id="myTable3" class="custom display table table-bordered table-hover">
        <h4><b>Prestasi</b></h4>
        <tr>
            <th>Akademik</th>
            <td><?=$data['akademik']?></td>
        </tr>
        <tr>
            <th>Non-Akademik</th>
            <td><?=$data['non_akademik']?></td>
        </tr>
    </table>
    <table id="myTable4" class="custom display table table-bordered table-hover">
        <h4><b>Pemilihan Jurusan/Peminatan</b></h4>
        <tr>
            <th>Pilihan 1</th>
            <td><?=$data['option1']?></td>
        </tr>
        <tr>
            <th>Pilihan 2</th>
            <td><?=$data['option2']?></td>
        </tr>
    </table>
    <?php 
        else: echo 'Anda belum mengisi biodata & nilai';
        endif;
    ?>
</div>
<script src="<?=base_url()?>assets/DataTables/datatables.min.js"></script>
<script>
    // $(document).ready( function () {
    //     $('#myTable').DataTable();
    // });
</script>