<?php require "../_header.php";

$students = query("SELECT * FROM tb_student
                  LEFT JOIN tb_user
                  ON tb_student.teacher_id = tb_user.id

                  JOIN tb_class
                  ON tb_student.class_id = tb_class.id

                  JOIN tb_stages
                  ON tb_student.student_age = tb_stages.student_age
                 ");

$teacher = query("SELECT * FROM tb_user");
$subjects = query("SELECT * FROM tb_subjects");
$student = query("SELECT * FROM tb_student");
?>


<!-- Start Card  -->
<div class="row mb-4">
  <div class="col-12 col-md-4">
    <div class="card  text-white shadow bg-dark mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-8">
            <h5 class="card-text">TOTAL TEACHERS</h5>
          </div>
          <div class="col-4">
            <h2><b><?= count($teacher); ?></b></h2>
          </div>
          <div class="col-12">
            <p><a href="../teachers/teacher.php" class="text-white"> View Details</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="card  text-white shadow bg-danger mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-8">
            <h5 class="card-text">TOTAL SUBJECTS</h5>
          </div>
          <div class="col-4">
            <h2><b><?= count($subjects); ?></b></h2>
          </div>
          <div class="col-12">
            <p><a href="../subjects/subject.php" class="text-white"> View Details</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="card  text-white shadow bg-success mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-8">
            <h5 class="card-text">TOTAL STUDENTS</h5>
          </div>
          <div class="col-4">
            <h2><b><?= count($student); ?></b></h2>
          </div>
          <div class="col-12">
            <p><a href="../students/student.php" class="text-white"> View Details</a></p>
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
            <td><?= $student["first_name"] . " " . $student["last_name"]; ?></td>
            <td>
              <?php $pelajaran = query("SELECT * FROM tb_subjects 
                                        JOIN tb_user
                                        ON tb_subjects.teacher_id = tb_user.id WHERE teacher_id = '$student[teacher_id]'");
              foreach ($pelajaran as $p) : ?>
                <li class="list-unstyled"><?= $p["subjects_name"]; ?></li>
              <?php endforeach; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<!-- End DataTales Students -->

<?php require "../_footer.php" ?>