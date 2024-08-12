<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="login_form">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="login_email" name="login_email" autocomplete="username"  required>
                    <div id="login_email_error" class="text-danger"></div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="login_password" name="login_password" autocomplete="current-password" required>
                    <div id="login_password_error" class="text-danger"></div>
                </div>
                <div class="form-group mt-2">
                  <input type="checkbox" id="remember_me" name="remember_me">
                  <label for="remember_me" class="form-lable">Remember Me</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="login_button">Login</button>
        </div>
      </div>
    </div>
  </div>