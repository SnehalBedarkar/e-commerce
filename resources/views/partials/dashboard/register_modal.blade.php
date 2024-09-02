<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="registerModalLabel">Register</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="register_form">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    </div>
                    <div id="register_name_error" class="text-danger register_error"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="register_email" class="form-label">Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="register_email"  name="email" value="{{ old('register_email') }}" autocomplete="username">
                    </div>
                    <div id="register_email_error" class="text-danger register_error"></div>
                </div>

                <div class=" form-group mb-3">
                    <label for="register_password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="register_password" name="password" autocomplete="new-password" required>
                        <span class="input-group-text" id="togglePassword">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div id="register_password_error" class="text-danger register_error"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>
                        <span class="input-group-text" id="togglePasswordConfirmation">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div id="password_confirmation_error" class="text-danger register_error"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                    </div>
                    <div id="phone_number_error" class="text-danger register_error"></div>
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select name="role_id" id="role" class="form-select">
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="register_button">Register</button>
        </div>
      </div>
    </div>
  </div>
