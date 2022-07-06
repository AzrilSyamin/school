<?php
require_once "../function.php";
if (isset($_SESSION["moderator"])) {
  $login = $_SESSION["moderator"]["roleid"];
} else {
  if (isset($_SESSION["admin"])) {
    echo "<script>
      window.location.href='" . myUrl("dashboard/") . "'
      </script>";
  } elseif (isset($_SESSION["member"])) {
    echo "<script>
      window.location.href='" . myUrl("member/") . "'
      </script>";
  } else {
    echo "<script>
      window.location.href='" . myUrl("auth/logout.php") . "'
      </script>";
  }
}

$query = mysqli_query($con, "SELECT * FROM tb_user 
                              JOIN tb_role 
                              ON tb_user.role_id = tb_role.role_id 
                              WHERE tb_user.id = '$login'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= myUrl("_asset/plugins/fontawesome-free/css/all.min.css") ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= myUrl("_asset/dist/css/adminlte.min.css") ?>">

  <link rel="stylesheet" href="<?= myUrl("_asset/dist/css/style.css") ?>">

  <title>Moderator</title>

</head>

<body>
  <div class="container">

    <!-- main content  -->
    <div class="row justify-content-center">
      <div class="col-12">

        <!-- title and profile -->
        <div class="row">
          <div class="col-sm-6 col-12 mt-md-3 px-4 py-3">
            <a href="<?= myUrl("auth/logout.php") ?>" class="badge badge-success mb-3 py-1 px-2">Log Out</a>
            <h4>Hi <?= $data["first_name"] . " " . $data["last_name"] ?></h4>
            <p>Choose item to manage</p>
          </div>
          <div class="col-sm-6 col-12 mt-md-3">
            <div class="row justify-content-center">
              <a href="?page=myprofile" class="col-5 m-1 py-4 text-center border rounded-sm shadow btn">
                <div class="row">
                  <div class="col-12">
                    <img src="../../img/default.jpg" class="rounded" alt="teacher-icon">
                  </div>
                  <div class="col-12 mt-2">
                    <p>My Profile</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
        <!-- end title and profile -->

        <!-- content  -->