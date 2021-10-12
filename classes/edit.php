<?php include_once "../_header.php"; ?>
<?php

$id = $_GET["id"];
$class = query("SELECT * FROM tb_class WHERE id = $id")[0];

$tea = query("SELECT * FROM tb_user");
$data = explode(",", $class["teacher_id"]);


if (isset($_POST["submit"])) {
  if (edit_class($_POST) > 0) {
    echo "<script>
      document.location.href='../classes/class.php';
      </script>
      ";
  } else {
    $error = true;
    echo "
    <div class=\"row\">
      <div class=\"col-12 col-md-6\">
        <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
          <p>Failed to edit Class</p>
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
    <a href="class.php" class="btn btn-primary"><i class="fas fa-backward"></i> Back</a>
  </div>
  <!-- Awal Form  -->
  <div class="col-12 col-md-6 p-4 shadow">
    <h4>Edit Class</h4>
    <form action="" method="POST">
      <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="id " value="<?= $class["id"]; ?>" required>
      </div>

      <div class="form-group">
        <label for="class">Class Name </label>
        <input type="text" class="form-control" name="class" id="class " value="<?= $class["class_name"]; ?>" autofocus required>
      </div>

<div>
  <label>Teachers</label>
              <?php 
              $teachers = query("SELECT * FROM tb_user");
              foreach($teachers as $teacher):
              ?>
           <div class="form-check">
  <label class="form-check-label">
    <input name="teacher_id[]" class="form-check-input" type="checkbox" value="<?= $teacher["id"]?>" <?php in_array($teacher["id"], $data) ? print "checked" : null ?>>
    <?= $teacher["first_name"]." ".$teacher["last_name"]?>
  </label>
</div>
<?php endforeach;?>
</div>

      <button type="submit" class="btn btn-success m-2" style="float:right;" name="submit"><i class="fas fa-save"></i> Save Changes</button>
      <button type="reset" class="btn btn-warning m-2" style="float: right;"><i class="fas fa-redo-alt"></i> Reset</button>
    </form>
  </div>
  <!-- Akhir Form  -->
</div>
<?php include_once "../_footer.php"; ?>