<?php
include_once("../function.php");
$id = $_GET["id"];

mysqli_query($con,"DELETE FROM tb_pelajar WHERE id = $id");
mysqli_affected_rows($con);

echo "
<script>window.location='student.php'
</script>";
?>