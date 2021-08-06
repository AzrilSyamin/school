<?php include_once "../_header.php"; ?>
<?php

if (isset($_POST["submit"])) {
    if (add_subjects($_POST) > 0) {
      echo "<script>
      alert('Data Berhasil Ditambah');
      document.location.href='../subjects/subject.php';
      </script>
      ";
    } else {
      var_dump(mysqli_error($con));
       $error=true;

      
    }
  }
?>

                    <!-- Page Heading -->
                    <h1>Add New Subjects</h1>
                        <div class="row justify-content-center">
                            <!-- Awal Form  -->
                            <div class="col-12 col-md-6 p-4 shadow">
                            <?php if(isset($error)):?>
                                <div class="alert alert-danger" role="alert">
                                    <p>Subjects is <b>not added!</b>
                                    <br> Please again try later...</p>
                                </div>
                            <?php endif;?>
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="mata">Nama Mata Pelajaran :</label>
                                        <input type="text" class="form-control" name="mata" id="mata " autofocus required>
                                    </div>
                      
                      <div class="form-group">
                                        <label for="idcikgu">No Cikgu :</label>
                                        <input type="number" class="form-control" name="idcikgu" id="idcikgu " required>
                                    </div>
                     
                                    <button type="submit" class="btn btn-primary" name="submit">Add New Subject</button>
                                </form>
                            </div>
                            <!-- Akhir Form  -->
                        </div>
<?php include_once "../_footer.php"; ?>
