$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#add-brand').on('click', function(event){
        event.preventDefault();

        let formData = new FormData($('#createBrandForm')[0]);

        $.ajax({
            url: '/brand-store',
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Prevent jQuery from setting the content type header, letting the browser set it automatically
            success: function(response){
                if(response.success === true){
                    $('#createBrandForm')[0].reset();
                    $('#createBrandModal').modal('hide');

                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.error('Status:', status);
                console.error('XHR:', xhr);
            }
        });
    });

})

