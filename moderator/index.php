<?php
require_once "../function.php";
if (isset($_SESSION["moderator"])) {
  $login = $_SESSION["moderator"]["roleid"];
} else {
  if (isset($_SESSION["admin"])) {
    echo "<script>
      window.location.href='" . myUrl("dashboard/") . "'
      </script>";
  } elseif (isset($_SESSION["member"])) {
    echo "<script>
      window.location.href='" . myUrl("member/") . "'
      </script>";
  } else {
    echo "<script>
      window.location.href='" . myUrl("auth/logout.php") . "'
      </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Member</title>
</head>

<body>
  <h1>Welcome To Moderator Area</h1>

</body>

</html>