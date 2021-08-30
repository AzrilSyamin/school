<?php include_once("../_header.php");

if (!isset($_SESSION["admin"])) {
  echo "<script>
  window.location.href='/';
  </script>";
  return false;
}

$id = $_GET["id"];
$teachers = query("SELECT * FROM tb_teacher WHERE id = $id")[0];

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
<div class="row">
  <!-- Awal Form  -->
  <div class="col-12 col-md-6 p-4 shadow">
    <h4>Edit Teachers</h4>
    <a href="teacher.php" class="btn btn-primary"><i class="fas fa-backward"></i> Back</a>
    <?php if (isset($error)) : ?>
      <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
        <p>Failed to edit Teacher</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
    <form action="" method="POST">
      <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="id" value="<?= $teachers["id"]; ?>" required>
      </div>

      <div class="form-group">
        <label for="name">Nama :</label>
        <input type="text" class="form-control" name="name" id="name" value="<?= $teachers["teacher_name"]; ?>" required autofocus>
      </div>

      <div class="form-group">
        <label for="age">Age :</label>
        <input type="number" class="form-control" name="age" id="age" value="<?= $teachers["teacher_age"]; ?>" required>
      </div>

      <div class="form-group">
        <label for="gender">Gender :</label>
        <select name="gender" id="gender" class="form-control">
          <option <?php if ($teachers["teacher_gender"] == 'Lelaki') {
                    echo "selected";
                  } ?>>Lelaki</option>
          <option <?php if ($teachers["teacher_gender"] == 'Perempuan') {
                    echo "selected";
                  } ?>>Perempuan</option>
        </select>
      </div>

      <button type="submit" class="btn btn-success" style="float:right;" name="submit"><i class="fas fa-save"></i> Save Changes</button>
    </form>
  </div>
  <!-- Akhir Form  -->
</div>
<?php include_once("../_footer.php"); ?>