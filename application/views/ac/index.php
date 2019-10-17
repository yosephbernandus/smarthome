<div class="container-fluid">
    
    <div class="block-header">
        <h2>
            AC MENU
        </h2>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ON / OFF AC
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="body">

                    <div class="demo-color-box bg-light-green hover-expand-effect">
                        <div class="color-name">WEMOS D1</div>
                        <div class="color-class-name"><b><h4><span class="deviceState">OFFLINE</span></h4></b></div>
                    </div>
                    
                    <div class="demo-color-box bg-pink">
                        <div class="color-name"><i class="material-icons">power</i></div>
                        <div class="color-class-name"><b><h4><span class="fan">OFF</span></h4></b></div>
                    </div>

                    <div class="demo-button">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <button onclick="fanON()" type="button" class="btn btn-block btn-lg btn-primary waves-effect"> 
                                <i class="material-icons">power_settings_new</i>
                                <span>ON</span>
                            </button>
                        </div>
                        
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <button onclick="fanOFF()" type="button" class="btn btn-block btn-lg btn-danger waves-effect"> 
                                <i class="material-icons">power_settings_new</i>
                                <span>OFF</span>
                            </button>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        LOG SUHU
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>   
                                    <th>No</th>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Temprature</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Temprature</th>
                                    <th>Date</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Basic Examples -->
</div>

<!-- Jquery Core Js -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js');?>"></script>

<!-- Jquery DataTable Plugin Js -->
<script src="<?php echo base_url('assets/plugins/jquery-datatable/jquery.dataTables.js');?>"></script>

<!-- Custom Js -->
<script src="<?php echo base_url('assets/js/admin.js');?>"></script>

<!-- Demo Js -->
<script src="<?php echo base_url('assets/js/demo.js');?>"></script>

<script type="text/javascript">
    $(function () {
        var t = $('.js-basic-example').DataTable( {
            responsive: true,
            "ajax": '<?php echo site_url('Ac/data'); ?>',
            "order": [[ 2, 'desc' ]],
            "columns": [
            {
                "data": null,
                "sClass": "text-center",
                "orderable": false,
            },
            { "data": "tahun"},
            { "data": "bulan"},
            { "data": "hari"},
            { "data": "waktu" },
            { "data": "nilai_suhu"},
            { "data": "tanggal"},
            ]
        } );

        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});

</script>