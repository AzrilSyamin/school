<?php include_once("../_header.php");

$query = mysqli_query(con(), "SELECT * FROM tb_user WHERE id = '$_SESSION[email]'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST["submit"])) {
  if (edit_user($_POST) > 0) {
    echo "<script>
          alert('Edit Success');
          window.location='../user/profile.php';
          </script>";
  } else {
    echo "<script>
          alert('Edit Fail');
          window.location='../user/profile.php';
          </script>";
  }
}


?>
<h3>My Profile</h3>
<div class="row">
  <div class="col-12 col-md-6 p-4 shadow">
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>User ID :</label>
        <input type="text" class="form-control" name="id" value="<?= $data["id"]; ?>" readonly>
      </div>

      <div class="form-group">
        <label for="name">First Name :</label>
        <input type="text" class="form-control" name="first_name" id="name" required autofocus value="<?= $data["first_name"]; ?>">
      </div>

      <div class="form-group">
        <label for="name">Last Name :</label>
        <input type="text" class="form-control" name="last_name" id="name" value="<?= $data["last_name"]; ?>">
      </div>

      <div class="form-group">
        <label for="email">Email :</label>
        <input type="email" class="form-control" name="email" id="email" value="<?= $data["email"]; ?>" readonly>
      </div>

      <div class="form-group">
        <label for="password1">Password :</label>
        <input type="password" class="form-control" name="password1" id="password1">
      </div>

      <div class=" form-group">
        <label for="password2">Comfirm Password :</label>
        <input type="password" class="form-control" name="password2" id="password2">
      </div>

      <div class=" form-group">
        <label for="picture">Picture Update :</label>
        <input type="file" class="form-control-file" name="picture" id="picture">
      </div>

      <button type="submit" class="btn btn-primary" style="float:right;" name="submit">Save Changes</button>
    </form>
  </div>
</div>
<?php include_once("../_footer.php"); ?>