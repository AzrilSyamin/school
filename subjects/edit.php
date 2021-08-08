<?php include_once "../_header.php"; ?>
<?php

$id = $_GET["id"];
$subjects = query("SELECT * FROM tb_pelajaran WHERE id = $id")[0];


if (isset($_POST["submit"])) {
  if (edit_subjects($_POST) > 0) {
    echo "<script>
      
      document.location.href='../subjects/subject.php';
      </script>
      ";
  } else {
    $error = true;
  }
}
?>

<!-- Page Heading -->
<h1>Edit Subjects</h1>
<a href="subject.php" class="btn btn-primary">Back</a>
<div class="row justify-content-center">
  <!-- Awal Form  -->
  <div class="col-12 col-md-6 p-4 shadow">
    <?php if (isset($error)) : ?>
      <div class="alert alert-danger" role="alert">
        <p>Subjects is <b>not edit!</b>
          <br> Please again try later...
        </p>
      </div>
    <?php endif; ?>
    <form action="" method="POST">
      <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="id " value="<?= $subjects["id"]; ?>" required>
      </div>

      <div class="form-group">
        <label for="mata">Nama Mata Pelajaran :</label>
        <input type="text" class="form-control" name="mata" id="mata " value="<?= $subjects["mata_pelajaran"]; ?>" autofocus required>
      </div>

      <div class="form-group">
        <label for="idcikgu">Name Cikgu :</label>

        <select name="idcikgu" id="idcikgu" class="form-control">
          <option selected>Choose...</option>
          <?php
          $teachers = query("SELECT * FROM tb_cikgu");
          foreach ($teachers as $teacher) : ?>
            <option value="<?= $teacher["id"]; ?>"><?= $teacher["nama_cikgu"]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary" name="submit">Edit Subject</button>
    </form>
  </div>
  <!-- Akhir Form  -->
</div>
<?php include_once "../_footer.php"; ?>