<?php
function create_config()
{
  $host = $_POST["hostname"];
  $user = $_POST["username"];
  $pass = $_POST["password"];
  $db_name = $_POST["db_name"];
  $webUrl = $_POST["webUrl"];

  $fh = fopen("config.php", 'w') or die("can't open file");

  $open = "<?php\n";
  fwrite($fh, $open);

  $code = "
    \$host = \"$host\";
    \$user = \"$user\";
    \$pass = \"$pass\";
    \$db_name = \"$db_name\";
  ";
  fwrite($fh, $code);

  $code = "
    function myUrl(\$url = null)
      {
        // \$base_url = 'http://localhost.test';
        \$base_url = '$webUrl';
        if (\$url != null) {
          return \$base_url . \"/\" . \$url;
        } else {
          return \$base_url;
        }
  }";
  fwrite($fh, $code);

  fclose($fh);
}

function create_tabel()
{
  global $con;
  //create table tb_user
  $create = "CREATE TABLE IF NOT EXISTS tb_user (
     `id` INT AUTO_INCREMENT,
     `first_name` VARCHAR(200),
     `last_name` VARCHAR(200),
     `age` VARCHAR(3),
     `gender` VARCHAR(200),
     `email` VARCHAR(200),
     `username` VARCHAR(200),
     `phone_number` VARCHAR(12),
     `address` VARCHAR(300),
     `password` VARCHAR(200),
     `picture` VARCHAR(200),
     `role_id` INT,
     `is_active` INT,
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con, $create);
  //end create table tb_user

  //create table tb_gender
  $create = "CREATE TABLE IF NOT EXISTS tb_gender (
     `id` INT AUTO_INCREMENT,
     `gender` VARCHAR(100),
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con, $create);
  //end create table tb_gender

  //create table tb_role
  $create = "CREATE TABLE IF NOT EXISTS tb_role (
     `role_id` INT AUTO_INCREMENT,
     `role_name` VARCHAR(200),
     PRIMARY KEY (`role_id`)
  )";
  mysqli_query($con, $create);
  //end create table tb_role


  //create table tb_stages and insert data
  $createTbDarjah = "CREATE TABLE IF NOT EXISTS tb_stages (
     `id` INT AUTO_INCREMENT,
     `student_age` INT,
     `stages_age` VARCHAR(200),
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con, $createTbDarjah);
  //end create table tb_stages and insert data


  //create table tb_class and INSERT
  $createTbKelas = "CREATE TABLE IF NOT EXISTS tb_class (
     `id` INT AUTO_INCREMENT,
     `class_name` VARCHAR(200),
     `teacher_id` VARCHAR(300),
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con, $createTbKelas);
  //end create table tb_class and INSERT


  // create tb_class_teacher  
  $create = "CREATE TABLE IF NOT EXISTS tb_class_teacher(
      `id` INT AUTO_INCREMENT,
      `class_id` INT,
      `teacher_id` INT,
      PRIMARY KEY (`id`))";
  mysqli_query($con, $create);
  // akhir create tb_class_teacher


  // create tb_class_subjects  
  $create = "CREATE TABLE IF NOT EXISTS tb_class_subjects (
      `id` INT AUTO_INCREMENT,
      `class_id` INT,
      `subjects_id` INT,
      PRIMARY KEY (`id`))";
  mysqli_query($con, $create);
  // akhir create tb_class_subjects


  // create tb_subjects   
  $create = "CREATE TABLE IF NOT EXISTS tb_subjects (
   `id` INT AUTO_INCREMENT,
   `subjects_name` VARCHAR(200),
   `teacher_id` VARCHAR(300),
   PRIMARY KEY (`id`))";
  mysqli_query($con, $create);
  // akhir create tb_subjects


  // create tb_student
  $create = "CREATE TABLE IF NOT EXISTS tb_student (
    `id` INT AUTO_INCREMENT,
    `student_name` VARCHAR(200),
    `student_age` VARCHAR(200),
    `student_gender` VARCHAR(200),
    `class_id` INT,
    PRIMARY KEY (`id`))";
  mysqli_query($con, $create);
  // end create tb_student 
  return mysqli_query($con, $create);
}

function insert_table_data()
{
  global $con;
  $insertTbGender = "INSERT INTO `tb_gender` (`Id`, `gender`) VALUES
  (1, 'Lelaki'),
  (2, 'Perempuan')";
  mysqli_query($con, $insertTbGender);

  $insertTbRole = "INSERT INTO `tb_role` (`role_Id`, `role_name`) VALUES
  (1, 'admin'),
  (2, 'moderator'),
  (3, 'member')";
  mysqli_query($con, $insertTbRole);

  $insertTbDarjah = "INSERT INTO `tb_stages` (`Id`, `student_age`, `stages_age`) VALUES
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

  $insertTbKelas = "INSERT INTO `tb_class` (`Id`,`class_name`) VALUES
  (1, 'Class A'), 
  (2, 'Class B'),
  (3, 'Class C'), 
  (4, 'Class D')";
  mysqli_query($con, $insertTbKelas);
}

//function register
function setup_step_two($data)
{
  global $con;
  $first_name = htmlspecialchars($data["first_name"]);
  $last_name = htmlspecialchars($data["last_name"]);
  $email = htmlspecialchars($data["email"]);
  $username = htmlspecialchars($data["username"]);
  @$phone = htmlspecialchars($data["phone_number"]);
  @$address = htmlspecialchars($data["address"]);
  $password = htmlspecialchars($data["password"]);
  $password2 = htmlspecialchars($data["password2"]);
  $picture = "default.jpg";
  $role_id = 1;
  $is_active = 1;

  $fetchUsername = mysqli_query($con, "SELECT * FROM tb_user WHERE username = '$username'");
  $fetchEmail = mysqli_query($con, "SELECT * FROM tb_user WHERE email = '$email'");

  if (mysqli_fetch_assoc($fetchUsername)) {

    echo  "<div class=\"register-box\">
    <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
        <p>Username Is Already Exist !</p>
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      </div>";
    return false;
  }

  if (mysqli_fetch_assoc($fetchEmail)) {
    echo  "<div class=\"register-box\">
    <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
        <p>Email Is Already Exist !</p>
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      </div>";
    return false;
  }


  if ($password !== $password2) {
    echo  "<div class=\"register-box\">
    <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
        <p>Passwords Do Not Match !</p>
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      </div>";
    return false;
  }

  $password = password_hash($password, PASSWORD_DEFAULT);
  $query = "INSERT INTO tb_user VALUE 
  (null, '$first_name','$last_name', null, null, '$email','$username', '$phone', '$address', '$password','$picture', '$role_id', '$is_active')";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}
//end function register
