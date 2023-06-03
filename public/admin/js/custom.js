$(document).ready(function() {
    $("#current_password").focusout(function() {
        let current_password = $("#current_password").val();

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            url: '/admin/check_admin_password',
            data: {current_password:current_password},
            success:function(res) {
                if (res === 'false') {
                    $("#check_password").html("<font color='red'>Current password is incorrect!</font>")
                } else if (res === 'true') {
                    $("#check_password").html("<font color='green'>Current password is correct!</font>")
                }
            },
            error:function(err) {
                //
            }
        })
    });
});