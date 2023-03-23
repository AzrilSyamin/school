<?php
session_start();
$link = __DIR__ . "/config.php";

if (!file_exists($link)) {
  header("location:/setup.php");
} else {
  require_once "config.php";
  $con = mysqli_connect($host, $user, $pass, $db_name);
}

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
//end function query


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
    $login = $_SESSION["admin"]["roleid"];
  } elseif (isset($_SESSION["moderator"])) {
    $login = $_SESSION["moderator"]["roleid"];
  } elseif (isset($_SESSION["member"])) {
    $login = $_SESSION["member"]["roleid"];
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
  $role_id = 3;
  $is_active = 0;

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


function notFound($back = "")
{
  echo '<p style="background-color:' . $back . ';">Not Content Available...</p>';
}
