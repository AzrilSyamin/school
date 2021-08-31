<?php include_once "../_header.php"; ?>
<?php

$id =  $_GET["id"];
$students = query("SELECT * FROM tb_student WHERE id = $id")[0];

if (isset($_POST["submit"])) {
  if (edit_students($_POST) > 0) {
    echo "<script>
      document.location.href='../students/student.php';
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
    <h4>Edit Students</h4>
    <a href="student.php" class="btn btn-primary"><i class="fas fa-backward"></i> Back</a>
    <?php if (isset($error)) : ?>
      <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
        <p>Failed to edit Student</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
    <form action="" method="POST">
      <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="id " value="<?= $students["id"]; ?>" autofocus required>
      </div>

      <div class="form-group">
        <label for="name">Nama :</label>
        <input type="text" class="form-control" name="name" id="name " value="<?= $students["student_name"]; ?>" autofocus required>
      </div>

      <div class="form-group">
        <label for="age">Age :</label>
        <select name="age" id="age" class="form-control">
          <option selected>Choose...</option>
          <?php
          $levels = query("SELECT * FROM tb_stages");
          foreach ($levels as $level) : ?>
            <option><?= $level["student_age"]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="gender">Gender :</label>
        <select name="gender" id="gender" class="form-control">
          <option selected>Choose...</option>
          <option>Lelaki</option>
          <option>Perempuan</option>
        </select>
      </div>

      <div class="form-group">
        <label for="class">Class :</label>
        <select name="class" id="class" class="form-control">
          <option selected>Choose...</option>
          <?php
          $classes = query("SELECT * FROM tb_class");
          foreach ($classes as $class) : ?>
            <option value="<?= $class["id"]; ?>"><?= $class["class_name"]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="teacher">Teacher :</label>
        <select name="teacher" id="teacher" class="form-control">
          <option selected>Choose...</option>
          <?php
          $teachers = query("SELECT * FROM tb_user");
          foreach ($teachers as $teacher) : ?>
            <option value="<?= $teacher["id"]; ?>"><?= "Cikgu" . " " . $teacher["first_name"] . " " . $teacher["last_name"]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-success m-2" style="float:right;" name="submit"><i class="fas fa-save"></i> Save Changes</button>
      <button type="reset" class="btn btn-warning m-2" style="float: right;"><i class="fas fa-redo-alt"></i> Reset</button>
    </form>
  </div>
  <!-- Akhir Form  -->
</div>
<?php include_once "../_footer.php"; ?>