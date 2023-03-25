<?php
$link = __DIR__ . "/config.php";
if (file_exists($link)) {
  header("location:setup.php?step=2");
}

if (isset($_POST["setup"])) {
  require_once "create.php";
  create_config();
  require_once "config.php";

  $con = mysqli_connect($host, $user, $pass);
  if (!$con) {
    echo "<p style=\"color:red;text-align:center\">Failed To Connect</p>" . mysqli_connect_error();
  }

  $create_db = "CREATE DATABASE IF NOT EXISTS $db_name";
  if (!mysqli_query($con, $create_db) === true) {
    echo "<p style=\"color:red;text-align:center\">Failed To Create Database :</p>" . mysqli_error($con);
  } else {
    $con = mysqli_connect($host, $user, $pass, $db_name) or die(mysqli_error($con));
    create_tabel();
    insert_table_data();
    header("location:setup.php?step=2");
  }
}

?>
<p>Below you should enter your database connection details. If you are not sure about these, contact your host.
</p>

<form action="" method="post">

  <div class="form-group row">
    <div class="col-md-3">
      <label for="db_name">Database Name</label>
    </div>
    <div class="col-md-5">
      <input type="text" name="db_name" class="form-control" id="db_name" placeholder="database name" required>
    </div>
    <div class="col-md-4">
      <small id="emailHelp" class="form-text text-muted">The name of the database you want to use.</small>
    </div>
  </div>

  <div class="form-group row">
    <div class="col-md-3">
      <label for="username">Username</label>
    </div>
    <div class="col-md-5">
      <input type="text" name="username" class="form-control" id="username" placeholder="username" required>
    </div>
    <div class="col-md-4">
      <small id="emailHelp" class="form-text text-muted">Your database username.</small>
    </div>
  </div>

  <div class="form-group row">
    <div class="col-md-3">
      <label for="password">Password</label>
    </div>
    <div class="col-md-5">
      <input type="password" name="password" class="form-control" id="password" placeholder="password">
    </div>
    <div class="col-md-4">
      <small id="emailHelp" class="form-text text-muted">Your database password.</small>
    </div>
  </div>

  <div class="form-group row">
    <div class="col-md-3">
      <label for="hostname">Database Host</label>
    </div>
    <div class="col-md-5">
      <input type="text" name="hostname" class="form-control" id="hostname" placeholder="localhost" value="localhost" required>
    </div>
    <div class="col-md-4">
      <small id="emailHelp" class="form-text text-muted">You should be able to get this info
        from your web host,
        if localhost does not work.</small>
    </div>
  </div>



  <div class="form-group row">
    <div class="col-md-3">
      <label for="webUrl">Website URL</label>
    </div>
    <div class="col-md-5">
      <input type="url" name="webUrl" class="form-control" id="webUrl" placeholder="https://example.com" required>
    </div>
    <div class="col-md-4">
      <small id="emailHelp" class="form-text text-muted">Your website url</small>
    </div>
  </div>

  <button type="submit" name="setup" class="btn btn-outline-primary">Continue</button>
</form>