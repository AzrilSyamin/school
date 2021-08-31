<?php include_once("../_header.php");

if (isset($_SESSION["admin"])) {
  $login = $_SESSION["admin"];
} elseif (isset($_SESSION["moderator"])) {
  $login = $_SESSION["moderator"];
}

$query = mysqli_query(con(), "SELECT * FROM tb_user 
                              JOIN tb_role 
                              ON tb_user.role_id = tb_role.role_id 
                              WHERE tb_user.id = '$login'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST["submit"])) {
  if (edit_user($_POST) > 0) {
    echo "<script>
          alert('Edit Success');
          window.location='../user/profile.php';
          </script>";
  } else {
    echo "<script>
          alert('Edit Failed');
          window.location='../user/profile.php';
          </script>";
  }
}


?>
<div class="row">
  <div class="col-12 col-md-6 p-4 shadow">
    <h4>My Profile <?= "[" . $data["role_name"] . "]"; ?> </h4>
    <form action="" method="POST" enctype="multipart/form-data">

      <div class="form-group">
        <img src="../img/<?= $data["picture"]; ?>" alt="user-profile">
      </div>

      <div class="form-group">
        <label>User ID :</label>
        <input type="text" class="form-control" name="id" value="<?= $data["id"]; ?>" readonly>
      </div>

      <div class="form-group">
        <!-- Is Active  -->
        <input type="hidden" class="form-control" name="is_active" value="<?= $data["is_active"]; ?>">
      </div>

      <div class="form-group">
        <!-- Role Id  -->
        <input type="hidden" class="form-control" name="role_id" value="<?= $data["role_id"]; ?>">
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
        <label for="age">Age :</label>
        <input type="number" class="form-control" name="age" id="age" value="<?= $data["age"]; ?>" required>
      </div>

      <div class="form-group">
        <label for="gender">Gender :</label>
        <select name="gender" id="gender" class="form-control">
          <option value="">Choose...</option>
          <option <?php if ($data['gender'] == 'Lelaki') {
                    echo "selected";
                  } ?>>Lelaki</option>
          <option <?php if ($data['gender'] == 'Perempuan') {
                    echo "selected";
                  } ?>>Perempuan</option>
        </select>
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
        <label for="picture">Profile Picture :</label>
        <input type="file" class="form-control-file" name="picture" id="picture">
      </div>

      <button type="submit" class="btn btn-success ml-1" style="float:right;" name="submit"><i class="fas fa-save"></i> Save Changes</button>
      <button type="reset" class="btn btn-warning" style="float:right;" name="submit"><i class="fas fa-redo-alt"></i> Reset</button>
    </form>
  </div>
</div>
<?php include_once("../_footer.php"); ?>