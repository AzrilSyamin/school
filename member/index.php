<?php require_once "teacher-template/member-header.php"; ?>
  <?php

  $page = @$_GET['page'];
  $action = @$_GET['action'];
  if ($page == "myprofile") {
    require_once "user/profile.php";
  } elseif ($page == "teachers") {
    // teacher 
    require_once "teachers/teacher.php";
  } elseif ($page == "subjects") {
    // subjects 
    if ($action == "") {
      require_once "subjects/subject.php";
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
      require_once "students/student.php";
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
      require_once "classes/class.php";
    } elseif ($action == "add") {
      require_once "classes/add.php";
    } elseif ($action == "edit") {
      require_once "classes/edit.php";
    } else {
      notFound();
    }
  } else {
    notFound();
  }
  ?>
<?php require_once "teacher-template/member-footer.php"; ?>