$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#togglePassword').on('click', function() {
        var passwordField = $('#register_password');
        var type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    $('#togglePasswordConfirmation').on('click', function() {
        var passwordConfirmationField = $('#password_confirmation');
        var type = passwordConfirmationField.attr('type') === 'password' ? 'text' : 'password';
        passwordConfirmationField.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    $('#login_button').on('click',function(e){
        e.preventDefault();

        // Clear previous error messages
        $("#login_email_error").text('');
        $("#login_password_error").text('');

        let formData = $('#login_form').serialize();
        $.ajax({
            url:'/auth/login',
            type:'POST',
            data:formData,
            success:function(response){
                if(response.success){
                    console.log(response.success);
                    $("#login_modal").modal('hide');
                    window.location.href = response.redirect_url;
                }else if(response.errors){
                    let errors = response.errors;
                    console.log(errors);
                    errors.forEach((error)=>{
                        if(error.includes('email')){
                            $("#login_email_error").text(error);
                        }else if(error.includes('password')){
                            $("#login_password_error").text(error);
                        }
                    })
                }
            },
            error:function(error){
                console.log(error);
            }
        })
    })

    $('#register_button').on('click',function(event){
        event.preventDefault();
        let formData = $('#register_form').serialize();

        // clear the previous errors
        $('.text-danger').text('');
        
        $.ajax({
            url:'/auth/register',
            type:'POST',
            data:formData,
            success:function(response){
                if(response.success){
                    $('#registerModal').modal('hide');
                    $('#login_modal').modal('show');
                    $('#register_form')[0].reset();
                }else{
                    let errors = response.errors;
                    errors.forEach((error)=>{
                        if(error.includes('name')){
                            $('#register_name_error').text(error)
                        }else if(error.includes('email')){
                            $('#register_email_error').text(error)
                        }else if(error.includes('confirmation')){
                            $('#password_confirmation_error').text(error)
                        }else if(error.includes('passoword')){
                            $('#password_password_error').text(error)
                        }else if(error.includes('phone')){
                            $('#phoone_number_error').text(error)
                        }else {
                            $('.text-danger').text('');
                        }
                    })
                    console.log(response.errors)
                }
            },
            error: function(xhr,status,error) {
              //
            }
        });
    });

    $('#logout_button').on('click',function(){
        $.ajax({
            url:'/auth/logout',
            type:'POST',
            success:function(response){
                if(response.success){
                    window.location.href = response.redirect_url;
                    $('#header_message').html('<div class="alert alert-success">' + response.message + '</div>');
                    setTimeout(() => {
                        $('#header_message').html('');
                    }, 4000);
                }
            },
            error:function(xhr,status,error){
                console.log(xhr,status,error);
            }
        });
    });
});