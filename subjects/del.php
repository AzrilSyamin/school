<?php
include_once("../function.php");

if (isset($_SESSION["admin"])) {
  $login = $_SESSION["admin"];
}

if (!isset($login)) {
  echo "<script>
window.location='/'
</script>";
  exit;
}

$id = $_GET["id"];

mysqli_query($con, "DELETE FROM tb_subjects WHERE id = $id") or die(mysqli_error($con));
mysqli_affected_rows($con);

echo "
<script>window.location='subject.php'
</script>";
