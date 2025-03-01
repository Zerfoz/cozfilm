<!doctype html>
<html lang="en">

<?php
include 'components/head.php';
?>

<body>

<?php
include 'components/navbar.php';
?>

  <div class="wrapperalign-items-stretch">
    
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5">

      <section id="main-content">
        <section class="wrapper">
          <!--overview start-->
          <div class="row">
            <div class="col-lg-12">
              <ol class="breadcrumb">
                <li><i class="fa fa-list-ol"></i><a href="penilaian.php">Penilaian Alternatif</a></li>
              </ol>
            </div>
          </div>

          <!--START SCRIPT INSERT-->
          <?php

          include 'koneksi.php';

          if (isset($_POST['submit'])) {
            $nama = $_POST['nama'];
            $alur_cerita = $_POST['alur_cerita'];
            $karakterisasi = substr($_POST['karakterisasi'], 1, 1);
            $penyutradaraan = substr($_POST['penyutradaraan'], 1, 1);
            $akting = substr($_POST['akting'], 1, 1);
            $sinematografi = substr($_POST['sinematografi'], 1, 1);
            $tata_artistik = substr($_POST['tata_artistik'], 1, 1);
            if ($alur_cerita == "" || $karakterisasi == "" || $penyutradaraan == "" || $akting == "" || $sinematografi == "" || $alur_cerita == "") {
              echo "<script>
              alert('Tolong Lengkapi Data yang Ada!');
              </script>";
            } else {
              $sql = "SELECT*FROM penilaian WHERE nama='$nama'";
              $hasil = $conn->query($sql);
              $rows = $hasil->num_rows;
              if ($rows > 0) {
                $row = $hasil->fetch_row();
                echo "<script>
                alert('Aplikasi $nama sudah ada!');
                </script>";
              } else {
                //insert name
                $sql = "INSERT INTO penilaian(
                nama,alur_cerita,karakterisasi,penyutradaraan,akting,sinematografi,tata_artistik)
                values ('" . $nama . "',
                '" . $alur_cerita . "',
                '" . $karakterisasi . "',
                '" . $penyutradaraan . "',
                '" . $akting . "',
                '" . $sinematografi . "',
                '" . $tata_artistik . "')";
                $hasil = $conn->query($sql);
                echo "<script>
                alert('Penilaian Berhasil di Tambahkan!');
                </script>";
              }
            }
          }
          ?>
          <!-- END SCRIPT INSERT-->
          <!-- Form inputan -->
          <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#tambahPenilaianModal">
            <i class="fa fa-plus"></i> Tambah Penilaian
          </button>
          <!-- Modal for adding penilaian -->
          <div class="modal fade" id="tambahPenilaianModal" tabindex="-1" role="dialog" aria-labelledby="tambahPenilaianModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="tambahPenilaianModalLabel">Tambah Penilaian</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
          <div class="modal-body">
          <!--start inputan-->
          <form method="POST" action="">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Alternatif</label>
              <div class="col-sm-6">
                <select class="form-control" name="nama">
                  <?php
                  //load nama
                  $sql = "SELECT * FROM film";
                  $hasil = $conn->query($sql);
                  $rows = $hasil->num_rows;
                  if ($rows > 0) {
                    while ($row = mysqli_fetch_array($hasil)) :; {
                      } ?> <option><?php echo $row[0]; ?></option>
                  <?php endwhile;
                  } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Alur_cerita</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="alur cerita" id="alur_cerita">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Karakterisasi</label>
              <div class="col-sm-6">
                <select class=" form-control" name="karakterisasi">
                <option>(1) Sangat Buruk</option>
                <option>(2) Buruk</option>
                <option>(3) Cukup Baik</option>
                <option>(4) Baik</option>
                <option>(5) Sangat Baik</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Penyutradaraan</label>
              <div class="col-sm-6">
                <select class=" form-control" name="penyutradaraan">
                <option>(1) Sangat Buruk</option>
                <option>(2) Buruk</option>
                <option>(3) Cukup Baik</option>
                <option>(4) Baik</option>
                <option>(5) Sangat Baik</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Akting</label>
              <div class="col-sm-6">
                <select class=" form-control" name="akting">
                <option>(1) Sangat Buruk</option>
                <option>(2) Buruk</option>
                <option>(3) Cukup Baik</option>
                <option>(4) Baik</option>
                <option>(5) Sangat Baik</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Sinematografi</label>
              <div class="col-sm-6">
                <select class=" form-control" name="sinematografi">
                <option>(1) Sangat Buruk</option>
                <option>(2) Buruk</option>
                <option>(3) Cukup Baik</option>
                <option>(4) Baik</option>
                <option>(5) Sangat Baik</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Tata artistik</label>
              <div class="col-sm-6">
                <select class=" form-control" name="tata_artistik">
                <option>(1) Sangat Buruk</option>
                <option>(2) Buruk</option>
                <option>(3) Cukup Baik</option>
                <option>(4) Baik</option>
                <option>(5) Sangat Baik</option>
                </select>
              </div>
            </div>
            <div class="mb-4">
              <button type="submit" name="submit" class="btn btn-outline-primary"><i class="fa fa-save"></i> Submit</button>
            </div>
          </form>
          </div>
              </div>
            </div>
          </div>
          <br>
          <br>
          <table class="table">
            <thead>
              <tr>
                <th><i class="fa "></i> No</th>
                <th><i class="fa "></i> Alternatif</th>
                <th><i class="fa "></i> Alur cerita</th>
                <th><i class="fa "></i> Karakterisasi</th>
                <th><i class="fa "></i> Penyutradaraan</th>
                <th><i class="fa "></i> Akting</th>
                <th><i class="fa "></i> Sinematografi</th>
                <th><i class="fa "></i> Tata_artistik</th>
                <th><i class="fa fa-cogs"></i> Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $b = 0;
              $sql = "SELECT*FROM penilaian ORDER BY nama ASC";
              $hasil = $conn->query($sql);
              $rows = $hasil->num_rows;
              if ($rows > 0) {
                while ($row = $hasil->fetch_row()) {
              ?>
                  <tr>
                    <td align="center"><?php echo $b = $b + 1; ?></td>
                    <td><?= $row[0] ?></td>
                    <td align="center"><?= $row[1] ?></td>
                    <td align="center"><?= $row[2] ?></td>
                    <td align="center"><?= $row[3] ?></td>
                    <td align="center"><?= $row[4] ?></td>
                    <td align="center"><?= $row[5] ?></td>
                    <td align="center"><?= $row[6] ?></td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-danger" href="penilaian_hapus.php?nama=<?= $row[0] ?>">
                          <i class="fa fa-close"></i></a>
                      </div>
                    </td>
                  </tr>
              <?php }
              } else {
                echo "<tr>
                    <td>Data Tidak Ada</td>
                <tr>";
              } ?>
            </tbody>
          </table>
        </section>
      </section>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>