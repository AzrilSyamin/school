<?php
require_once "../_header.php";

if (!isset($_SESSION["admin"])) {
  echo "
  <script>
  window.location.href='/';
  </script>
  ";
  exit;
}

$id = $_GET["detail"];
$details = mysqli_query($con, "SELECT * FROM tb_user WHERE id = $id");
$detail = mysqli_fetch_assoc($details);
?>


<div class="row">
  <div class="col-12 mb-3">
    <a class="btn btn-primary mb-3" href="../teachers/teacher.php"><i class="fas fa-backward"></i> Back</a>
  </div>
  <div class="col-12 col-md-6">
    <div class="card">
      <div class="card-body">
        <h4>Detail Teachers</h4>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><img src="../img/<?= $detail["picture"]; ?>" alt="" width="40px"></li>
        <li class="list-group-item"><b>Name: </b> <?= $detail["first_name"] . " " . $detail["last_name"] ?></li>
        <li class="list-group-item"><b>Age: </b><?= $detail["age"]; ?></li>
        <li class="list-group-item"><b>Gender: </b><?= $detail["gender"]; ?></li>
        <li class="list-group-item"><b>Email: </b><?= $detail["email"]; ?></li>
        <li class="list-group-item"><b>Phone Number: </b><?= $detail["phone_number"]; ?></li>
        <li class="list-group-item"><b>Address: </b><?= $detail["address"]; ?></li>
      </ul>
    </div>
  </div>
</div>


<?php require_once "../_footer.php"; ?>