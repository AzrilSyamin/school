<?php include_once "../_header.php"; ?>
<?php

if (isset($_POST["submit"])) {
    if (add_subjects($_POST) > 0) {
        echo "<script>
      document.location.href='../subjects/subject.php';
      </script>
      ";
    } else {
        echo "
    <div class=\"row\">
      <div class=\"col-12 col-md-6\">
        <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
          <p>Failed to Add Subjects</p>
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
    <!-- Awal Form  -->
    <div class="col-12 col-md-6 p-4 shadow">
        <h4>Add New Subjects</h4>
        <a href="subject.php" class="btn btn-primary mb-3"><i class="fas fa-backward"></i> Back</a>
        <form action="" method="POST">
            <div class="form-group">
                <label for="subjects">Subjects Name :</label>
                <input type="text" class="form-control" name="subjects" id="subjects " autofocus required>
            </div>

            <button type="submit" class="btn btn-success m-2" style="float: right;" name="submit"><i class="fas fa-fw fa-plus-circle"></i> Add New Subject</button>
            <button type="reset" class="btn btn-warning m-2" style="float: right;"><i class="fas fa-redo-alt"></i> Reset</button>
        </form>
    </div>
    <!-- Akhir Form  -->
</div>
<?php include_once "../_footer.php"; ?>