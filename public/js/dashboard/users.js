$(document).ready(function(){

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });


    var userId;
    let row
    // Show the delete modal when the remove button is clicked
    $('#users_table').on('click','.remove-btn', function() {
        userId = $(this).data('user-id');
        row = $(this).closest('tr');
        $('#userDeleteModal').modal('show');
    });
    
        // Handle the delete confirmation
    $('#confirmUserDelete').on('click', function() {
        if (userId) {
            $.ajax({
                url: '/user/delete',
                type: 'DELETE',
                data: {
                    'user_id': userId,
                },
                success: function(response) {
                    if (response.success) {
                        $('#userDeleteModal').modal('hide');
                        row.remove()
                    }
                }
            });
        }
    });

    let selectedUserIds = [];

    // Select/Deselect all checkboxes
    $('#select_all').on('change', function() {
        let isChecked = $(this).prop('checked');
        $('.select-checkbox').prop('checked', isChecked);
        updateSelectedUserIds();
    });

    // Update selected user IDs when any checkbox changes
    $(document).on('change', '.select-checkbox', function() {
        updateSelectedUserIds();
    });

    function updateSelectedUserIds() {
        selectedUserIds = [];
        $('.select-checkbox:checked').each(function() {
            selectedUserIds.push($(this).data('id'));
        });
    }

    // Handle multiple delete button click
    $('#multipleDeleteBtn').on('click', function() {
        if (selectedUserIds.length > 0) {
            $('#deleteModal').modal('show');
        } else {
            alert('Please select at least one user to delete.');
        }
    });

    // Confirm deletion in modal
    $('#confirmMultipleDelete').on('click', function() {
        if (selectedUserIds.length > 0) {
            $.ajax({
                url: '/users/multiple-delete',
                type: 'GET',
                data: {
                    user_ids: selectedUserIds,
                },
                success: function(response) {
                    if (response.success) {
                        $('#multipleDeleteModal').modal('hide');
                        // Remove deleted rows from table
                        selectedUserIds.forEach(function(id) {
                            $('#users_table').find('tr[data-id="' + id + '"]').remove();
                        });
                        selectedUserIds = [];
                    } else {
                        alert('An error occurred while deleting the users.');
                    }
                }
            });
        }
    });

    let query = '';
    let startDate = '';
    let endDate = '';
   
    $('#searchQuery').on('input', function() {
        query = $(this).val();
        search();
    })

    
    $('#search_button').on('click',function(){
        startDate = $('#start_date').val();
        console.log(startDate);
        endDate = $('#end_date').val();
        console.log(startDate);
        search();
    });

    function search(){
        $.ajax({
            url: '/users/search',
            type: 'GET',
            data: {
                'query': query,
                'start_date':startDate,
                'end_date' : endDate
            },
            success: function(response) {
                console.log('Response:', response);
                let tbody = $('#users_table tbody');
                tbody.empty(); // Clear existing rows
                
                if (response.success) {
                    let users = response.users;
                    if (Array.isArray(users) && users.length === 0) {
                        tbody.append('<tr><td colspan="8">No users found.</td></tr>');
                    } else {
                        users.forEach((user) => {
                            tbody.append(`
                                <tr data-id="${user.id}">
                                    <td><input type="checkbox" class="select-checkbox" data-id="${user.id}"></td>
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.is_active}</td>
                                    <td>${user.email}</td>
                                    <td>${user.role}</td>
                                    <td>${user.phone_number}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger remove-btn" data-bs-target="#deleteModal" data-bs-toggle="modal" data-user-id="${user.id}">Delete</button>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                } else {
                    console.log('No success:', response);
                    tbody.append('<tr><td colspan="8">No users found.</td></tr>');
                    $('#multipleDeleteBtn').hide();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                let tbody = $('#users_table tbody');
                tbody.empty(); // Clear existing rows
                tbody.append('<tr><td colspan="8">Error loading data.</td></tr>');   
            }
        });
    }
    
    
})