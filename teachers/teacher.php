<?php include_once "../_header.php"; ?>
<?php

$teachers = query("SELECT * FROM tb_teacher
                 ");
?>

<!-- Page Heading -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- First Header Table  -->
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h4>List Of Teachers</h4>
                    </div>
                    <div class="col-12 col-md-6">
                        <a href="add.php" class="btn btn-primary" style="float:right;"><i class="fas fa-fw fa-plus-circle"></i> Add New Teachers</a>
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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($teachers as $teacher) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= $teacher["teacher_name"]; ?></td>
                                <td><?= $teacher["teacher_gender"]; ?></td>
                                <td><?= $teacher["teacher_age"]; ?></td>
                                <td>

                                    <a class="badge badge-warning" href="edit.php?id=<?= $teacher["id"]; ?>"><i class="fas fa-edit"></i></a>

                                    <a class="badge badge-danger" href="del.php?id=<?= $teacher["id"]; ?>" onclick="return confirm('Are You Sure Want To Delete?');"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Akhir Table  -->
        </div>
    </div>
</div>
<?php include_once "../_footer.php"; ?>