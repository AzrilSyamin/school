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
<h1>Add New Teachers</h1>
<div class="row justify-content-center">
    <!-- Awal Form  -->
    <div class="col-12 col-md-6 p-4 shadow">
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <p>Teacher is <b>not added!</b>
                    <br> Please again try later...
                </p>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nama">Nama :</label>
                <input type="text" class="form-control" name="nama" id="nama" required autofocus>
            </div>

            <div class="form-group">
                <label for="umur">Umur :</label>
                <input type="number" class="form-control" name="umur" id="umur" required>
            </div>

            <div class="form-group">
                <label for="jantina">Jantina :</label>
                <select name="jantina" id="jantina" class="form-control">
                    <option selected>Choose...</option>
                    <option>Lelaki</option>
                    <option>Perempuan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Add New Teacher</button>
        </form>
    </div>
    <!-- Akhir Form  -->
</div>
<?php include_once("../_footer.php"); ?>