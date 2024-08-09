$(document).ready(function(){

    
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:'/orders/chart',
        type:'GET',
        success: function(response) {
            var ctx = $('#ordersChart').get(0).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line', // Can be 'line', 'bar', 'radar', etc.
                data: {
                    labels: response.labels, // Data from the AJAX response
                    datasets: [{
                        label: 'Orders',
                        data: response.values, // Data from the AJAX response
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    })

    $.ajax({
        url:'/users/chart',
        type:'GET',
        success: function(response) {
            var ctx = $('#usersChart').get(0).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line', // Can be 'line', 'bar', 'radar', etc.
                data: {
                    labels: response.labels, // Data from the AJAX response
                    datasets: [{
                        label: 'users',
                        data: response.values, // Data from the AJAX response
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    })

    $('#logout_button').on('click',function(){
        let userId = $(this).data('user-id');
        console.log(userId);

        $.ajax({
            url:'auth/logout',
            type:'POST',
            data:{
                'user_id':userId,
            },
            success:function(response){
                window.location.href = response.redirect_url;
            }
        })
    })

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

    function updateActiveUsersCount(){
        $.ajax({
            url:'/active/users',
            type:'GET',
            success:function(response){
                if(response.success){
                    $('#activeUserCount').text(response.activeUsersCount)
                }
            }
        })
    }

    $('#refresh_button').on('click',function(){
        updateActiveUsersCount();
    })
    
});