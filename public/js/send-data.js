function sendData(request_url, request_id){
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#form_"+request_id).submit(function(e){
            e.preventDefault();

            $.ajax({
                type:'POST',
                url:request_url,
                data:{id:request_id},
                success:function(data) {
                    $("#logs_console").load(" #logs_console");
                    console.log(data);
                }
            });
        });
    });
}
