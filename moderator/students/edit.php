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
    echo "
    <div class=\"row\">
      <div class=\"col-12 col-md-6\">
        <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
          <p>Failed to Edit Student</p>
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
          </button>
        </div>
      </div>
    </div>
    ";
  }
}
?>

<!-- Page Heading -->
<div class="row">
  <div class="col-12 mb-3">
    <a href="?page=students" class="btn btn-primary"><i class="fas fa-backward"></i> Back</a>
  </div>
  <!-- Awal Form  -->
  <div class="col-12 col-md-6 p-4 shadow">
    <h4>Edit Students</h4>
    <form action="" method="POST">
      <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="id " value="<?= $students["id"]; ?>" autofocus required>
      </div>

      <div class="form-group">
        <label for="name">Nama</label>
        <input type="text" class="form-control" name="name" id="name " value="<?= $students["student_name"]; ?>" autofocus required>
      </div>

      <div class="form-group">
        <label for="age">Age</label>
        <select name="age" id="age" class="form-control">
          <option value="">Choose...</option>
          <?php
          $levels = query("SELECT * FROM tb_stages");
          foreach ($levels as $level) {
            $selected = $level["student_age"] == $students["student_age"] ? "selected" : null;

            echo '<option value="' . $level["student_age"] . '" ' . $selected . '>' . $level["student_age"] . '</option>';
          } ?>
        </select>
      </div>

      <div class="form-group">
        <label for="gender">Gender</label>
        <select name="gender" id="gender" class="form-control">
          <option value="">Choose...</option>
          <?php
          $gender = query("SELECT * FROM tb_gender");
          foreach ($gender as $gen) {
            $selected = $gen["gender"] == $students["student_gender"] ? "selected" : null;

            echo '<option value="' . $gen["gender"] . '" ' . $selected . '>' . $gen["gender"] . '</option>';
          } ?>
        </select>
      </div>

      <div class="form-group">
        <label for="class">Class *</label>
        <select name="class" id="class" class="form-control" required>
          <option value="">Choose...</option>
          <?php
          $classes = query("SELECT * FROM tb_class");
          foreach ($classes as $class) {
            $selected = $class["id"] == $students["class_id"] ? "selected" : null;

            echo  '<option value="' . $class["id"] . '" ' . $selected . '>' . $class["class_name"] . '</option>';
          } ?>
        </select>
      </div>

      <button type="submit" class="btn btn-success m-2" style="float:right;" name="submit"><i class="fas fa-save"></i> Save Changes</button>
      <button type="reset" class="btn btn-warning m-2" style="float: right;"><i class="fas fa-redo-alt"></i> Reset</button>
    </form>
  </div>
  <!-- Akhir Form  -->
</div>