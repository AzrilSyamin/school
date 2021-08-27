<?php include_once("../_header.php"); ?>
<?php

$id = $_GET["id"];
$teachers = query("SELECT * FROM tb_cikgu WHERE id = $id")[0];

if (isset($_POST["submit"])) {
  if (edit_teachers($_POST) > 0) {
    echo "<script>
        
        document.location.href='../teachers/teacher.php';
        </script>
        ";
  } else {
    $error = true;
  }
}

?>
<!-- Page Heading -->
<h3>Edit Teachers</h3>
<a href="teacher.php" class="btn btn-primary">Back</a>
<div class="row">
  <!-- Awal Form  -->
  <div class="col-12 col-md-6 p-4 shadow">
    <?php if (isset($error)) : ?>
      <div class="alert alert-danger" role="alert">
        <p>Teacher is <b>not edit!</b>
          <br> Please again try later...
        </p>
      </div>
    <?php endif; ?>
    <form action="" method="POST">
      <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="id" value="<?= $teachers["id"]; ?>" required>
      </div>

      <div class="form-group">
        <label for="nama">Nama :</label>
        <input type="text" class="form-control" name="nama" id="nama" value="<?= $teachers["nama_cikgu"]; ?>" required autofocus>
      </div>

      <div class="form-group">
        <label for="umur">Umur :</label>
        <input type="number" class="form-control" name="umur" id="umur" value="<?= $teachers["umur_cikgu"]; ?>" required>
      </div>

      <div class="form-group">
        <label for="jantina">Jantina :</label>
        <select name="jantina" id="jantina" class="form-control">
          <option <?php if($teachers["jantina_cikgu"] == 'Lelaki'){ echo"selected";}?>>Lelaki</option>
          <option <?php if($teachers["jantina_cikgu"] == 'Perempuan'){ echo"selected";}?>>Perempuan</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary" name="submit">Edit Teacher</button>
    </form>
  </div>
  <!-- Akhir Form  -->
</div>
<?php include_once("../_footer.php"); ?>