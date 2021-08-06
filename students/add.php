<?php include_once "../_header.php"; ?>
<?php

if (isset($_POST["submit"])) {
    if (add_students($_POST) > 0) {
      echo "<script>
      
      document.location.href='../students/student.php';
      </script>
      ";
    } else {
       $error=true;

      
    }
  }
?>

                    <!-- Page Heading -->
                    <h1>Add New Students</h1>
                        <div class="row justify-content-center">
                            <!-- Awal Form  -->
                            <div class="col-12 col-md-6 p-4 shadow">
                            <?php if(isset($error)):?>
                                <div class="alert alert-danger" role="alert">
                                    <p>Student is <b>not added!</b>
                                    <br> Please again try later...</p>
                                </div>
                            <?php endif;?>
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="nama">Nama :</label>
                                        <input type="text" class="form-control" name="nama" id="nama " autofocus required>
                                    </div>

                                    <div class="form-group">
                                        <label for="umur">Umur :</label>
                                        <select name="umur" id="umur" class="form-control">
                                        <option selected>Choose...<?="";?></option>
                                        <?php
                                            $levels = query("SELECT * FROM tb_darjah");
                                            foreach($levels as $level):?>
                                            <option><?= $level["umur_pelajar"];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="jantina">Jantina :</label>
                                        <select name="jantina" id="jantina" class="form-control">
                                            <option selected>Choose...</option>
                                            <option>Lelaki</option>
                                            <option>Perempuan</option>
                                        </select>
                                        </div>
                                    
                                    <div class="form-group">
                                        <label for="kelas">Kelas :</label>
                                        <select name="kelas" id="kelas" class="form-control">
                                            <option selected>Choose...</option>
                                            <?php
                                            $classes = query("SELECT * FROM tb_kelas");
                                            foreach($classes as $class):?>
                                            <option><?= $class["id"];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="cikgu">Cikgu :</label>
                                        <select name="cikgu" id="cikgu" class="form-control">
                                            <option selected>Choose...</option>
                                            <?php
                                            $teachers = query("SELECT * FROM tb_cikgu");
                                            foreach($teachers as $teacher):?>
                                            <option><?= $teacher["id"];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary" name="submit">Add New Student</button>
                                </form>
                            </div>
                            <!-- Akhir Form  -->
                        </div>
<?php include_once "../_footer.php"; ?>
