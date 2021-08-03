<?php
require_once("function.php");


$id = $_GET["id"];

$teachers = query("SELECT * FROM tb_pelajar
                 LEFT JOIN tb_cikgu
                 ON tb_pelajar.id = tb_cikgu.id
                 JOIN tb_kelas
                 ON tb_pelajar.kelas_id = tb_kelas.id
                 JOIN tb_darjah
                 ON tb_pelajar.umur_pelajar = tb_darjah.umur_pelajar
                 WHERE tb_cikgu.id = $id");

var_dump($teachers);

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Bootstrap CSS OFFLINE -->
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    
    <!--External CSS-->
    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap ICON -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"> -->

    <!-- Bootstrap ICON OFFLINE-->
    <link rel="stylesheet" href="font/bootstrap-icons.css">


    <title>Home | Sekolah</title>
  </head>
  <body>
  <div class="container mt-5">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Your Logo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
        <a class="nav-link" href="/">Home</a>
        <a class="nav-link" href="cikgu.php">Cikgu</a>
        </div>
    </div>
    </nav>
</div>


<div class="container">
<div class="row">
    <div class="col-12">
    <h1>Profile Cikgu</h1>
    <a href="/" class="btn btn-primary">Back</a>
    </div>
    
    <?php foreach($teachers as $teacher):?>
    <div class="col-12 col-sm-6 col-md-4 my-3">
    <ul class="list-group shadow">
  <li class="list-group-item"><b>Name :</b><?= $teacher["nama_cikgu"];?></li>
  <li class="list-group-item"><b>Umur :</b><?= $teacher["umur_cikgu"];?></li>
  <li class="list-group-item"><b>Jantina :</b><?= $teacher["jantina_cikgu"];?></li>
    </ul>
    </div>
  <?php endforeach;?>
    
</div>
</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- JavaScript OFFLINE -->
    <script src="dist/js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
  </body>
</html>