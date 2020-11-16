<?php   
    echo valid_error('ppdb-error', 'danger');
    echo valid_error('ppdb-success', 'success');
?>
<div class="box box-info">
    <div class="box-inner">
        <h4>
            <form action="<?=base_url()?>dataprocess/editppdb/year/1" method="post">
                <b>Halaman PPDB | Tahun ajaran <input type="number" name="year1" id="year1" style="width: 65px;" value="<?=explode('/', $ppdb['year'])[0]?>"> / 
                <input type="number" name="year2" id="year2" value="<?=explode('/', $ppdb['year'])[1]?>" style="width: 65px;"></b>
                <button class="btn btn-warning btn-xs" data-id="1" data-menu="edit" style="margin-bottom: 5px;">
                    <i class="fa fa-edit"></i> Ubah tahun ajaran
                </button>
            </form>
        </h4>
    </div>
</div>
<div class="box box-primary">
    <div class="box-inner">
        <h4><b>Biaya & Rekening Bank</b></h4>
        <div class="well well-sm">
            Biaya pendaftaran: Rp. <?=number_format($ppdb['cost'], 0, ".", ".")?> 
            <button data-cost="<?=$ppdb['cost']?>" data-toggle="modal" data-target="#modal-ppdb" class="btn btn-warning btn-xs change-btn" data-id="1" data-menu="edit" data-table="cost" style="margin-bottom: 5px;">
                <i class="fa fa-edit"></i> Ubah biaya
            </button>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bank</th>
                    <th>Atas nama</th>
                    <th>Rekening</th>
                    <th>Menu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $x=1;
                    foreach($bank as $val){
                        echo '
                            <tr>
                                <td>'.$x.'</td>
                                <td>'.$val['bank'].'</td>
                                <td>'.$val['name'].'</td>
                                <td>'.$val['account'].'</td>
                                <td>
                                    <button class="btn btn-warning btn-xs change-btn" data-toggle="modal" data-target="#modal-ppdb" data-id="'.$val["id"].'" data-table="bank" data-menu="edit" id="change-bank">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button> 
                                    <a class="btn btn-danger btn-xs" href="'.base_url('dataprocess/deleteppdb/bank/').$val["id"].'"> 
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>';
                        $x++;
                    }
                ?>
                <tr>
                    <td>
                        <?=$x?>
                    </td>
                    <td>
                        <form action="<?=base_url()?>dataprocess/ppdbadd/bank" method="POST">
                        <input type="text" name="add-bank-name" id="add-bank-name" placeholder="Nama bank" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" name="add-name" id="add-name" placeholder="Atas nama" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" name="add-account" id="add-account" placeholder="No. Rekening" class="form-control" required>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-xs" data-id="1">
                            <i class="fa fa-edit"></i> Tambahkan rekening
                        </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- ALUR PENDAFTARAN -->
<div class="box box-success">
    <div class="box-inner">
        <h4><b>Alur Pendaftaran</b></h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Alur</th>
                    <th>Menu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $x=1;
                    foreach($flow as $val){
                        echo '
                            <tr>
                                <td>'.$x.'</td>
                                <td>'.$val['content'].'</td>
                                <td>
                                    <button class="btn btn-warning btn-xs change-btn" data-toggle="modal" data-target="#modal-ppdb" data-id="'.$val["id"].'" data-table="flow" data-menu="edit">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button> 
                                    <a class="btn btn-danger btn-xs" href="'.base_url('dataprocess/deleteppdb/flow/').$val["id"].'"> 
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>';
                        $x++;
                    }
                ?>
                <tr>
                    <td>
                        <?=$x?>
                    </td>
                    <td>
                        <form action="<?=base_url()?>dataprocess/ppdbadd/flow" method="POST">
                        <textarea name="add-flow" id="add-flow" style="width:100%;resize:none;" name="" id="" cols="30" rows="4" placeholder="Alur pendaftaran" class="form-control" required></textarea>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-xs">
                            <i class="fa fa-edit"></i> Tambahkan alur
                        </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="box box-danger">
    <div class="box-inner">
        <h4><b>Jadwal</b></h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Keterangan</th>
                    <th>Tanggal mulai</th>
                    <th>Tanggal selesai</th>
                    <th>Menu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $x=1;
                    foreach($schedule as $val){
                        echo '
                            <tr>
                                <td>'.$x.'</td>
                                <td>'.$val['title'].'</td>
                                <td>'.idDate($val['date_start']).'</td>
                                <td>'.idDate($val['date_end']).'</td>
                                <td>
                                    <button class="btn btn-warning btn-xs change-btn" data-toggle="modal" data-target="#modal-ppdb" data-start="'.$val['date_start'].'" data-end="'.$val['date_end'].'" data-id="'.$val["id"].'" data-table="schedule" data-menu="edit">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button> 
                                    <a class="btn btn-danger btn-xs" href="'.base_url('dataprocess/deleteppdb/schedule/').$val["id"].'"> 
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>';
                        $x++;
                    }
                ?>
                <tr>
                    <td>
                        <?=$x?>
                    </td>
                    <td>
                        <form action="<?=base_url()?>dataprocess/ppdbadd/schedule" method="POST">
                        <input type="text" name="add-title" id="add-title" placeholder="Keterangan jadwal" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" name="add-start-date" id="add-start-date" placeholder="Tanggal mulai" class="form-control" required>
                    </td>
                    <td>  
                        <input type="text" name="add-end-date" id="add-end-date" placeholder="Tanggal berakhir" class="form-control" required>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-xs">
                            <i class="fa fa-edit"></i> Tambahkan jadwal
                        </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="box box-warning">
    <div class="box-inner">
        <h4><b>Brosur</b></h4>
        <div id="brosur">
            <img data-action="zoom" src="<?=base_url('assets/img/').$ppdb['brosur']?>" alt="">
        </div>
    </div>
    <div style="margin-left:10px;">
        <button data-toggle="modal" data-target="#modal-ppdb" type='button' class='btn btn-warning btn-sm change-btn' data-table="brosur" data-id="1">Ubah brosur</button>
    </div><br>
</div>
<div class="box box-primary">
    <div class="box-inner">
        <h4><b>Kontak</b></h4>
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Kontak</th>
                    <th>Menu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $x=1;
                    foreach($contact as $val){
                        echo '
                            <tr>
                                <td>'.$x.'</td>
                                <td>'.$contactType[$val['type']].'</td>
                                <td>'.$val['contact'].'</td>
                                <td>
                                    <button data-contact="'.$val['type'].'" class="btn btn-warning btn-xs change-btn" data-toggle="modal" data-target="#modal-ppdb" data-id="'.$val["id"].'" data-table="contact" data-menu="edit">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button> 
                                    <a class="btn btn-danger btn-xs" href="'.base_url('dataprocess/deleteppdb/contact/').$val["id"].'"> 
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>';
                        $x++;
                    }
                ?>
                <td>
                    <?=$x?>
                </td>
                <td>
                    <form action="<?=base_url()?>dataprocess/ppdbadd/contact" method="POST">
                    <select name="add-type" id="add-type" class="form-control">
                        <option selected disabled required>Jenis kontak</option>
                        <?php 
                            foreach ($contactType as $key => $val){
                                echo "<option value='".$key."'>".$val."</option>";
                            }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="add-contact" id="add-contact" placeholder="Kontak" class="form-control" required>
                </td>
                <td>
                    <button class="btn btn-warning btn-xs">
                        <i class="fa fa-edit"></i> Tambahkan kontak
                    </button>
                    </form>
                </td>
            </tbody>
        </table>
        
    </div>
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
            <?= form_open_multipart(base_url(), array('id' => 'form-ppdb'));?>
                
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" id="edit-btn" class="btn btn-primary">Submit</button>
        </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>assets/DataTables/datatables.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery.magnific-popup.js"></script>

<script src="<?=base_url('assets/js/jquery-ui.js')?>"></script>
<script src="<?=base_url('assets/js/jquery-ui-timepicker-addon.js')?>"></script>
<!-- CK Editor -->
<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script>
    // let roxyFileman = '<?=base_url()?>assets/fileman/index.html';
    // CKEDITOR.replace('edit-ppdb', {
    //     filebrowserBrowseUrl: roxyFileman,
    //     filebrowserImageBrowseUrl: roxyFileman+'?type=image',
    //     removeDialogTabs: 'link:upload;image:upload'
    // });
    // $('#modal-ppdb').on('show.bs.modal', function (event){
    //     CKEDITOR.instances['edit-ppdb'].setData($('#ppdb').html());
    // });
    
    $(document).ready( function () {
        $('#myTable').DataTable();
    });
    function inputHtml(table, field, value){
        var fieldLabel = {
            'bank': ['Nama bank', 'Atas nama', 'Nomor rekening'],
            'flow': ['Alur'],
            'schedule': ['Keterangan', 'Tanggal mulai', 'Tanggal selesai'],
            'contact': ['Jenis', 'Kontak'],
            'brosur': ['Brosur'],
            'cost': ['Biaya pendaftaran']
        };
        var fieldName = {
            'bank': ['change-bank', 'change-name', 'change-account'],
            'flow': ['change-flow'],
            'schedule': ['change-title', 'change-start-date', 'change-end-date'],
            'contact': ['change-type', 'change-contact']
        };
        var inputHtml = `<div class="form-group">
                            <label for="exampleInputEmail1">${fieldLabel[table][field]}</label>`;
        if(table=='contact' && field==0){
            inputHtml += $('#add-type').parent().html();
        }else if(table=='flow'){
            inputHtml += `<textarea name="edit-flow" id="edit-flow" style="width:100%;resize:none;" name="" id="" cols="30" rows="4" placeholder="Alur pendaftaran" class="form-control">${value}</textarea>`;
        }else if(table=='brosur'){
            inputHtml += `<input name="files" type="file" id="exampleInputFile">
                        <p class="help-block">Pastikan gambar berekstensi .jpg .jpeg .png dan ukuran maksimal 2MB</p>`;
        }else if(table="cost"){
            inputHtml += `<input class="form-control" name="change-cost" id="change-cost" value="${value}">`;
        }else{
            inputHtml += `<input class="form-control" name="${fieldName[table][field]}" id="${fieldName[table][field]}" value="${value}">`;
        }
        inputHtml += '</div>';
        return inputHtml;
    }
    $(".change-btn").click(function() {
        var modalTitle = {
            'bank': 'Rekening bank',
            'flow': 'Alur pendaftaran',
            'schedule': 'Jadwal',
            'contact': 'Kontak',
            'brosur': 'Brosur',
            'cost': 'Biaya pendaftaran'
        };
        var form = $('#form-ppdb');
        var table = $(this).attr('data-table');
        var id = $(this).attr('data-id');
        var item = $(this).closest("tr").find("td");     // Gets a descendent with class="nr"
        var inputLength = (item.length-2);
        
        form.attr('action', `<?=base_url()?>dataprocess/editppdb/${table}/${id}`);
        form.html('');
        if(table == 'brosur'){
            form.append(inputHtml(table, 0,null));
        }else if(table == 'cost'){
            form.append(inputHtml(table, 0, $(this).attr('data-cost')));
        }else{
            for(i=0;i<inputLength;i++){
                form.append(inputHtml(table, i,item[i+1].innerHTML));
            }
        }
        $('#modal-ppdb .modal-title').html('Edit '+modalTitle[table]);
        // form.html($('#add-type').parent().html());
        if(table=='contact'){
            $("#add-type option[value='"+$(this).attr('data-contact')+"']").attr('selected','selected');
        }else if(table=='flow'){
            $('#edit-flow').prev().append(' Ke-'+item[0].innerHTML); 
        }else if(table=='schedule'){
            $("#change-start-date").val($(this).attr('data-start'));
            $("#change-end-date").val($(this).attr('data-end'));
            // DATE PICKER FUNCTION
    
            $("#change-start-date").datepicker({ 
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
                onSelect: function(date){
                    let selectedDate = new Date(date);
                    let msecsInADay = 86400000;
                    let endDate = new Date(selectedDate.getTime() + msecsInADay);

                    //Set Minimum Date of EndDatePicker After Selected Date of StartDatePicker
                    $("#change-end-date").datepicker( "option", "minDate", endDate );
                }
            });
            $("#change-end-date").datepicker({ 
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
            });
        }
        console.log(table);
    });

    
    // DATE PICKER FUNCTION
    
    $("#add-start-date").datepicker({ 
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        onSelect: function(date){
            let selectedDate = new Date(date);
            let msecsInADay = 86400000;
            let endDate = new Date(selectedDate.getTime() + msecsInADay);

            //Set Minimum Date of EndDatePicker After Selected Date of StartDatePicker
            $("#add-end-date").datepicker( "option", "minDate", endDate );
        }
    });
    $("#add-end-date").datepicker({ 
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
    });
    
    $("#edit-btn").click(function(){
        $('#form-ppdb').submit();
    });
</script>