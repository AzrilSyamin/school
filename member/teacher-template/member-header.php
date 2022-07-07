<?php
require_once "../function.php";


if (isset($_SESSION["member"])) {
  $login = $_SESSION["member"]["roleid"];
} else {
  if (isset($_SESSION["admin"])) {
    echo "<script>
      window.location.href='" . myUrl("dashboard/") . "'
      </script>";
  } elseif (isset($_SESSION["moderator"])) {
    echo "<script>
      window.location.href='" . myUrl("moderator/") . "'
      </script>";
  } else {
    echo "<script>
      window.location.href='" . myUrl("auth/logout.php") . "'
      </script>";
  }
}

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

  <title>Member</title>

</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5 text-center">
        <h1>Welcome Back Teacher</h1>
      </div>
    </div>
    <div class="row shadow mt-5">
      <div class="col-12">
        <div class="row">
          <div class="col-12">
            <h2>Management</h2>
          </div>
          <div class="col-md-4 col-sm-12">
            <div class="list-group">
              <a href="<?= myUrl("member/index.php?page=") ?> myprofile" class="list-group-item list-group-item-action">My Profile</a>
              <a href="<?= myUrl("member/index.php?page=") ?>teachers" class="list-group-item list-group-item-action">Teachers</a>
              <a href="<?= myUrl("member/index.php?page=") ?>subjects" class="list-group-item list-group-item-action">Subjects</a>
              <a href="<?= myUrl("member/index.php?page=") ?>students" class="list-group-item list-group-item-action">Students</a>
              <a href="<?= myUrl("member/index.php?page=") ?>classes" class="list-group-item list-group-item-action">Classes</a>
              <a href="<?= myUrl("auth/logout.php") ?>" class="list-group-item list-group-item-action">Log Out</a>
            </div>
          </div>
          <div class="col-md">