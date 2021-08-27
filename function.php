<?php
session_start();

function con()
{
  return mysqli_connect("localhost", "root", "", "db_sekolah");
}

function query($query)
{
  $con = con();
  $result = mysqli_query($con, $query) or die(mysqli_error($con));

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function base_url($url = null)
{
  $base_url = '';
  if ($url != null) {
    return $base_url . "/" . $url;
  } else {
    return $base_url;
  }
}

function add_students($data)
{
  $con = con();
  $nama = htmlspecialchars($data["nama"]);
  $umur = htmlspecialchars($data["umur"]);
  $jantina = htmlspecialchars($data["jantina"]);
  $kelasid = htmlspecialchars($data["kelas"]);
  $cikguid = htmlspecialchars($data["cikgu"]);

  if ($data["umur"] == "Choose...") {
    return false;
  } elseif ($data["jantina"] == "Choose...") {
    return false;
  } elseif ($data["kelas"] == "Choose...") {
    return false;
  } elseif ($data["cikgu"] == "Choose...") {
    return false;
  }

  $query = "INSERT INTO tb_pelajar VALUE
  (NULL, '$nama','$umur', '$jantina', '$kelasid', '$cikguid')";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}

function add_teachers($data)
{
  $con = con();
  $nama = htmlspecialchars($data["nama"]);
  $umur = htmlspecialchars($data["umur"]);
  $jantina = htmlspecialchars($data["jantina"]);

  if ($data["jantina"] == "Choose...") {
    return false;
  }
  $query = "INSERT INTO tb_cikgu VALUE
  (NULL, '$nama','$umur', '$jantina')";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}


function add_subjects($data)
{
  $con = con();
  $mata = htmlspecialchars($data["mata"]);
  $idcikgu = htmlspecialchars($data["idcikgu"]);

  if ($data["idcikgu"] == "Choose...") {
    return false;
  }
  $query = "INSERT INTO tb_pelajaran VALUE
  (NULL, '$mata','$idcikgu')";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}

function edit_students($data)
{
  $con = con();
  $id = $data["id"];
  $nama = htmlspecialchars($data["nama"]);
  $umur = htmlspecialchars($data["umur"]);
  $jantina = htmlspecialchars($data["jantina"]);
  $kelasid = htmlspecialchars($data["kelas"]);
  $cikguid = htmlspecialchars($data["cikgu"]);

  if ($data["umur"] == "Choose...") {
    return false;
  } elseif ($data["jantina"] == "Choose...") {
    return false;
  } elseif ($data["kelas"] == "Choose...") {
    return false;
  } elseif ($data["cikgu"] == "Choose...") {
    return false;
  }

  $query = "UPDATE tb_pelajar SET
  nama_pelajar = '$nama',
  umur_pelajar = '$umur', 
  jantina_pelajar = '$jantina', 
  kelas_id = '$kelasid', 
  cikgu_id = '$cikguid'
  WHERE id = $id ";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}

function edit_teachers($data)
{
  $con = con();
  $id = $data["id"];
  $nama = htmlspecialchars($data["nama"]);
  $umur = htmlspecialchars($data["umur"]);
  $jantina = htmlspecialchars($data["jantina"]);

  if ($data["jantina"] == "Choose...") {
    return false;
  }
  $query = "UPDATE tb_cikgu SET
  nama_cikgu = '$nama',
  umur_cikgu = '$umur', 
  jantina_cikgu = '$jantina'
  WHERE id = $id ";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}

function edit_subjects($data)
{
  $con = con();
  $id = $data["id"];
  $mata = htmlspecialchars($data["mata"]);
  $idcikgu = htmlspecialchars($data["idcikgu"]);

  if ($data["idcikgu"] == "Choose...") {
    return false;
  }
  $query = "UPDATE tb_pelajaran SET
  mata_pelajaran = '$mata',
  cikgu_id = '$idcikgu'
  WHERE id = $id ";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}

function edit_user($data)
{
  $con = con();
  $id = $data["id"];
  $first_name = htmlspecialchars($data["first_name"]);
  $last_name = htmlspecialchars($data["last_name"]);
  $email = htmlspecialchars($data["email"]);
  $password = htmlspecialchars($data["password1"]);
  $password2 = htmlspecialchars($data["password2"]);
  $picture = "default.jpg";
  $role_id = 1;

  // if ($password && $password2 == null){

  // }

  if ($password !== $password2) {
    echo "Password Tidak Sama";
    return false;
  }

  $password = password_hash($password, PASSWORD_DEFAULT);

  $query = "UPDATE tb_user SET
  first_name = '$first_name',
  last_name = '$last_name', 
  email = '$email', 
  password = '$password',
  picture = '$picture', 
  role_id = $role_id
  WHERE id = $id ";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}

function register($data)
{
  $con = con();
  $first_name = htmlspecialchars($data["first_name"]);
  $last_name = htmlspecialchars($data["last_name"]);
  $email = htmlspecialchars($data["email"]);
  $password = htmlspecialchars($data["password"]);
  $password2 = htmlspecialchars($data["password2"]);
  $picture = "default.jpg";
  $role_id = 1;

  //create table tb_user
  $createTbUser = "
   CREATE TABLE IF NOT EXISTS tb_user(
     `id` INT AUTO_INCREMENT,
     `first_name` VARCHAR(200),
     `last_name` VARCHAR(200),
     `email` VARCHAR(200),
     `password` VARCHAR(200),
     `picture` VARCHAR(200),
     `role_id` INT,
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con, $createTbUser);

  //create table tb_darjah dan insert data
  $createTbDarjah = "
   CREATE TABLE IF NOT EXISTS tb_darjah(
     `id` INT AUTO_INCREMENT,
     `umur_pelajar` INT,
     `darjah_pelajar` VARCHAR(200),
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con, $createTbDarjah);
  $insertTbDarjah = "
  INSERT INTO `tb_darjah` (`Id`, `umur_pelajar`, `darjah_pelajar`) VALUES
  (1, '7', 'Darjah 1'), 
  (2, '8', 'Darjah 2'),
  (3, '9', 'Darjah 3'), 
  (4, '10', 'Darjah 4'),
  (5, '11', 'Darjah 5'), 
  (6, '12', 'Darjah 6'),
  (7, '13', 'Tingkatan 1'), 
  (8, '14', 'Tingkatan 2'),
  (9, '15', 'Tingkatan 3'), 
  (10, '16', 'Tingkatan 4'),
  (11, '17', 'Tingkatan 5'), 
  (12, '18', 'Tingkatan 6')";
  mysqli_query($con, $insertTbDarjah);
  //akhir create table tb_darjah dan insert data

  //create table tb_kelas dan INSERT
  $createTbKelas = "
   CREATE TABLE IF NOT EXISTS tb_kelas(
     `id` INT,
     `nama_kelas` VARCHAR(200),
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con, $createTbKelas);
  $insertTbKelas = "
  INSERT INTO `tb_kelas` (`Id`,`nama_kelas`) VALUES
  (1, 'Kelas A'), 
  (2, 'Kelas B'),
  (3, 'Kelas C'), 
  (4, 'Kelas D')";
  mysqli_query($con, $insertTbKelas);
  //akhir create table tb_kelas dan INSERT  

  // create table cikgu 
  $create = "
  CREATE TABLE IF NOT EXISTS tb_cikgu(
    `id` INT AUTO_INCREMENT,
    `nama_cikgu` VARCHAR(200),
    `umur_cikgu` VARCHAR(200),
    `jantina_cikgu` VARCHAR(200),
    PRIMARY KEY (`id`))";
  mysqli_query($con, $create);
  // akhir create table cikgu 

  // create table pelajaran   
  $create = "
 CREATE TABLE IF NOT EXISTS tb_pelajaran(
   `id` INT AUTO_INCREMENT,
   `mata_pelajaran` VARCHAR(200),
   `cikgu_id` INT,
   PRIMARY KEY (`id`))";
  mysqli_query($con, $create);
  // akhir create table pelajaran

  // create table pelajar
  $create = "
  CREATE TABLE IF NOT EXISTS tb_pelajar(
    `id` INT AUTO_INCREMENT,
    `nama_pelajar` VARCHAR(200),
    `umur_pelajar` VARCHAR(200),
    `jantina_pelajar` VARCHAR(200),
    `kelas_id` INT,
    `cikgu_id` INT,
    PRIMARY KEY (`id`))";
  mysqli_query($con, $create);
  // akhir create table pelajar 

  $result = mysqli_query($con, "SELECT * FROM tb_user WHERE email = '$email'");

  if (mysqli_fetch_assoc($result)) {
    // echo "<script>
    // alert('Email Sudah Terdaftar!')
    // </script>";

    echo  "<div class=\"register-box\">
    <div class=\"alert alert-danger\" role=\"alert\">
        <p>Email Sudah Terdaftar!</p>
      </div>
      </div>";

    return false;
  }


  if ($password !== $password2) {
    echo  "<div class=\"register-box\">
    <div class=\"alert alert-danger\" role=\"alert\">
        <p>Password Tidak Sama!</p>
      </div>
      </div>";
    return false;
  }

  $password = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO tb_user VALUE 
  (null, '$first_name','$last_name', '$email', '$password','$picture', '$role_id')";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}

function login($data)
{
  $con = con();
  $email = htmlspecialchars($data["email"]);
  $password = htmlspecialchars($data["password"]);

  $result = mysqli_query($con,  "SELECT * FROM tb_user WHERE email = '$email'");

  if (mysqli_num_rows($result) === 1) {

    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      $cek = mysqli_num_rows($result);
      if ($cek > 0) {
        if ($row["role_id"] == 1) {
          $_SESSION["email"] = $row["id"];
          echo "<script>
          window.location='/'
          </script>";
        } else if ($row["role_id"] == 0) {
          $_SESSION["email"] = $row["id"];
          echo "<script>
          window.location='/'
          </script>";
        }
      }
    }
  } else {
    echo "<script>
          alert('Email Belum Berdaftar!');
          window.location='/';
          </script>";
  }
}
