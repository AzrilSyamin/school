<?php
include_once("../function.php");
$id = $_GET["id"];

mysqli_query($con,"DELETE FROM tb_cikgu WHERE id = $id");
mysqli_affected_rows($con);

echo "
<script>window.location='teacher.php'
</script>";
?>