<?php include_once "../_header.php"; ?>
<?php

if (isset($_POST["submit"])) {
    if (add_class($_POST) > 0) {
        echo "<script>
      document.location.href='../classes/class.php';
      </script>
      ";
    } else {
        echo "
        <div class=\"row\">
      <div class=\"col-12 col-md-6\">
            <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
                <p>Failed to add Class</p>
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>
        ";
    }
}
?>

<!-- Page Heading -->
<div class="row">
    <div class="col-12 mb-3">
        <a href="class.php" class="btn btn-primary mb-3"><i class="fas fa-backward"></i> Back</a>
    </div>
    <!-- Awal Form  -->
    <div class="col-12 col-md-6 p-4 shadow">
        <h4>Add New Class</h4>
        <form action="" method="POST">
            <div class="form-group">
                <label for="class">Class Name :</label>
                <input type="text" class="form-control" name="class" id="class " autofocus required>
            </div>

            <button type="submit" class="btn btn-success m-2" style="float: right;" name="submit"><i class="fas fa-fw fa-plus-circle"></i> Add New Class</button>
            <button type="reset" class="btn btn-warning m-2" style="float: right;"><i class="fas fa-redo-alt"></i> Reset</button>
        </form>
    </div>
    <!-- Akhir Form  -->
</div>
<?php include_once "../_footer.php"; ?>