<?php
require "_headerauth.php";
?>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="<?= myUrl() ?>" class="h1"><b>School</b> Data</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Confirm Password" name="password2">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block" name="submit">Change password</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="<?= myUrl("auth/login.php") ?> ">Login</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  <?php require "_footerauth.php"; ?>