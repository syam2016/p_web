<div class="alert alert-success" role="alert" id="respon_server" style="display: none">
    <p class="message"></p>
</div>
<div class="block">
    <div class="header">
        <h2><?php echo $title ?></h2>
        <div class="side pull-right">
            <ul class="buttons">
                <li><a href="/master/areas/addUnitWorking"><span class="icon-plus"></span> Tambah Data</a></li>
            </ul>
        </div>
    </div>
    <div class="content">
        <table id="unitWorking" class="display responsive nowrap table" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="col-md-2">Kode</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th class="col-md-2">Telepon</th>
                <th>Faxmail</th>
                <th>Email</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Tipe</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal modal-danger" tabindex="-1" role="dialog" id="model_remove">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Hapus Unit Kerja</h4>
            </div>
            <div class="modal-body">
                <p>Apakah anda setuju menghapus Unit Kerja<br><br><strong><b id="dataUnitWorking"></b></strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnHapus" onclick="hapus()" data-dismiss="modal">
                    Setuju
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#unitWorking').DataTable({
            "processing": true,
            ajax: {
                url: '<?php echo base_url()?>/master/unitWorking/getUnit',
                dataSrc: 'data.content',
                data: function(d,settings){
                    var api = new $.fn.dataTable.Api( settings );
                    d.page = api.page.info().page;
                    d.size = d.length
                    d.search = d.search.value
                }
            },
            "serverSide": true,
            columns: [
                {
                    "data": "code"
                },
                {
                    "data": "name"
                },
                {
                    "data": "address",
                    // "render": "[, ].name"
                },
                {
                    "data": "phone",
                },
                {
                    "data": "facsimile",
                    "visible": false
                },
                {
                    "data": "email",
                    "visible":false
                },
                {
                    "data": "latitude",
                    "visible": false
                },
                {
                    "data": "longitude",
                    "visible": false
                },
                {
                    "data": "typeUnit.type",
                },
                //{
                //    "data": "cityId",
                //    //render: function (data, type, full, meta) {
                //    //    var currentCell = $("#unitWorking").DataTable().cells({"row":meta.row, "column":meta.col}).nodes(0);
                //    //    return $.ajax({
                //    //        type: "GET",
                //    //        url: '<?php ////echo base_url()?>////master/city/getCityById/' + full.cityId,
                //    //    }).done(function (success) {
                //    //            var res =  JSON.parse(success);
                //    //            $(currentCell).text(res.data.name);
                //    //    });
                //    //    return null;
                //    //}
                //},
                {
                    data: "",
                    className: "center",
                    render: function (data, type, full) {
                        return '<a href="<?php echo base_url()?>master/areas/editUnitWorking/' + full.id + '" class=" editor_edit"><span class="icon-edit"></span></a> / <a href="#" class=" editor_remove" onclick="showModalRemove(\'' + full.name + '\',\'' + full.id + '\')"><span class="icon-trash"></span></a>';
                    }
                }
            ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });

    function showModalRemove(unitWorking, id) {
        $("#dataUnitWorking").html(unitWorking);
        $("#btnHapus").attr('onclick', 'hapus("' + id + '")');
        $("#model_remove").modal('show');
    }

    function show_notif(tipe, message) {
        if (tipe == 201 || tipe == 200) {
            $("#respon_server").attr('class', 'alert alert-success');
        } else {
            $("#respon_server").attr('class', 'alert alert-danger');
        }
        $("#respon_server .message").html(message);
        $("#respon_server").show('slow');
    }

    function hapus(id) {
        var id = id;

        var data = {
            id: id
        }

        var dataSend = {
            data: JSON.stringify(data)
        }

        $.ajax({
            type: "POST",
            url: "/master/unitWorking/deleteUnit",
            data: dataSend,
            success: function (data) {
                var data = JSON.parse(data);
                show_notif(data.code, data.message);
                setTimeout(function () {
                    location.reload();
                }, 3000);
            }
        })
    }


</script>
