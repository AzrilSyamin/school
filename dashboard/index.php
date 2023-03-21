<?php require_once "../_header.php";

$students = query("SELECT * FROM tb_student
LEFT JOIN tb_class
ON tb_student.class_id = tb_class.id
LEFT JOIN tb_stages
ON tb_student.student_age = tb_stages.student_age
                 ");
//print_r($students);

$teacher = query("SELECT * FROM tb_user");
$subjects = query("SELECT * FROM tb_subjects");
$totalStudent = query("SELECT * FROM tb_student");
$class = query("SELECT * FROM tb_class");
?>

<!-- welcome user  -->
<div class="row">
  <div class="col-12 text-center">
    <h3>Welcome Back '<span class="text-primary"><b><?= $users["first_name"] . " " . $users["last_name"] ?></b></span>'</h3>
  </div>
</div>
<!-- end welcome user  -->

<!-- Start Card  -->
<div class="row mb-4">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card  text-white shadow bg-gradient-primary mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-8">
            <h5 class="card-text">TOTAL TEACHERS</h5>
          </div>
          <div class="col-4">
            <h2><b><?= count($teacher); ?></b></h2>
          </div>
          <div class="col-8 pt-2">
            <p><a href="../teachers/teacher.php" class="text-white"> View Details</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card  text-white shadow bg-gradient-success mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-8">
            <h5 class="card-text">TOTAL SUBJECTS</h5>
          </div>
          <div class="col-4">
            <h2><b><?= count($subjects); ?></b></h2>
          </div>
          <div class="col-8 pt-2">
            <p><a href="../subjects/subject.php" class="text-white"> View Details</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card  text-white shadow bg-gradient-danger mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-8">
            <h5 class="card-text">TOTAL STUDENTS</h5>
          </div>
          <div class="col-4">
            <h2><b><?= count($totalStudent); ?></b></h2>
          </div>
          <div class="col-8 pt-2">
            <p><a href="../students/student.php" class="text-white"> View Details</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card  text-white shadow bg-gradient-info mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-8">
            <h5 class="card-text">TOTAL CLASSES</h5>
          </div>
          <div class="col-4">
            <h2><b><?= count($class); ?></b></h2>
          </div>
          <div class="col-8 pt-2">
            <p><a href="../classes/class.php" class="text-white"> View Details</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Start Card  -->
<!-- DataTales Students -->
<div class="card">
  <div class="card-header">
    <div class="row">
      <h4>Students Detail</h4>
    </div>
  </div>
  <div class="table-responsive shadow">
    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
      <thead class="thead-dark">
        <tr>
          <th>Name</th>
          <th>Age</th>
          <th>Class</th>
          <th>Stages</th>
          <th>Teacher</th>
          <th>Subjects</th>
        </tr>
      </thead>
      <tfoot class="thead-dark">
        <tr>
          <th>Name</th>
          <th>Age</th>
          <th>Class</th>
          <th>Stages</th>
          <th>Teacher</th>
          <th>Subjects</th>
        </tr>
      </tfoot>
      <tbody>
        <?php foreach ($students as $student) : ?>
          <tr>
            <td><?= $student["student_name"]; ?></td>
            <td><?= $student["student_age"]; ?></td>
            <td><?= $student["class_name"]; ?></td>
            <td><?= $student["stages_age"]; ?></td>
            <td>
              <?php
              $data = explode(",", $student["teacher_id"]);
              $teachers = query("SELECT * FROM tb_user");
              foreach ($teachers as $teacher) :
              ?>
                <li class="list-unstyled"><?php in_array($teacher["id"], $data) ? print "#" . " " . $teacher["first_name"] . " " . $teacher["last_name"] : null ?></li>
              <?php endforeach; ?>
            </td>
            <td>
              <?php
              $data = explode(",", $student["teacher_id"]);
              $subjectsList = query("SELECT * FROM tb_subjects");
              foreach ($subjectsList as $subjects) :
              ?>
                <li class="list-unstyled"><?php in_array($subjects["teacher_id"], $data) ? print "#" . " " . $subjects["subjects_name"] : null ?></li>
              <?php endforeach; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<!-- End DataTales Students -->

<?php require_once "../_footer.php" ?>