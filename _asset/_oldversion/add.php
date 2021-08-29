<?php
require_once("function.php");

$students = query("SELECT * FROM tb_student
                 
                 JOIN tb_teacher
                 ON tb_student.teacher_id = tb_teacher.id
                 
                 JOIN tb_class
                 ON tb_student.class_id = tb_class.id
                 
                 JOIN tb_stages
                 ON tb_student.student_age = tb_stages.student_age
             
                 
                 ");

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


  <title>Add | Sekolah</title>
</head>

<body>
  <div class="container mt-5">

    <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand" href="#">My Logo</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" href="/">Home</a>
          <a class="nav-link" href="detail.php">Students Detail</a>
        </div>
      </div>

    </nav>

  </div>


  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2>Add Students</h2>
        <hr>
      </div>
      <!-- Awal Table  -->
      <div class="col-6">
        <form>
          <div class="form-group">
            <label for="name">Nama :</label>
            <input type="text" class="form-control" name="name" id="name">
          </div>

          <div class="form-group">
            <label for="age">Age :</label>
            <input type="number" class="form-control" name="age" id="age">
          </div>

          <div class="form-group">
            <label for="gender">Gender :</label>
            <input type="text" class="form-control" name="gender" id="gender">
          </div>

          <div class="form-group">
            <label for="pelajaran">Subjects :</label>
            <select id="pelajaran" class="form-control">
              <option selected>Choose...</option>
              <option>No1</option>
              <option>No2</option>
              <option>No3</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary" name="submit">Add New Student</button>
        </form>
      </div>
      <!-- Akhir Table  -->

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