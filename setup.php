<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>School Data</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="_asset/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="_asset/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="_asset/dist/css/style.css">
  <style>
    .white {
      background-color: #FFFFFF;
      margin-top: 80px;
    }

    body {
      background-color: #F0F0F1;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- create database  -->
    <div class="row justify-content-center">
      <div class="col-md-8 white p-3 shadow">

        <?php
        if ($_GET["step"] == null || $_GET["step"] == 1) {
          require_once "create-data.php";
        } elseif ($_GET["step"] == 2) {
          require_once "create-user.php";
        }
        ?>

      </div>
    </div>

  </div>
  <!-- jQuery -->
  <script src="_asset/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="_asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="_asset/dist/js/adminlte.min.js"></script>
</body>

</html>