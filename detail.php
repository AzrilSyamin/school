<?php include_once "_header.php"; ?>
<?php

$students= query("SELECT * FROM tb_pelajar
                 
                 JOIN tb_cikgu
                 ON tb_pelajar.cikgu_id = tb_cikgu.id
                 
                 JOIN tb_kelas
                 ON tb_pelajar.kelas_id = tb_kelas.id
                 
                 JOIN tb_darjah
                 ON tb_pelajar.umur_pelajar = tb_darjah.umur_pelajar
             
                 
                 ");

?>

                    <!-- Page Heading -->
                    <h1>Detail Of Students</h1>
                    <div class="row">
                        
                        <?php foreach($students as $student):?>
                        <div class="col-12 col-md-6 my-3">
                        <ul class="list-group shadow">
                            <li class="list-group-item"><b>Name :</b><?= $student["nama_pelajar"];?></li>
                            <li class="list-group-item"><b>Umur :</b><?= $student["umur_pelajar"];?></li>
                            <li class="list-group-item"><b>Kelas :</b><?= $student["nama_kelas"];?></li>
                            <li class="list-group-item"><b>Darjah :</b><?= $student["darjah_pelajar"];?></li>
                            <li class="list-group-item"><b>Cikgu :</b><?= $student["nama_cikgu"];?></li>
                            <li class="list-group-item"><b>Pelajaran :</b>

                            <?php $pelajaran = query ("SELECT * FROM tb_pelajaran 
                            JOIN tb_cikgu
                            ON tb_pelajaran.cikgu_id = tb_cikgu.id WHERE cikgu_id = '$student[cikgu_id]'");
                            foreach($pelajaran as $p):?>
                            <?=$p["mata_pelajaran"]; echo"<br>";?>
                            <?php endforeach;?>
                            
                            </li>
                        </ul>
                        </div>
                        <?php endforeach;?>
                        
                    </div>
<?php include_once "_footer.php"; ?>