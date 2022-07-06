<?php require_once "teacher-template/member-header.php"; ?>
<?php

$x = "
<div class=\"row py-3 my-3 \">
  <div class=\"col-12\">
";
$y = "
<div class=\"row py-3 my-3 \">
  <div class=\"col-12\">
    <a href=\"?page\" class=\"btn btn-primary ml-0 mb-2\">Back</a>
";
$z = "
  </div>
</div>
";

$page = @$_GET['page'];
$action = @$_GET['action'];

if ($page == "myprofile") {
  echo $y;
  require_once "user/profile.php";
  echo $z;
} elseif ($page == "teachers") {
  // teacher 
  echo $y;
  require_once "teachers/teacher.php";
  echo $z;
} elseif ($page == "subjects") {
  // subjects 
  if ($action == "") {
    echo $y;
    require_once "subjects/subject.php";
    echo $z;
  } elseif ($action == "add") {
    require_once "subjects/add.php";
  } elseif ($action == "edit") {
    require_once "subjects/edit.php";
  } else {
    notFound();
  }
} elseif ($page == "students") {
  // students 
  if ($action == "") {
    echo $y;
    require_once "students/student.php";
    echo $z;
  } elseif ($action == "add") {
    require_once "students/add.php";
  } elseif ($action == "edit") {
    require_once "students/edit.php";
  } else {
    notFound();
  }
} elseif ($page == "classes") {
  // classes 
  if ($action == "") {
    echo $y;
    require_once "classes/class.php";
    echo $z;
  } elseif ($action == "add") {
    require_once "classes/add.php";
  } elseif ($action == "edit") {
    require_once "classes/edit.php";
  } else {
    notFound();
  }
} else {
  require_once "default.php";
}
?>
<?php require_once "teacher-template/member-footer.php"; ?>