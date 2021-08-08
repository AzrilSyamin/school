<?php include_once "../_header.php"; ?>
<?php

$subjects = query("SELECT * FROM tb_cikgu
                JOIN tb_pelajaran
                ON tb_cikgu.id = tb_pelajaran.cikgu_id");
?>

<!-- Page Heading -->
<h1>List Of Subjects</h1>
<div class="row">
    <!-- Awal Table  -->
    <div class="col-12">
        <table class="table shadow">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name Mata Pelajaran</th>
                    <th scope="col">Nama Cikgu</th>
                    <th scope="col">Action</th>
            </thead>
            <?php $i = 1;
            foreach ($subjects as $subject) : ?>
                <tbody>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $subject["mata_pelajaran"]; ?></td>
                        <td><?= $subject["nama_cikgu"]; ?></td>
                        <td>
                            <a class="badge badge-warning" href="edit.php?id=<?= $subject["id"]; ?>"><i class="bi bi-pencil-square"></i></a>

                            <a class="badge badge-danger" href="del.php?id=<?= $subject["id"]; ?>" onclick="return confirm('Are You Sure Want To Delete?');"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>
    <!-- Akhir Table  -->
</div>
<?php include_once "../_footer.php"; ?>