<?php
include_once("../function.php");
$id = $_GET["id"];

mysqli_query($con,"DELETE FROM tb_pelajaran WHERE id = $id");
mysqli_affected_rows($con);

echo "
<script>window.location='subject.php'
</script>";
?>