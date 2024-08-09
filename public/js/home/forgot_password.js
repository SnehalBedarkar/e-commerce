$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#send_otp').on('click',function(e){
        e.preventDefault()
        let email = $('#email').val();

        $.ajax({
            url:'/auth/forgot/password',
            type:'POST',
            data:{
                'email':email,
            },
            success:function(response){
                if(response.success){
                    console.log(response.success);
                }
            }
        })
    })

    $('#submit_otp').on('click',function(e){
        e.preventDefault();
        let otp = $('#otp').val();
        $.ajax({
            url:'/auth/verify/otp',
            type:'POST',
            data:{
                'otp':otp
            },
            success:function(response){
                if(response.success){
                    console.log(response);
                    window.location.href = response.redirectUrl;
                }
            }
        })
    })
})