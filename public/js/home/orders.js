$(document).ready(function(){

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#orders_table').DataTable();


    $('#submit_status').on('click', function() {
        let selectedStatuses = [];
        $('#orders_status input[name="orders_status[]"]:checked').each(function() {
            selectedStatuses.push($(this).val());
        });

        console.log(selectedStatuses);
        $.ajax({
            url: '/orders/status',
            type: 'GET',
            data: {
                statuses: selectedStatuses,
            },
            success: function(response) {
                if (response.success) {
                    console.log(response.success);
                    $('#main_content').html('');
                }
            },
            error: function(response) {
                console.error(response);
            }
        });
    });
});