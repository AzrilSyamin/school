<?php include_once "../_header.php"; ?>
<?php

$id = $_GET["id"];
$subjects = query("SELECT * FROM tb_subjects WHERE id = $id")[0];


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
<div class="row">
  <!-- Awal Form  -->
  <div class="col-12 col-md-6 p-4 shadow">
    <h4>Edit Subjects</h4>
    <a href="subject.php" class="btn btn-primary"><i class="fas fa-backward"></i> Back</a>
    <?php if (isset($error)) : ?>
      <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
        <p>Failed to edit Subjects</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
    <form action="" method="POST">
      <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="id " value="<?= $subjects["id"]; ?>" required>
      </div>

      <div class="form-group">
        <label for="subjects">Subjects Name :</label>
        <input type="text" class="form-control" name="subjects" id="subjects " value="<?= $subjects["subjects_name"]; ?>" autofocus required>
      </div>

      <div class="form-group">
        <label for="teacher">Teacher Name :</label>

        <select name="teacher" id="teacher" class="form-control">
          <option selected>Choose...</option>
          <?php
          $teachers = query("SELECT * FROM tb_user");
          foreach ($teachers as $teacher) : ?>
            <option value="<?= $teacher["id"]; ?>"><?= "Cikgu" . " " . $teacher["first_name"] . " " . $teacher["last_name"]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-success" style="float:right;" name="submit"><i class="fas fa-save"></i> Save Changes</button>
    </form>
  </div>
  <!-- Akhir Form  -->
</div>
<?php include_once "../_footer.php"; ?>