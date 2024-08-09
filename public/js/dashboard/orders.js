$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    // let table = $('#orders_table').DataTable();

    $('.delete-btn').on('click',function(){
        let orderId = $(this).data('id');
        let row = $(this).closest('tr');
        
        $.ajax({
            url:'order/delete',
            type:'DELETE',
            data:{
                'order_id':orderId,
            },
            success:function(response){
                if(response.success){
                    row.remove();
                }
            }
        })
    })
    
});