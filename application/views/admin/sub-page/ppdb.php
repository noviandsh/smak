<?php
    echo valid_error('ppdb-error', 'danger');
    echo valid_error('ppdb-success', 'success');
    $status = array(
        '<span class="label status label-warning">Menunggu pembayaran</span>', 
        '<span class="label status label-danger">Verifikasi pembayaran oleh admin</span>', 
        '<span class="label status label-warning">Menunggu data calon siswa</span>', 
        '<span class="label status label-danger">Verifikasi data oleh admin</span>',
        '<span class="label status label-success">Calon siswa terverivikasi</span>'
    );
?>
<div class="row">
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
        <div class="inner">
            <h3><?=$count['new']?></h3>

            <p>Pendaftaran Baru</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="<?=base_url()?>admin/ppdb/0-1-2-3" class="small-box-footer">
            Tampilkan data <i class="fa fa-arrow-circle-right"></i>
        </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
        <div class="inner">
            <h3><?=$count['waiting']?></h3>

            <p>Menunggu Verifikasi Admin</p>
        </div>
        <div class="icon">
            <i class="ion ion-ios-pricetags"></i>
        </div>
        <a href="<?=base_url()?>admin/ppdb/1-3" class="small-box-footer">
            Tampilkan data <i class="fa fa-arrow-circle-right"></i>
        </a>
        </div>
    </div>
    <!-- ./col -->
    <!-- ./col -->
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
        <div class="inner">
            <h3><?=$count['verified']?></h3>

            <p>Calon Peserta Didik Terverifikasi</p>
        </div>
        <div class="icon">
            <i class="ion ion-checkmark-circled"></i>
        </div>
        <a href="<?=base_url()?>admin/ppdb/4" class="small-box-footer">
            Tampilkan data <i class="fa fa-arrow-circle-right"></i>
        </a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="box box-primary">
    <div class="box-inner">
        <h4>
            <b>Daftar calon peserta didik baru</b>
        </h4> 
        <div id="ppdb"><?php
                if(!empty($ppdb)){
                    // echo $ppdb[0]['content'];
                }
            ?>
            <table id="myTable" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>No. Pendaftaran</th>
                        <th>Nama</th>
                        <th>NISN</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="section-foot" style="margin-left:10px;">
        <a href="<?=base_url()?>admin/ppdb" class="btn btn-info btn-s" style="display:none;">Tampilkan semua data</a>
        <?=$count['verified']>0?'<a id="export-data" href="<?=base_url()?>dataprocess/exporttoxls" class="btn btn-success btn-s">Simpan data ke Excel</a>':null?>
        
        <button id="delete-selected" class="btn btn-danger btn-s" data-toggle="modal" data-target="#modal-confirm" disabled>Hapus data yang dipilih</button>
    </div><br>
</div>
<!-- MODAL -->
<!-- modal ppdb -->
<div class="modal fade" id="modal-verify" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"></h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" action="refuse" id="refuse-btn" class="btn btn-danger"></button>
            <button type="button" action="accept" id="verify-btn" class="btn btn-primary"></button>
        </div>
        </div>
    </div>
</div>
<!-- Modal confirm -->
<div class="modal fade" id="modal-confirm" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-s" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <h4>Apakah anda yakin akan menghapus data yang dipilih?</h4>
            <form id="form-delete" action="<?=base_url()?>dataprocess/ppdbdelete" method="post">
                <input type="text" name="deleteID" id="deleteID">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="button" id="delete-btn" class="btn btn-danger">Hapus</button>
        </div>
    </div>
  </div>
</div>
<script src="<?=base_url()?>assets/DataTables/datatables.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery.magnific-popup.js"></script>
<script>
    var baseurl = '<?=base_url()?>';
    // DATATABLES
    /* Formatting function for row details - modify as you need */
    function payment(p) {
        if(p==null){
            return "Belum membayar";
        }else{
            return `<img src="${baseurl}assets/img/payment/${p}" data-action="zoom" style="max-width: 150px; max-height: 200px;">`;
        }
    }
    function format ( d ) {
        // `d` is the original data object for the row
        return `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
            <tr>
                <td>Nomor Handphone :</td>
                <td>${d.no}</td>
            </tr>
            <tr>
                <td>Tanggal Pendaftaran :</td>
                <td>${d.reg_date}</td>
            </tr>
            <tr>
                <td>Bukti Pembayaran :</td>
                <td>${payment(d.payment)}</td>
            </tr>
        </table>`;
    }
    function menu(status, pay, id){
        if(status == 1){
            return `<button button-data="payment" data-id="${id}" data-pay="${pay}" type="button" class="btn btn-warning btn-xs">Lihat bukti pembayaran</button>`;
        }else if(status == 3){
            return `<button button-data="temp-data" data-id="${id}" type="button" class="btn btn-warning btn-xs">Lihat biodata & nilai</button>`;
        }else if(status == 4){
            return `<button button-data="data" data-id="${id}" type="button" class="btn btn-info btn-xs">Lihat biodata & nilai</button>`;
        }else{
            return '';
        }
    }
    
    $(document).ready(function() {
        var status = [
            '<span class="label status label-warning">Menunggu pembayaran</span>', 
            '<span class="label status label-danger">Verifikasi pembayaran oleh admin</span>', 
            '<span class="label status label-warning">Menunggu data calon siswa</span>', 
            '<span class="label status label-danger">Verifikasi data oleh admin</span>',
            '<span class="label status label-success">Calon siswa terverivikasi</span>',
            '<br><span class="label status label-primary" style="margin-top: 10px;display:inline-block;padding:6px;">Permintaan ubah biodata & nilai</span>'
        ];
        var thead = {
            id:'No. Pendaftaran',
            name:'Nama lengkap',
            nisn:'NISN',
            sex:'Jenis kelamin',
            pob:'Tempat lahir',
            dob:'Tanggal lahir',
            parent_name:'Nama orang tua',
            address:'Alamat',
            city:'Kota/kabupaten',
            school_origin:'Asal sekolah',
            religion:'Agama',
            mat:'Nilai Matematika',
            bind:'Nilai Bahasa Indonesia',
            bing:'Nilai Bahasa Inggris',
            ipa:'Nilai IPA',
            akademik:'Prestasi akademik',
            non_akademik:'Prestasi Non akademik',
            option1:'Pilihan 1',
            option2:'Pilihan 2'
        };
        let uri = '<?=$this->uri->segment(3)?>';
        if(uri){
            ajaxUrl = `${baseurl}dataprocess/ppdbtable/${uri}`;
            $('.section-foot a').show();
        }else{
            ajaxUrl = `${baseurl}dataprocess/ppdbtable`;
        }
        var table = $('#myTable').DataTable( {
            "scrollX": true,
            ajax: {
                "type": "POST",
                url: ajaxUrl,
                timeout: 120000,                
                dataSrc: 'data'
            },
            columns: [
                {
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                { 
                    className: 'selectable',
                    data: 'id' 
                },
                { 
                    className: 'selectable',
                    data: 'name' 
                },
                { 
                    className: 'selectable',
                    data: 'nisn' 
                },
                { 
                    className: 'selectable',
                    data: 'email' 
                },
                { 
                    data: 'status',
                    render: function ( data, type, row ) {
                        if(row['change_data']==1){
                            html = status[data]+status[5];
                        }else{
                            html = status[data];
                        }
                        return html;
                    } 
                },
                {
                    className: 'table-menu',
                    orderable: false,
                    data: 'status',
                    render: function (data, type, row){
                        if(row['change_data']==1){
                            html = menu(data, row['payment'], row['id'])+
                                   `<button button-data="change-data" data-id="${row['id']}" type="button" class="btn btn-primary btn-xs" style="margin-top: 10px;">Setujui ubah biodata & nilai</button>`;
                        }else{
                            html = menu(data, row['payment'], row['id']);
                        }
                        return html;
                    }
                },
            ],
            order: [[ 1, "asc" ]]
        });
        
        // Add event listener for opening and closing details
        $('#myTable tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
    
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        });
        // Table menu on click
        $('#myTable tbody').on('click', '.table-menu>button', function () {
            buttonData = $(this).attr('button-data');
            // Button payment
            if(buttonData == 'payment'){
                // html for show image & comment textarea
                html = `<img src="${baseurl}assets/img/payment/${$(this).attr('data-pay')}" style="max-width:100%;"><hr/>
                        <div class="form-group">
                            <label for="data-akademik">Komentar admin</label>
                            <textarea name="data-comment" placeholder="Komentar" class="form-control" id="data-comment" rows="3"></textarea>
                        </div>`;
                $('#modal-verify .modal-body').html(html);
                $('#modal-verify .modal-title').text('Verifikasi bukti pembayaran');
                $('#refuse-btn')
                    .html('Tolak pembayaran')
                    .attr({
                        'data-type': 'payment',
                        'data-id': $(this).attr('data-id'),
                        'data-pay': $(this).attr('data-pay')
                    })
                    .show();
                $('#verify-btn')
                    .html('Setujui pembayaran')
                    .attr({
                        'data-type': 'payment',
                        'data-id': $(this).attr('data-id')
                    })
                    .show();
            // Button biodata
            }else if(buttonData == 'temp-data' || buttonData == 'data' || buttonData == 'change-data'){
                $('#refuse-btn')
                    .html('Tolak biodata & nilai')
                    .attr({
                        'data-type': 'data',
                        'data-id': $(this).attr('data-id'),
                    })
                    .removeAttr('data-pay');
                $('#verify-btn')
                    .html('Setujui biodata & nilai')
                    .attr({
                        'data-type': 'data',
                        'data-id': $(this).attr('data-id'),
                    });
                $.ajax({
                    type  : 'POST',
                    url   : `${baseurl}dataprocess/ppdbbio/${$(this).attr('data-id')}`,
                    async : false,
                    dataType : 'json',
                    success : function(data){
                        var html = '';
                        var i;
                        var arrId = [];
                        // html table open tag
                        html += '<table id="myTable1" class="custom display table table-bordered table-hover">';
                        for (let key in data[0]) {
                            html += '<tr>'+
                            '<th>'+thead[key]+'</th>'+
                            '<td>'+data[0][key]+'</td>'+
                            '</tr>';
                        };
                        // html table close tag
                        html += '</table>';

                        if(buttonData == 'temp-data'){
                            html += `<hr/>
                                    <div class="form-group">
                                        <label for="data-akademik">Komentar admin</label>
                                        <textarea name="data-comment" placeholder="Komentar" class="form-control" id="data-comment" rows="3"></textarea>
                                    </div>`;
                            $('#modal-verify .modal-title').text('Verifikasi biodata & Nilai');
                            $('#refuse-btn').show();
                            $('#verify-btn').show();
                        }else if(buttonData == 'data'){
                            $('#refuse-btn').hide();
                            $('#verify-btn').hide();
                            $('#modal-verify .modal-title').text('Biodata & Nilai');
                        }else{
                            $('#modal-verify .modal-title').text('Permintaan Ubah Biodata & Nilai');
                            $('#verify-btn').html('Setujui Ubah Biodata & Nilai').attr('data-type', 'change-data');
                            $('#refuse-btn').html('Tolak Ubah Biodata & Nilai').attr('data-type', 'change-data');
                        }
                        $('#modal-verify .modal-body').html(html);
                    }
                });
            }
            $('#modal-verify').modal();
        });
        $('#refuse-btn').click(function(){
            data = {
                type: $(this).attr('data-type'),
                status: $(this).attr('action'),
                id: $(this).attr('data-id'),
                img: $(this).attr('data-pay'),
                comment: $('#data-comment').val()
            };
            $.ajax({
                url: "<?=base_url()?>dataprocess/ppdbverify",
                data: data,
                type: "POST",
                success:function(data){
                    location.reload();
                },
                error:function (){}
            });
        });
        $('#verify-btn').click(function(){
            data = {
                type: $(this).attr('data-type'),
                status: $(this).attr('action'),
                id: $(this).attr('data-id'),
                comment: $('#data-comment').val()
            };
            $.ajax({
                url: "<?=base_url()?>dataprocess/ppdbverify",
                data: data,
                type: "POST",
                success:function(data){
                    location.reload();
                },
                error:function (){}
            });
        });
        $('#myTable tbody').on( 'click', 'td', function () {
            if($(this).hasClass('selectable')){
                $(this).parent().toggleClass('selected');
            }
            selected = table.rows('.selected').data();
            // console.log(selected.length);
            if(selected.length > 0){
                $('.section-foot button').prop('disabled', false);
            }else{
                $('.section-foot button').prop('disabled', true);
            }
        });
        $('.section-foot #delete-selected').click(function(){
            var deleteId = [];
            data = table.rows('.selected').data();
            var i;
            for (i = 0; i < data.length; i++) {
                deleteId.push(data[i]['id'])
            }
            $('#deleteID').val(deleteId);
            // $.ajax({
            //     url: "<?=base_url()?>dataprocess/ppdbdelete",
            //     data: {id: deleteId},
            //     type: "POST",
            //     success:function(data){
            //         console.log(data);
            //     },
            //     error:function (){}
            // });
            // for(x in data){
            //     console.log(data[x]['id']);
            // }
        });
        $('#delete-btn').click(function(){
            $('#form-delete').submit();
        });
        // $('#modal-verify').on('hide.bs.modal', function (e) {
        //     $(this).find('.modal-body').
        // })
    });
</script>