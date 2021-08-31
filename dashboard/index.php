<?php require "../_header.php";

$students = query("SELECT * FROM tb_student
                  LEFT JOIN tb_user
                  ON tb_student.teacher_id = tb_user.id

                  JOIN tb_class
                  ON tb_student.class_id = tb_class.id

                  JOIN tb_stages
                  ON tb_student.student_age = tb_stages.student_age
                 ");

?>



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
            <td><?= $student["first_name"]; ?></td>
            <td>
              <?php $pelajaran = query("SELECT * FROM tb_subjects 
                                        JOIN tb_user
                                        ON tb_subjects.teacher_id = tb_user.id WHERE teacher_id = '$student[teacher_id]'");
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
<!-- End DataTales Students -->

<?php require "../_footer.php" ?>