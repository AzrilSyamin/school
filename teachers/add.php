<?php include_once("../_header.php"); ?>
<?php

if (isset($_POST["submit"])) {
    if (add_teachers($_POST) > 0) {
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
        <h4>Add New Teachers</h4>
        <a href="teacher.php" class="btn btn-primary mb-3"><i class="fas fa-backward"></i> Back</a>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
                <p>Failed to add Teacher</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Nama :</label>
                <input type="text" class="form-control" name="name" id="name" required autofocus>
            </div>

            <div class="form-group">
                <label for="age">Age :</label>
                <input type="number" class="form-control" name="age" id="age" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender :</label>
                <select name="gender" id="gender" class="form-control">
                    <option selected>Choose...</option>
                    <option>Lelaki</option>
                    <option>Perempuan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="float: right;" name="submit"><i class="fas fa-fw fa-plus-circle"></i> Add New Teachers</button>
        </form>
    </div>
    <!-- Akhir Form  -->
</div>
<?php include_once("../_footer.php"); ?>