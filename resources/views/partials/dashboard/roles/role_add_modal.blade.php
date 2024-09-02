<div class="modal fade" id="roleCreateModal" tabindex="-1" aria-labelledby="roleCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="roleCreateModalLabel">Add Role</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="createRoleForm">
              <div class="form-group mb-2">
                <label for="name" class="form-label">Role Name</label>
                <div class="input-group">
                    <input type="text" id="name" name="name" class="form-control mb-2" value="{{ old('name') }}">
                </div>
                <div class="invalid-feedback" id="name_error">
                    <!-- Error message will be displayed here -->
                </div>
              </div>
              <div class="form-group  mb-2">
                <label for="description" class="form-label">Description</label>
                <div class="input-group">
                  <input type="text" name="description" id="description" class="form-control mb-2" value="{{ old('description') }}">
                </div>
                <div class="invalid-feedback">

                </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="add-role">Add Role</button>
        </div>
      </div>
    </div>
  </div>
