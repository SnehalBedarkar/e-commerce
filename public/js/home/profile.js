$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    let button = `<button type="button" class="btn btn-primary">Add New Address</button>`

    $('#adderess_manage').on('click',function(){
        $.ajax({
            url:'/user/addresses',
            type:'GET',
            success:function(response){
                if(response.success === true){
                    if(response.addressCount === 0){
                        $("#main-content").empty();
                        $('#main-content').append();
                    }else{

                    }
                }
            }
        })
    });


})