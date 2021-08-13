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
  // $compassword = htmlspecialchars($data["compassword"]);
  // $email = htmlspecialchars($data["email"]);
  // $address = htmlspecialchars($data["address"]);
  // $code = htmlspecialchars($data["code"]);
  // $profile_img = htmlspecialchars($data["profile_img"]);

  // //cek username sudah ada atau belum
  // $hasil = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

  // if (mysqli_fetch_assoc($hasil)) {
  //   echo "
  //     <script>
  //     alert('Username Yang Anda Pilih Sudah Wujud!');
  //     </script>
  //     ";

  //   return false;
  // }

  // //cek password sama atau tidak
  // if ($password !== $compassword) {
  //   echo "
  //     <script>
  //     alert('Password Anda Tidak Sama!');
  //     </script>
  //     ";

  //   return false;
  // }
  // //enkripsi password/atau acak password
  // $password = password_hash($password, PASSWORD_DEFAULT);
  //var_dump($password);
  //die;
  
  $create ="
   CREATE TABLE IF NOT EXISTS tb_pelajar(
     `id` INT AUTO_INCREMENT,
     `nama_pelajar` VARCHAR(200),
     `umur_pelajar` VARCHAR(200),
     `jantina_pelajar` VARCHAR(200),
     `kelas_id` INT,
     `cikgu_id` INT,
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con,$create);
  
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

  $create ="
   CREATE TABLE IF NOT EXISTS tb_cikgu(
     `id` INT AUTO_INCREMENT,
     `nama_cikgu` VARCHAR(200),
     `umur_cikgu` VARCHAR(200),
     `jantina_cikgu` VARCHAR(200),
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con,$create);

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
  
  $create ="
   CREATE TABLE IF NOT EXISTS tb_pelajaran(
     `id` INT AUTO_INCREMENT,
     `mata_pelajaran` VARCHAR(200),
     `cikgu_id` INT,
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con,$create);

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

function register($data)
{
  $con = con();
  $full_name = htmlspecialchars($data["full_name"]);
  $email = htmlspecialchars($data["email"]);
  $password = htmlspecialchars($data["password"]);
  $password2 = htmlspecialchars($data["password2"]);
  $role_id = 0;
  
  //create table tb_user
  $createTbUser ="
   CREATE TABLE IF NOT EXISTS tb_user(
     `id` INT AUTO_INCREMENT,
     `full_name` VARCHAR(200),
     `email` VARCHAR(200),
     `password` VARCHAR(200),
     `role_id` INT,
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con,$createTbUser);
  
  //create table tb_darjah dan insert data
  $createTbDarjah ="
   CREATE TABLE IF NOT EXISTS tb_darjah(
     `id` INT AUTO_INCREMENT,
     `umur_pelajar` INT,
     `darjah_pelajar` VARCHAR(200),
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con,$createTbDarjah);
  
  $insertTbDarjah ="
  INSERT INTO `tb_darjah` (`Id`, `umur_pelajar`, `darjah_pelajar`) VALUES
  (NULL, '7', 'Darjah 1'), 
  (NULL, '8', 'Darjah 2'),
  (NULL, '9', 'Darjah 3'), 
  (NULL, '10', 'Darjah 4'),
  (NULL, '11', 'Darjah 5'), 
  (NULL, '12', 'Darjah 6'),
  (NULL, '13', 'Tingkatan 1'), 
  (NULL, '14', 'Tingkatan 2'),
  (NULL, '15', 'Tingkatan 3'), 
  (NULL, '16', 'Tingkatan 4'),
  (NULL, '17', 'Tingkatan 5'), 
  (NULL, '18', 'Tingkatan 6')";
  mysqli_query($con,$insertTbDarjah);
  
  //create table tb_kelas dan INSERT
  $createTbKelas ="
   CREATE TABLE IF NOT EXISTS tb_kelas(
     `id` INT,
     `nama_kelas` VARCHAR(200),
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con,$createTbKelas);
  
  $insertTbKelas ="
  INSERT INTO `tb_kelas` (`Id`,`nama_kelas`) VALUES
  (1, 'Kelas A'), 
  (2, 'Kelas B'),
  (3, 'Kelas C'), 
  (4, 'Kelas D')";
  mysqli_query($con,$insertTbKelas);
  

  $result = mysqli_query($con, "SELECT * FROM tb_user WHERE email = '$email'");

  if (mysqli_fetch_assoc($result)) {
    echo "<script>
    alert('Email Sudah Terdaftar!')
    </script>";
    return false;
  }


  if ($password !== $password2) {
    echo "<script>
    alert('Password Tidak Sama!')
    </script>";
    return false;
  }

  $password = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO tb_user VALUE 
  (null, '$full_name', '$email', '$password', '$role_id')";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}
