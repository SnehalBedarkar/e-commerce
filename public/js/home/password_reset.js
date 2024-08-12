$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#togglePassword').on('click', function() {
        let passwordField = $('#password');
        let type = passwordField.attr('type');
        
        if (type === 'password') {
            passwordField.attr('type', 'text');
            $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });


    $('#togglePasswordConfirmation').on('click',function(){
        let passwordConfirmationField = $('#password-confirmation');
        let type = passwordConfirmationField.attr('type');

        if(type === 'password'){
            passwordConfirmationField.attr('type','text');
            $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
        }else{
            passwordConfirmationField.attr('type','password');
            $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    
    var form = $('#password_reset_form');
    form.on('submit', function(e) {
        e.preventDefault(); 
        let formData = form.serialize();

        let email = $('#email').val()
        
        if(!email){
            $('#email').addClass('is-invalid');
            $('#email_error').show();
        }else{
            $('#email').removeClass('is-invalid');
            $('#email_error').hide();
        }

        let password = $('#password').val();

        if(!password){
            $('#password').addClass('is-invalid');
            $('#password_error').show();
        }else{
            if(password.length < 8){
                $('#password').addClass('is-invalid');
                $('#password_error').text('Please enter atleast 8 characters');
            }else{
                $('#password').removeClass('is-invalid');
                $('#password_error').hide();
            }
        }

        let confirmPassoword = $('#password-confirmation').val();
        
        if(!confirmPassoword){
            $('#password-confirmation').addClass('is-invalid');
            $('#password_confirmation_error').show();
        }else{
            if(confirmPassoword  !== password){
                $('#password-confirmation').addClass('is-invalid');
                $('#password_confirmation_error').text('password does not match');
            }else{
                $('#password-confirmation').removeClass('is-invalid');
                $('#password_confirmation_error').hide();
            }
        }

        $.ajax({
            url: '/auth/register-new-password',
            method: 'POST',
            data: formData,
            success: function(response) {
                if(response.success === true){
                    $('#password_reset_form')[0].reset();
                    $("#loginModal").modal('show');
                }
            },
            error: function(xhr) {
               if(response.success === false){
                    // 
               }
            }
        });
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

});