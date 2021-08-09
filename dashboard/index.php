<?php require "../_header.php";

$students = query("SELECT * FROM tb_pelajar
                  JOIN tb_cikgu
                  ON tb_pelajar.cikgu_id = tb_cikgu.id

                  JOIN tb_kelas
                  ON tb_pelajar.kelas_id = tb_kelas.id

                  JOIN tb_darjah
                  ON tb_pelajar.umur_pelajar = tb_darjah.umur_pelajar
                 ");
// var_dump($students);
// die;
?>

<!-- DataTales Pelajar -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h4 class="m-0 font-weight-bold text-primary">Detail Pelajar</h4>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-dark">
          <tr>
            <th>Name</th>
            <th>Umur</th>
            <th>Kelas</th>
            <th>Darjah</th>
            <th>Cikgu</th>
            <th>Pelajaran</th>
          </tr>
        </thead>
        <tfoot class="thead-dark">
          <tr>
            <th>Name</th>
            <th>Umur</th>
            <th>Kelas</th>
            <th>Darjah</th>
            <th>Cikgu</th>
            <th>Pelajaran</th>
          </tr>
        </tfoot>
        <tbody>
          <?php foreach ($students as $student) : ?>
            <tr>
              <td><?= $student["nama_pelajar"]; ?></td>
              <td><?= $student["umur_pelajar"]; ?></td>
              <td><?= $student["nama_kelas"]; ?></td>
              <td><?= $student["darjah_pelajar"]; ?></td>
              <td><?= $student["nama_cikgu"]; ?></td>
              <td>
                <?php $pelajaran = query("SELECT * FROM tb_pelajaran 
                                        JOIN tb_cikgu
                                        ON tb_pelajaran.cikgu_id = tb_cikgu.id WHERE cikgu_id = '$student[cikgu_id]'");
                foreach ($pelajaran as $p) : ?>
                  <ul>
                    <li><?= $p["mata_pelajaran"]; ?></li>
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
<!-- End DataTales Pelajar -->

<?php require "../_footer.php" ?>