$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#create_category').on('click', function() {
        $('#createCategoryModal').modal('show');
    });

    $('#add_category').on('click', function() {
        let formData = new FormData($('#createCategoryForm')[0]);
        $.ajax({
            url: '/category/create',
            type: 'POST',
            data: formData,
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            success: function(response) {
                if (response.success === true) {
                    console.log(response);
                    $('#createCategoryForm')[0].reset();
                    $('#createCategoryModal').modal('hide');

                    let category = response.category;
                    console.log(category);

                    // Corrected string concatenation for image path
                    let row = `<tr data-id="${category.id}">
                    <td>${category.id}</td>
                    <td>${category.name}</td>
                    <td>${category.slug}</td>
                    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${category.description}</td>
                    <td class="category_image"><img src="${category.image}" alt="${category.name}" width="70px"></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-target="#viewCategoryModal" data-bs-toggle="modal">View</button>
                        <button class="btn btn-secondary btn-sm" data-bs-target="#editCategoryModal" data-bs-toggle="modal">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-bs-target="#deleteCategoryModal" data-bs-toggle="modal">Delete</button>
                    </td>
                </tr>`;
                    $('#categories_table tbody').append(row);
                } else {
                    alert('Category creation failed.');
                }
            },
            error: function(xhr) {
                console.error('AJAX request failed:', xhr);
                alert('An error occurred. Please try again.');
            }
        });
    });

    let category_id; // Define category_id as a global variable

    // Event listener for the delete button
    $("#categories_table tbody").on('click', '.delete-btn', function() {
        category_id = $(this).closest('tr').data('id'); // Assign the category_id
        $('#categoryDeleteModal').modal('show'); // Show the delete confirmation modal
    });

    // Event listener for the delete confirmation button
    $('#confirmCategoryDelete').on('click', function() {
        $.ajax({
            url: '/category/delete',
            type: 'DELETE',
            data: { 'category_id': category_id }, // Use the category_id from the global variable
            success: function(response) {
                // Handle success (e.g., remove the row from the table)
                if (response.success) {
                    $('tr[data-id="' + category_id + '"]').remove(); // Remove the row from the table
                    $('#categoryDeleteModal').modal('hide'); // Hide the modal
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error("Error deleting category: ", error);
            }
        });
    });

    $('#categories_table').on('click','.edit-btn',function(){
        $('#editCategoryModal').modal('show');
        category_id = $(this).closest('tr').data('id');
        $.ajax({
            url:'/category/show',
            type:'GET',
            data:{'category_id':category_id},
            success:function(response){
                if(response.success === true){
                    console.log(response);
                }
            }
        })
    })
});

