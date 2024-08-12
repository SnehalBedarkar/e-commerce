$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    
  
  
    


    $('#send_otp').on('click',function(e){
        e.preventDefault()
        
       
        // Set initial time (1 minute)
        let seconds = 0;
        let minutes = 1; // Set minutes to 1

        // Update the time display immediately
        $('#seconds').text(seconds.toString().padStart(2, '0'));
        $('#minutes').text(minutes.toString().padStart(2, '0'));

        // Create a function to handle the countdown
        const countdownInterval = setInterval(function() {
            if (minutes === 0 && seconds === 0) {
                clearInterval(countdownInterval);
                $('.time-display').html('<p class="expired-message">OTP has expired</p>');
            } else {
                if (seconds === 0) {
                    if (minutes > 0) {
                        minutes -= 1;
                        seconds = 59;
                    }
                } else {
                    seconds -= 1;
                }
                
                $('#seconds').text(seconds.toString().padStart(2, '0'));
                $('#minutes').text(minutes.toString().padStart(2, '0'));
            }
        }, 1000);
      
        let email = $('#email').val();
        $.ajax({
            url:'/auth/forgot-password',
            type:'POST',
            data:{
                'email':email,
            },
            success:function(response){
                if(response.success){
                    console.log(response)
                }
            }
        })
    })

    $('#submit_otp').on('click',function(e){
        e.preventDefault();
        let otp = $('#otp').val();
        $.ajax({
            url:'/auth/verify-otp',
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