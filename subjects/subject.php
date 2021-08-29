<?php include_once "../_header.php"; ?>
<?php

$subjects = query("SELECT * FROM tb_teacher
                RIGHT JOIN tb_subjects
                ON tb_teacher.id = tb_subjects.teacher_id");
?>

<!-- Page Heading -->
<h3>List Of Subjects</h3>
<a href="add.php" class="btn btn-primary mb-3"><i class="fas fa-fw fa-plus-circle"></i> Add New Subjects</a>
<div class="row">
    <!-- Awal Table  -->
    <div class="col-12 table-responsive">
        <table class="table shadow">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Subjects Name</th>
                    <th scope="col">Teacher Name</th>
                    <th scope="col">Action</th>
            </thead>
            <?php $i = 1;
            foreach ($subjects as $subject) : ?>
                <tbody>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $subject["subjects_name"]; ?></td>
                        <td><?= $subject["teacher_name"]; ?></td>
                        <td>
                            <a class="badge badge-warning" href="edit.php?id=<?= $subject["id"]; ?>"><i class="fas fa-edit"></i></a>

                            <a class="badge badge-danger" href="del.php?id=<?= $subject["id"]; ?>" onclick="return confirm('Are You Sure Want To Delete?');"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>
    <!-- Akhir Table  -->
</div>
<?php include_once "../_footer.php"; ?>