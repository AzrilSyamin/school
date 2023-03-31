<?php
require_once "function.php";

if (isset($_POST["admin"])) {
  require_once "create.php";
  if (setup_step_two($_POST) > 0) {
    header("location:dashboard/");
  }
}

$check_users = mysqli_query($con, "SELECT * FROM tb_user");
if (mysqli_num_rows($check_users) > 0) {
  header("location:dashboard/");
}

?>
<p>Below you should enter your user admin details.
</p>

<form action="" method="post" class="row">

  <div class="form-group col-md-6">
    <label for="firstname">First Name</label>
    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?= $_POST ? $_POST["first_name"] : null; ?>" required>
  </div>
  <div class="form-group col-md-6">
    <label for="lastname">Last Name</label>
    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?= $_POST ? $_POST["last_name"] : null; ?>" required>
  </div>
  <div class="form-group col-md-6">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= $_POST ? $_POST["username"] : null; ?>" required>
  </div>
  <div class="form-group col-md-6">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com" value="<?= $_POST ? $_POST["email"] : null; ?>" required>
  </div>
  <div class="form-group col-md-6">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  <div class="form-group col-md-6">
    <label for="password2">Confirm Password</label>
    <input type="password" class="form-control" id="password2" name="password2" required>
  </div>
  <div class="form-group col-md-6">
    <button type="submit" class="btn btn-outline-primary" name="admin">Submit</button>
  </div>
</form>