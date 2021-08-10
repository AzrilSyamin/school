<?php include_once "../_header.php"; ?>
<?php

$students = query("SELECT * FROM tb_pelajar
                 ");
?>

<!-- Page Heading -->
<h1>List Of Students</h1>
<a href="add.php" class="btn btn-primary mb-3">Add Students</a>
<div class="row">
    <!-- Awal Table  -->
    <div class="col-12 table-responsive">
        <?php if (isset($suc)) : ?>
            <p style="color:green;">Berjaya Horreyy!!</p>
        <?php endif; ?>
        <table class="table shadow">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Jantina</th>
                    <th scope="col">Umur</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php $i = 1;
            foreach ($students as $student) : ?>
                <tbody>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $student["nama_pelajar"]; ?></td>
                        <td><?= $student["jantina_pelajar"]; ?></td>
                        <td><?= $student["umur_pelajar"]; ?></td>
                        <td>

                            <a class="badge badge-warning" href="edit.php?id=<?= $student["id"]; ?>"><i class="fas fa-edit"></i></i></a>

                            <a class="badge badge-danger" href="del.php?id=<?= $student["id"]; ?>" onclick="return confirm('Are You Sure Want To Delete?');"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>
    <!-- Akhir Table  -->
</div>
<?php include_once "../_footer.php"; ?>