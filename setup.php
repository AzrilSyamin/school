<?php
$link = __DIR__ . "/config.php";
if (file_exists($link)) {
  header("location:index.html");
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
    header("location:index.html");
  }
}
?>

<form action="" method="post">

  <div>
    <label>
      Hostname
      <input type="text" name="hostname">
    </label>
  </div>
  <div>
    <label>
      Database Name
      <input type="text" name="db_name">
    </label>
  </div>
  <div>
    <label>
      Username
      <input type="text" name="username">
    </label>
  </div>
  <div>
    <label>
      Password
      <input type="password" name="password">
    </label>
  </div>
  <div>
    <label>
      Website URL
      <input type="url" name="webUrl">
    </label>
  </div>

  <button type="submit" name="setup">Next</button>
</form>