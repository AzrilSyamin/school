<?php

if (isset($_POST["submit"])) {
    if (add_students($_POST) > 0) {
        echo "<script>
      document.location.href='../students/student.php';
      </script>
      ";
    } else {
        echo "
    <div class=\"row\">
      <div class=\"col-12 col-md-6\">
        <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
          <p>Failed to Add Student</p>
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
        <a href="?page=students" class="btn btn-primary mb-3"><i class="fas fa-backward"></i> Back</a>
    </div>
    <!-- Awal Form  -->
    <div class="col-12 col-md-6 p-4 shadow">
        <h4>Add New Students</h4>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" name="name" id="name " autofocus required>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <select name="age" id="age" class="form-control">
                    <option selected value="">Choose...</option>
                    <?php
                    $levels = query("SELECT * FROM tb_stages");
                    foreach ($levels as $level) : ?>
                        <option><?= $level["student_age"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" class="form-control">
                    <option selected value="">Choose...</option>
                    <?php
                    $gender = query("SELECT * FROM tb_gender");
                    foreach ($gender as $gen) {
                        $selected = $gen["gender"] == $data["gender"] ? "selected" : null;

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
                    foreach ($classes as $class) : ?>
                        <option value="<?= $class["id"]; ?>"><?= $class["class_name"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success m-2" style="float: right;" name="submit"><i class="fas fa-fw fa-plus-circle"></i> Add New Student</button>
            <button type="reset" class="btn btn-warning m-2" style="float: right;"><i class="fas fa-redo-alt"></i> Reset</button>
        </form>
    </div>
    <!-- Akhir Form  -->
</div>