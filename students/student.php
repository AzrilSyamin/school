<?php include_once "../_header.php"; ?>
<?php

$students = query("SELECT * FROM tb_class 
RIGHT JOIN tb_student 
ON tb_student.class_id = tb_class.id");

if (isset($_POST["search"])) {
    if (!$students = search_student($_POST["searchbox"])) {
        $noData = true;
    }
}
?>

<!-- search form  -->
<div class="row">
    <div class="col-12">
        <form action="" method="post">
            <div class="input-group mb-3 shadow">
                <input type="text" class="form-control" name="searchbox" autocomplete="off">
                <div class="input-group-append">
                    <button class="btn btn-warning border-dark" type="submit" name="search">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- end search form  -->

<!-- Page Heading -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- First Header Table  -->
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h4>List Of Students</h4>
                    </div>
                    <div class="col-12 col-sm-6">
                        <a href="add.php" class="btn btn-success float-md-right"><i class="fas fa-fw fa-plus-circle"></i> Add New Students</a>
                    </div>
                </div>
            </div>
            <!-- End Header Table  -->
            <!-- Awal Table  -->
            <div class="table-responsive shadow">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Age</th>
                            <th scope="col">Class</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($students as $student) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= $student["student_name"]; ?></td>
                                <td><?= $student["student_gender"]; ?></td>
                                <td><?= $student["student_age"]; ?></td>
                                <td><?= $student["class_name"]; ?>
                                </td>
                                <td>

                                    <a class="badge badge-warning" href="edit.php?id=<?= $student["id"]; ?>"><i class="fas fa-edit"></i></i></a>
                                    <?php if (isset($_SESSION["admin"])) { ?>
                                        <a class="badge badge-danger" href="del.php?id=<?= $student["id"]; ?>" onclick="return confirm('Are You Sure Want To Delete?');"><i class="far fa-trash-alt"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (isset($noData)) : ?>
                    <p class="text-center">No Result !</p>
                <?php endif; ?>
            </div>
            <!-- Akhir Table  -->
        </div>
    </div>
</div>
<?php include_once "../_footer.php"; ?>