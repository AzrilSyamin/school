<?php include_once "_header.php"; ?>
<?php

$students= query("SELECT * FROM tb_pelajar
                 
                 JOIN tb_cikgu
                 ON tb_pelajar.cikgu_id = tb_cikgu.id
                 
                 JOIN tb_kelas
                 ON tb_pelajar.kelas_id = tb_kelas.id
                 
                 JOIN tb_darjah
                 ON tb_pelajar.umur_pelajar = tb_darjah.umur_pelajar
                 ");
?>

                    <!-- Page Heading -->
                    <h1>List Of Students</h1>
                        <div class="row">
                            <!-- Awal Table  -->
                            <div class="col-12">
                                <table class="table shadow">
                                <thead class="thead-dark">
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Jantina</th>
                                    <th scope="col">Umur</th>
                                    </tr>
                                </thead>
                                <?php $i=1; foreach($students as $student):?>
                                <tbody>
                                    <tr>
                                    <th scope="row"><?= $i++;?></th>
                                    <td><?= $student["nama_pelajar"];?></td>
                                    <td><?= $student["jantina_pelajar"];?></td>
                                    <td><?= $student["umur_pelajar"];?></td>
                                    </tr>
                                </tbody>
                                <?php endforeach;?>
                                </table>
                            </div>
                            <!-- Akhir Table  -->
                        </div>
<?php include_once "_footer.php"; ?>