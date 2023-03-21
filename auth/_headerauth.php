<?php require_once "../function.php";

if (isset($_SESSION["admin"])) {
  $login = $_SESSION["admin"];
} elseif (isset($_SESSION["moderator"])) {
  $login = $_SESSION["moderator"];
} elseif (isset($_SESSION["member"])) {
  $login = $_SESSION["member"];
}

if (isset($login)) {
  echo "<script>
  window.location='" . myUrl() . "'
  </script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>School Data</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= myUrl("_asset/plugins/fontawesome-free/css/all.min.css") ?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= myUrl("_asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css") ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= myUrl("_asset/dist/css/adminlte.min.css") ?>">
</head>