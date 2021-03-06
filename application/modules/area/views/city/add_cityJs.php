<script>
    // Document ready
    $(function () {
        setProvinsi();
    })

    function show_notif(tipe, message) {
        if (tipe == 201 || tipe == 200) {
            $("#respon_server").attr('class', 'alert alert-success');
        } else {
            $("#respon_server").attr('class', 'alert alert-danger');
        }
        $("#respon_server .message").html(message);
        $("#respon_server").show('slow');
    }

    function setProvinsi() {
        $.ajax({
            type: "GET",
            url: "<?PHP echo base_url()?>area/province/getData",
            success: function (data) {
                var result = JSON.parse(data);

                //bersihkan dropdown
                $("#provinsi_id option").remove();
                $("#provinsi_id").append('<option value="">Pilih Provinsi</option>')

                // looping get provinsi
                $.each(result.data.content, function (index, value) {
                    $("#provinsi_id").append(
                        '<option value="' + result.data.content[index].id + '">' + result.data.content[index].name + '</option>'
                    )
                })
            }
        })
    }

    $("#form-add-city").validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            console.log("DATA BELUM LENGKAP");
        } else {
            var code = $("#code").val();
            var name = $("#name").val();
            var provinceId = $("#provinsi_id").val();

            var data = {
                code: code,
                name: name,
                province: {
                    id: $("#provinsi_id").val()
                }
            }

            var dataSend = {
                data: JSON.stringify(data)
            }

            if (provinceId == "") {
                show_notif(400, "PROVINSI HARUS DIPILIH");
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo base_url()?>area/city/saveCity",
                    dataType: "json",
                    data: dataSend,
                    success: function (data) {
                        show_notif(data.code, data.message);
                        if (data.code == 200, data.code == 201) ;
                        {
                            $("#code").val("");
                            $("#name").val("");
                        }
                    }
                });
            }
            return false;
        }
    });
</script>