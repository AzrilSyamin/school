<?php include_once("../_header.php"); 

$query=mysqli_query(con(),"SELECT * FROM tb_user");
$data=mysqli_fetch_assoc($query);




?>
<h3>My Profile</h3>
<div class="row">
  <div class="col-12 col-md-6 p-4 shadow">
    <form action="" method="POST">
      <fieldset disabled>
      <div class="form-group">
          <label for="userid">User ID :</label>
          <input type="text" class="form-control" name="userid" id="userid" required value="<?= $data["id"];?>">
      </div>
      </fieldset>
      
      <div class="form-group">
          <label for="nama">Nama :</label>
          <input type="text" class="form-control" name="nama" id="nama" required autofocus value="<?= $data["full_name"];?>">
      </div>
      
      <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" class="form-control" name="email" id="email" required autofocus value="<?= $data["email"];?>">
      </div>
      
      <div class="form-group">
          <label for="password1">Password :</label>
          <input type="password" class="form-control" name="password1" id="password1" required autofocus value="<?= $data["password"];?>">
      </div>
      
      <div class="form-group">
          <label for="password2">Comfirm Password :</label>
          <input type="password" class="form-control" name="password2" id="password2" required autofocus value="<?= $data["password"];?>">
      </div>

      <button type="submit" class="btn btn-primary" style="float:right;" name="submit">Save</button>
    </form>
  </div>
</div>
<?php include_once("../_footer.php"); ?>