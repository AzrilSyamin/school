<?php require "../_header.php";

$students = query("SELECT * FROM tb_student
                  LEFT JOIN tb_teacher
                  ON tb_student.teacher_id = tb_teacher.id

                  JOIN tb_class
                  ON tb_student.class_id = tb_class.id

                  JOIN tb_stages
                  ON tb_student.student_age = tb_stages.student_age
                 ");
// var_dump($students);
// die;
?>

<!-- DataTales Students -->
<h3>Students Detail</h3>
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped text-center" id="dataTable" width="100%" cellspacing="0">
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
              <td><?= $student["teacher_name"]; ?></td>
              <td>
                <?php $pelajaran = query("SELECT * FROM tb_subjects 
                                        JOIN tb_teacher
                                        ON tb_subjects.teacher_id = tb_teacher.id WHERE teacher_id = '$student[teacher_id]'");
                foreach ($pelajaran as $p) : ?>
                  <ul>
                    <li><?= $p["subjects_name"]; ?></li>
                  </ul>
                <?php endforeach; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- End DataTales Students -->

<?php require "../_footer.php" ?>