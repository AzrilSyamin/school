<?php include_once "../_header.php"; ?>
<?php

$subjects = query("SELECT * FROM tb_user
RIGHT JOIN tb_subjects
 ON tb_user.id = tb_subjects.teacher_id");
?>

<!-- Page Heading -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- First Header Table  -->
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h4>List Of Subjects</h4>
                    </div>
                    <div class="col-12 col-sm-6">
                        <a href="add.php" class="btn btn-success float-md-right"><i class="fas fa-fw fa-plus-circle"></i> Add New Subjects</a>
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
                            <th scope="col">Subjects Name</th>
                            <th scope="col">Teacher Name</th>
                            <th scope="col">Action</th>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($subjects as $subject) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= $subject["subjects_name"]; ?></td>
                                <td><?= $subject["first_name"] . " " . $subject["last_name"] ?></td>
                                <td>
                                    <a class="badge badge-warning" href="edit.php?id=<?= $subject["id"]; ?>"><i class="fas fa-edit"></i></a>
                                    <?php if (isset($_SESSION["admin"])) { ?>
                                        <a class="badge badge-danger" href="del.php?id=<?= $subject["id"]; ?>" onclick="return confirm('Are You Sure Want To Delete?');"><i class="far fa-trash-alt"></i></a>
                                    <?php } ?>
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