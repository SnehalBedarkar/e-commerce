$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#add-role').on('click', function() {
        let formData = $('#createRoleForm').serialize();
        console.log(formData); // For debugging

        $.ajax({
            url: '/role-add', // Update with your server endpoint
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success === true){
                    console.log(response);
                    $('#roleCreateModal').modal('hide');

                    // Assuming 'role' comes from response
                    let role = response.role;

                    // Create a new row with role data
                    let row = `<tr data-id="${role.id}">
                                <td><input type="checkbox" class="select-checkbox" data-id="${role.id}"></td>
                                <td>${role.id}</td>
                                <td>${role.name}</td>
                                <td class="description-column">${role.description}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#roleViewModal"><i class="bi bi-eye"></i></button>
                                    <button type="button" class="btn btn-secondary btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#roleEditModal"><i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm remove-btn" data-bs-toggle="modal" data-bs-target="#roleDeleteModal"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>`;

                    // Append the new row to the table body
                    $('#roles_table tbody').append(row);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Handle errors
            }
        });
    });
});
