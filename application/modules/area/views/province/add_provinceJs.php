<script>
    $("#form-add-province").validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            show_notif(400, "DATA PROVINSI TIDAK TERSIMPAN");
        } else {
            var code = $("#code").val();
            var name = $("#name").val();

            var data = {
                code : code,
                name : name
            }

            var dataSend = {
                data : JSON.stringify(data)
            }

            $.ajax({
                type: "POST",
                url: "/area/province/saveProvince",
                dataType: "json",
                data:dataSend,
                success: function (data) {
                    show_notif(data.code, data.message);
                    if (data.code==200 || data.code==201) {
                        $("#code").val("");
                        $("#name").val("");
                    }
                }
            });
            return false;

        }
    });

    function show_notif(tipe, message){
        if(tipe == 201 || tipe == 200){
            $("#respon_server").attr('class','alert alert-success');
        } else {
            $("#respon_server").attr('class','alert alert-danger');
        }
        $("#respon_server .message").html(message);
        $("#respon_server").show('slow');
    }

</script>