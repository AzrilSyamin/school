<?php include_once("../_header.php");

if (!isset($_SESSION["admin"])) {
    echo "<script>
    window.location.href='/';
    </script>";
    return false;
}


if (isset($_POST["submit"])) {
    if (add_teachers($_POST) > 0) {
        echo "<script>
        alert('Teacher Has Been Added');
        document.location.href='../teachers/teacher.php';
        </script>
        ";
    } else {
        echo "
            <div class=\"row\">
                <div class=\"col-12 col-md-6\">
                    <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
                        <p>Failed to add Teacher</p>
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
        <h4>Add New Teachers</h4>
        <a href="teacher.php" class="btn btn-primary mb-3"><i class="fas fa-backward"></i> Back</a>
        <form action="" method="POST">

            <div class="form-group">
                <label for="name">First Name *</label>
                <input type="text" class="form-control" name="first_name" id="name" autofocus required>
            </div>

            <div class="form-group">
                <label for="name">Last Name</label>
                <input type="text" class="form-control" name="last_name" id="name">
            </div>
            
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" class="form-control" name="age" id="age">
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" class="form-control">
                    <option value="">Choose...</option>
                    <option>Lelaki</option>
                    <option>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="number" class="form-control" name="phone_number" id="phone_number">
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address">
            </div>

            <div class="form-group">
                <label for="password1">Password *</label>
                <input type="password" class="form-control" name="password1" id="password1" required>
            </div>

            <div class=" form-group">
                <label for="password2">Comfirm Password *</label>
                <input type="password" class="form-control" name="password2" id="password2">
            </div>

            <div class="form-group">
                <label for="status">Status *</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="">Choose...</option>
                    <option value="1">Active</option>
                    <option value="0">Non Active</option>
                </select>
            </div>

            <div class=" form-group">
                <label for="picture">Profile Picture</label>
                <input type="file" class="form-control-file" name="picture" id="picture">
            </div>

            <button type="submit" class="btn btn-success m-2" style="float: right;" name="submit"><i class="fas fa-fw fa-plus-circle"></i> Add New Teachers</button>
            <button type="reset" class="btn btn-warning m-2" style="float: right;"><i class="fas fa-redo-alt"></i> Reset</button>
        </form>
    </div>
    <!-- Akhir Form  -->
</div>
<?php include_once("../_footer.php"); ?>