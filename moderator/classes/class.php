<?php

$classes = query("SELECT * FROM tb_class");

?>

<!-- Page Heading -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- First Header Table  -->
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h4>List Of Class</h4>
                    </div>
                    <div class="col-12 col-sm-6">
                        <a href="?page=classes&action=add" class="btn btn-success float-md-right"><i class="fas fa-fw fa-plus-circle"></i> Add New Class</a>
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
                            <th scope="col">Class Name</th>
                            <th scope="col">Teacher Name</th>
                            <th scope="col">Action</th>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($classes as $class) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= $class["class_name"]; ?></td>
                                <td>
                                    <?php
                                    $data = explode(",", $class["teacher_id"]);
                                    $teachers = query("SELECT * FROM tb_user");
                                    foreach ($teachers as $teacher) :
                                    ?>
                                        <li class="list-unstyled"> <?php
                                                                    in_array($teacher["id"], $data) ? print "#" . " " . $teacher["first_name"] . " " . $teacher["last_name"] : null ?>
                                        </li>
                                    <?php endforeach; ?>
                                </td>

                                <td>
                                    <a class="badge badge-warning" href="?page=classes&action=edit&id=<?= $class["id"]; ?>"><i class="fas fa-edit"></i></a>
                                    <?php if (isset($_SESSION["admin"])) { ?>
                                        <a class="badge badge-danger" href="del.php?id=<?= $class["id"]; ?>" onclick="return confirm('Are You Sure Want To Delete?');"><i class="far fa-trash-alt"></i></a>
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