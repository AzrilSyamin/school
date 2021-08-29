<?php include_once "../_header.php"; ?>
<?php

$teachers = query("SELECT * FROM tb_teacher
                 ");
?>

<!-- Page Heading -->
<h3>List Of Teachers</h3>
<a href="add.php" class="btn btn-primary mb-3"><i class="fas fa-fw fa-plus-circle"></i> Add New Teachers</a>
<div class="row">
    <!-- Awal Table  -->
    <div class="col-12 table-responsive">
        <table class="table shadow">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Age</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php $i = 1;
            foreach ($teachers as $teacher) : ?>
                <tbody>
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
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>
    <!-- Akhir Table  -->
</div>
<?php include_once "../_footer.php"; ?>