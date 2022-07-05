<?php

$users = query("SELECT * FROM tb_user 
JOIN tb_role
ON tb_user.role_id = tb_role.role_id 
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
                        <?php if (isset($_SESSION["admin"])) { ?>
                            <a href="add.php" class="btn btn-success float-sm-right"><i class="fas fa-fw fa-plus-circle"></i> Add New Teachers</a>
                        <?php } ?>
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
                            <th scope="col">Profile</th>
                            <th scope="col">Name</th>
                            <?php if (isset($_SESSION["admin"])) : ?>
                                <th scope="col">Details</th>
                                <th scope="col">Status</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($users as $user) :
                            if ($user["is_active"] == 1) {
                                $status = "<p class=\"badge badge-success\"><b>Active</b></p>";
                            } elseif ($user["is_active"] == 0) {
                                $status = "<p class=\"badge badge-danger\"><b>Non Active</b></p>";
                            } ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><img src="../img/<?= $user["picture"]; ?>" alt="user-profile" width="35px"></td>
                                <td><?= $user["first_name"] . " " . $user["last_name"] ?></td>
                                <?php if (isset($_SESSION["admin"])) : ?>
                                    <td>
                                        <div class="badge badge-info">
                                            <a class="text-white" href="../teachers/detail.php?detail=<?= $user["id"]; ?>">View Detail</a>
                                        </div>
                                    </td>
                                    <td><?= $status; ?></td>
                                    <td><?= $user["role_name"]; ?></td>
                                    <td class="<?php if ($user["id"] == $login) {
                                                    echo "d-none";
                                                } ?>">
                                        <a class="badge badge-warning" href="edit.php?id=<?= $user["id"]; ?>"><i class="fas fa-edit"></i></a>

                                        <a class="badge badge-danger" href="del.php?id=<?= $user["id"]; ?>" onclick="return confirm('Are You Sure Want To Delete?');"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Akhir Table  -->
        </div>
    </div>
</div>