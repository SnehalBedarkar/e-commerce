$(document).ready(function(){

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    let userId ;

    $('.remove-btn').on('click',function(){
         userId = $(this).data('user-id');
        $('#deleteModal').modal('show');
    })

    $('#confirmDelete').on('click',function(){
        if(userId){
            $.ajax({
                url:'/user/delete',
                type:'DELETE',
                data:{
                    'user_id':userId,
                },
                success:function(response){
                    if(response.success){
                       $('#deleteModal').modal('hide');
                       $('tr[data-id="'+ userId +'"]').remove();

                    }
                }
            })
        }
    });
   
    $('#select')

})