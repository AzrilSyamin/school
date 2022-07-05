<?php
session_start();
require "config.php";

$con = mysqli_connect($host, $user, $pass, $db) or die(mysqli_error($con));



//function query
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
//end function login


//function add_teachers
function add_teachers($data)
{
  global $con;
  $first_name = htmlspecialchars($data["first_name"]);
  $last_name = htmlspecialchars($data["last_name"]);
  $age = htmlspecialchars($data["age"]);
  $gender = htmlspecialchars($data["gender"]);
  $email = htmlspecialchars($data["email"]);
  $username = null;
  $phone = htmlspecialchars($data["phone_number"]);
  $address = htmlspecialchars($data["address"]);
  $password = htmlspecialchars($data["password1"]);
  $password2 = htmlspecialchars($data["password2"]);
  $picture = 'default.jpg';
  $role_id = 2;
  $is_active = htmlspecialchars($data["status"]);

  $result = mysqli_query($con, "SELECT * FROM tb_user WHERE email = '$email'");

  if (mysqli_fetch_assoc($result)) {

    echo  "
    <div class=\"row\">
      <div class=\"col-12 col-md-6\">
        <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
          <p>Email Is Already Registered !</p>
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
          </button>
        </div>
      </div>
    </div>
      ";
    return false;
  }


  if ($password !== $password2) {
    echo  "
      <div class=\"row\">
        <div class=\"col-12 col-md-6\">
          <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
            <p>Passwords Do Not Match !</p>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
              <span aria-hidden=\"true\">&times;</span>
            </button>
          </div>
        </div>
      </div>
      ";
    return false;
  }

  $password = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO tb_user VALUE
  (NULL, '$first_name','$last_name', '$age', '$gender', '$email','$username', '$phone', '$address',  '$password', '$picture', '$role_id', '$is_active')";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}
//end function add_teachers


//function edit_teachers
function edit_teachers($data)
{
  global $con;
  $id = $data["id"];
  $first_name = htmlspecialchars($data["first_name"]);
  $last_name = htmlspecialchars($data["last_name"]);
  $email = htmlspecialchars($data["email"]);
  $username = htmlspecialchars($data["username"]);
  $phone = htmlspecialchars($data["phone_number"]);
  $address = htmlspecialchars($data["address"]);
  $age = htmlspecialchars($data["age"]);
  $gender = htmlspecialchars($data["gender"]);
  $password = htmlspecialchars($data["password1"]);
  $password2 = htmlspecialchars($data["password2"]);
  //pic_name
  $name_picture = htmlspecialchars(@$_FILES["picture"]["name"]);
  $role_id = htmlspecialchars($data["role_id"]);
  $is_active = htmlspecialchars($data["is_active"]);
  //sumber
  $sumber = @$_FILES["picture"]["tmp_name"];
  // //folder
  $folder = "../img/";
  $sql = mysqli_query($con, "SELECT * FROM tb_user WHERE id = $id");


  //picture
  if ($name_picture == null) {
    $data_pic = mysqli_fetch_assoc($sql);
    $name_picture = $data_pic["picture"];
  } else {
    move_uploaded_file($sumber, $folder . $name_picture);
  }

  if ($username !== $data["oldusername"]) {
    $fetchUsername = mysqli_query($con, "SELECT * FROM tb_user WHERE username = '$username'");
    // $fetchEmail = mysqli_query($con, "SELECT * FROM tb_user WHERE email = '$email'");

    if (mysqli_fetch_assoc($fetchUsername)) {
      echo "
      <div class=\"row\">
        <div class=\"col-12 col-md-6\">
          <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
            <p>Username Is Already Exist !</p>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
              <span aria-hidden=\"true\">&times;</span>
            </button>
          </div>
        </div>
      </div>";
      return false;
    }
  }

  if ($email !== $data["oldemail"]) {
    $fetchEmail = mysqli_query($con, "SELECT * FROM tb_user WHERE email = '$email'");

    if (mysqli_fetch_assoc($fetchEmail)) {
      echo  "
      <div class=\"row\">
        <div class=\"col-12 col-md-6\">
          <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
            <p>Email Is Already Exist !</p>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
              <span aria-hidden=\"true\">&times;</span>
            </button>
          </div>
        </div>
      </div>";
      return false;
    }
  }

  //password
  if ($password && $password2 !== null) {
    if ($password !== $password2) {
      echo "
      <div class=\"row\">
        <div class=\"col-12 col-md-6\">
          <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
            <p>Passwords Do Not Match !</p>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
              <span aria-hidden=\"true\">&times;</span>
            </button>
          </div>
        </div>
      </div>
      ";
      return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
  } else {
    $sql_pass = mysqli_query($con, "SELECT * FROM tb_user WHERE id = $id");
    $data_pass = mysqli_fetch_assoc($sql_pass);
    $password = @$data_pass["password"];
  }


  $query = "UPDATE tb_user SET
  first_name = '$first_name',
  last_name = '$last_name',
  age = '$age',
  gender = '$gender',
  email = '$email',
  username = '$username',
  phone_number = '$phone',
  address = '$address',
  password = '$password', 
  picture = '$name_picture',
  role_id = '$role_id', 
  is_active = '$is_active' 
  WHERE id = $id ";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}
//end function edit_teachers


//function edit_user
function edit_user($data)
{
  global $con;
  $id = $data["id"];
  $first_name = htmlspecialchars($data["first_name"]);
  $last_name = htmlspecialchars($data["last_name"]);
  $email = htmlspecialchars($data["email"]);
  $phone = htmlspecialchars($data["phone_number"]);
  $address = htmlspecialchars($data["address"]);
  $age = htmlspecialchars($data["age"]);
  $gender = htmlspecialchars($data["gender"]);
  $password = htmlspecialchars($data["password1"]);
  $password2 = htmlspecialchars($data["password2"]);
  //pic_name
  $name_picture = htmlspecialchars(@$_FILES["picture"]["name"]);
  $role_id = htmlspecialchars($data["role_id"]);
  $is_active = htmlspecialchars($data["is_active"]);
  //sumber
  $sumber = @$_FILES["picture"]["tmp_name"];
  // //folder
  $folder = "../img/";


  if (isset($_SESSION["admin"])) {
    $login = $_SESSION["admin"];
  } elseif (isset($_SESSION["moderator"])) {
    $login = $_SESSION["moderator"];
  }

  $sql = mysqli_query($con, "SELECT * FROM tb_user WHERE id = '$login'");

  //picture
  if ($name_picture == null) {
    $data_pic = mysqli_fetch_assoc($sql);
    $name_picture = $data_pic["picture"];
  } else {
    move_uploaded_file($sumber, $folder . $name_picture);
  }

  //password
  if ($password && $password2 !== null) {
    if ($password !== $password2) {
      echo "
      <div class=\"row\">
        <div class=\"col-12 col-md-6\">
          <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
            <p>Passwords Do Not Match !</p>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
              <span aria-hidden=\"true\">&times;</span>
            </button>
          </div>
        </div>
      </div>
      ";
      return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
  } else {
    $sql_pass = mysqli_query($con, "SELECT * FROM tb_user WHERE id = '$login'");
    $data_pass = mysqli_fetch_assoc($sql_pass);
    $password = @$data_pass["password"];
  }


  $query = "UPDATE tb_user SET
  first_name = '$first_name',
  last_name = '$last_name', 
  age = '$age',
  gender = '$gender',
  email = '$email',
  phone_number = '$phone',
  address = '$address',
  password = '$password',
  picture = '$name_picture', 
  role_id = '$role_id',
  is_active = '$is_active'
  WHERE id = $id ";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}
//end function edit_user


//function add_subjects
function add_subjects($data)
{
  global $con;
  $subjects = htmlspecialchars($data["subjects"]);
  $teacher = htmlspecialchars($data["teacher"]);

  $query = "INSERT INTO tb_subjects VALUE
  (NULL, '$subjects', '$teacher')";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}
//end function add_subjects


//function edit_subjects
function edit_subjects($data)
{
  global $con;
  $id = $data["id"];
  $subjects = htmlspecialchars($data["subjects"]);
  $teacher = htmlspecialchars($data["teacher"]);

  $query = "UPDATE tb_subjects SET
  subjects_name = '$subjects',
  teacher_id = '$teacher'
  WHERE id = $id ";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}
//end function edit_subjects


//function add_students
function add_students($data)
{
  global $con;
  $name = htmlspecialchars($data["name"]);
  $age = htmlspecialchars($data["age"]);
  $gender = htmlspecialchars($data["gender"]);
  $class_id = htmlspecialchars($data["class"]);

  $query = "INSERT INTO tb_student VALUE
  (NULL, '$name','$age', '$gender', '$class_id')";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}
//end function add_students


//function edit_students
function edit_students($data)
{
  global $con;
  $id = $data["id"];
  $name = htmlspecialchars($data["name"]);
  $age = htmlspecialchars($data["age"]);
  $gender = htmlspecialchars($data["gender"]);
  $class_id = htmlspecialchars($data["class"]);

  $query = "UPDATE tb_student SET
  student_name = '$name',
  student_age = '$age', 
  student_gender = '$gender', 
  class_id = '$class_id'
  WHERE id = $id ";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}
//end function edit_students


//function add_class
function add_class($data)
{
  global $con;
  $class = htmlspecialchars($data["class"]);
  $teacher = htmlspecialchars(implode(",", ($data["teacher_id"])));


  $query = "INSERT INTO tb_class VALUE
  (null,'$class','$teacher' )";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}
//end function add_class


//function edit_class
function edit_class($data)
{
  global $con;
  $id = $data["id"];
  $class = htmlspecialchars($data["class"]);
  $teacher = htmlspecialchars(implode(",", ($data["teacher_id"])));


  $query = "UPDATE tb_class SET
  class_name = '$class',
  teacher_id = '$teacher'
  WHERE id = $id ";

  mysqli_query($con, $query) or die(mysqli_error($con));
  return mysqli_affected_rows($con);
}
//end function edit_class


//function search_student
function search_student($keyword)
{
  $query = "SELECT * FROM tb_class 
  RIGHT JOIN tb_student 
  ON tb_student.class_id = tb_class.id WHERE
          student_name LIKE '%$keyword%' OR
          student_age LIKE '%$keyword%' OR
          student_gender LIKE '%$keyword%'
          ";
  return query($query);
}
//end function search_student


//function register
function register($data)
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
  $role_id = 2;
  $is_active = 0;

  //create table tb_user
  $create = "
   CREATE TABLE IF NOT EXISTS tb_user(
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
  $create = "
   CREATE TABLE IF NOT EXISTS tb_gender(
     `id` INT AUTO_INCREMENT,
     `gender` VARCHAR(100),
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con, $create);
  $insertTbGender = "
  INSERT INTO `tb_gender` (`Id`, `gender`) VALUES
  (1, 'Lelaki'),
  (2, 'Perempuan')";
  mysqli_query($con, $insertTbGender);
  //end create table tb_gender

  //create table tb_role
  $create = "
   CREATE TABLE IF NOT EXISTS tb_role(
     `role_id` INT AUTO_INCREMENT,
     `role_name` VARCHAR(200),
     PRIMARY KEY (`role_id`)
  )";
  mysqli_query($con, $create);
  $insertTbRole = "
  INSERT INTO `tb_role` (`role_Id`, `role_name`) VALUES
  (1, 'admin'),
  (2, 'moderator'),
  (3, 'member')";
  mysqli_query($con, $insertTbRole);
  //end create table tb_role


  //create table tb_stages and insert data
  $createTbDarjah = "
   CREATE TABLE IF NOT EXISTS tb_stages(
     `id` INT AUTO_INCREMENT,
     `student_age` INT,
     `stages_age` VARCHAR(200),
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con, $createTbDarjah);
  $insertTbDarjah = "
  INSERT INTO `tb_stages` (`Id`, `student_age`, `stages_age`) VALUES
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
  //end create table tb_stages and insert data


  //create table tb_class and INSERT
  $createTbKelas = "
   CREATE TABLE IF NOT EXISTS tb_class(
     `id` INT AUTO_INCREMENT,
     `class_name` VARCHAR(200),
     `teacher_id` VARCHAR(300),
     PRIMARY KEY (`id`)
  )";
  mysqli_query($con, $createTbKelas);
  $insertTbKelas = "
  INSERT INTO `tb_class` (`Id`,`class_name`) VALUES
  (1, 'Class A'), 
  (2, 'Class B'),
  (3, 'Class C'), 
  (4, 'Class D')";
  mysqli_query($con, $insertTbKelas);
  //end create table tb_class and INSERT


  // create tb_class_teacher  
  $create = "
    CREATE TABLE IF NOT EXISTS tb_class_teacher(
      `id` INT AUTO_INCREMENT,
      `class_id` INT,
      `teacher_id` INT,
      PRIMARY KEY (`id`))";
  mysqli_query($con, $create);
  // akhir create tb_class_teacher


  // create tb_class_subjects  
  $create = "
    CREATE TABLE IF NOT EXISTS tb_class_subjects(
      `id` INT AUTO_INCREMENT,
      `class_id` INT,
      `subjects_id` INT,
      PRIMARY KEY (`id`))";
  mysqli_query($con, $create);
  // akhir create tb_class_subjects


  // create tb_subjects   
  $create = "
 CREATE TABLE IF NOT EXISTS tb_subjects(
   `id` INT AUTO_INCREMENT,
   `subjects_name` VARCHAR(200),
   `teacher_id` VARCHAR(300),
   PRIMARY KEY (`id`))";
  mysqli_query($con, $create);
  // akhir create tb_subjects


  // create tb_student
  $create = "
  CREATE TABLE IF NOT EXISTS tb_student(
    `id` INT AUTO_INCREMENT,
    `student_name` VARCHAR(200),
    `student_age` VARCHAR(200),
    `student_gender` VARCHAR(200),
    `class_id` INT,
    PRIMARY KEY (`id`))";
  mysqli_query($con, $create);
  // end create tb_student 

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


//function login
function login($data)
{
  global $con;
  $email = htmlspecialchars($data["email"]);
  $password = htmlspecialchars($data["password"]);

  $result = mysqli_query($con,  "SELECT * FROM tb_user WHERE email = '$email' || phone_number = '$email' || username = '$email'");

  if (mysqli_num_rows($result) === 1) {

    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {

      if ($row["is_active"] == 0) {
        echo  "<div class=\"register-box\">
        <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
          <h4>NOTE !</h4>
          <p>Please Contact Admin To Active your Account !</p>
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
          </button>
        </div>
        </div>";
        return false;
      }

      $role = mysqli_query($con, "SELECT * FROM tb_role WHERE role_id = $row[role_id]");
      $role_id = mysqli_fetch_assoc($role);

      $cek = mysqli_num_rows($result);
      if ($cek > 0) {
        myRole($role_id["role_name"], $row["id"]);
      }
    } else {
      echo "
      <div class=\"login-box\">
        <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
          <p>Incorrect Username / Password !</p>
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
          </button>
        </div>
      </div>
      ";
    }
  } else {
    echo "
      <div class=\"login-box\">
        <div class=\"alert alert-danger alert-dismissible fade show pb-0\" role=\"alert\">
          <p>Are You Sure This Email? <br> Email Not Registered !</p>
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
          </button>
        </div>
      </div>
          ";
  }
}
//end function login

//role management
function myRole($role, $rowId)
{
  if ($role == "admin") {
    $_SESSION["admin"] = [
      'name' => $role,
      'roleid' => $rowId
    ];
    $myRole = $_SESSION["admin"];
    echo "<script>
          window.location.href='/'
          </script>";
    return $myRole;
  } elseif ($role == "moderator") {
    $_SESSION["moderator"] = [
      'name' => $role,
      'roleid' => $rowId
    ];
    $myRole = $_SESSION["moderator"];
    echo "<script>
          window.location.href='/moderator/'
          </script>";
    return $myRole;
  } elseif ($role == "member") {
    $_SESSION["member"] = [
      'name' => $role,
      'roleid' => $rowId
    ];
    $myRole = $_SESSION["member"];
    echo "<script>
          window.location.href='/member/'
          </script>";
    return $myRole;
  }
}
// end role management

function role()
{
  if (isset($_SESSION["admin"])) {
    $login = $_SESSION["admin"];
  } elseif (isset($_SESSION["moderator"])) {
    $login = $_SESSION["moderator"];
  } elseif (isset($_SESSION["member"])) {
    $login = $_SESSION["member"];
  }
  return $login;
}

function roleProtect($role)
{
  if (role()["name"] == $role) {
    $role = $_SESSION[$role]["name"];
    return $role;
  }
}
