$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#register_button').on('click',function() {
        var formData = $('#register_form').serialize();
        console.log(formData);
        $('.register_error').html('');

        // Send AJAX request
        $.ajax({
            url: '/auth/register', // Your registration route
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#registerModal').modal('hide');
                alert('Registration successful!');
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    });



});
