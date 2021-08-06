<?php include_once "../_header.php"; ?>
<?php

$teachers= query("SELECT * FROM tb_cikgu
                 ");
?>

                    <!-- Page Heading -->
                    <h1>List Of Teachers</h1>
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
                      <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <?php $i=1; foreach($teachers as $teacher):?>
                                <tbody>
                                    <tr>
                                    <th scope="row"><?= $i++;?></th>
                                    <td><?= $teacher["nama_cikgu"];?></td>
                                    <td><?= $teacher["jantina_cikgu"];?></td>
                                    <td><?= $teacher["umur_cikgu"];?></td>
                      <td>
                        
                        <a class="badge badge-warning" href="edit.php?id=<?= $teacher["id"];?>"><i class="bi bi-pencil-square"></i></a>
                        
                        <a class="badge badge-danger" href="del.php?id=<?= $teacher["id"];?>" onclick="return confirm('Are You Sure Want To Delete?');"><i class="bi bi-trash"></i></a>
                      </td>
                                    </tr>
                                </tbody>
                                <?php endforeach;?>
                                </table>
                            </div>
                            <!-- Akhir Table  -->
                        </div>
<?php include_once "../_footer.php"; ?>