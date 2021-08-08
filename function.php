<?php

$con = mysqli_connect("localhost", "root", "", "db_sekolah") or die(mysqli_error($con));

function query($query)
{
  global $con;
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
  global $con;
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
  global $con;
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
  global $con;
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
  global $con;
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
  global $con;
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
  global $con;
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
