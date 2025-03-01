<!doctype html>
<html lang="en">

<?php
include 'components/head.php';
?>

<body>

<?php
include 'components/navbar.php';
?>


  <div class="wrapper align-items-stretch">
    

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5">



      <section id="main-content">
        <section class="wrapper">
          <!--overview start-->
          <div class="row">
            <div class="col-lg-12">
              <ol class="breadcrumb">
                <li><i class="fa fa-sticky-note"></i><a href="kriteria.php"> Kriteria</a></li>
              </ol>
            </div>
          </div>

          <!--START SCRIPT HITUNG-->
          <script>
            function fungsiku() {
              var a = (document.getElementById("alur_cerita_param").value).substring(0, 1);
              var b = (document.getElementById("karakterisasi_param").value).substring(0, 1);
              var c = (document.getElementById("penyutradaraan_param").value).substring(0, 1);
              var d = (document.getElementById("akting_param").value).substring(0, 1);
              var e = (document.getElementById("sinematografi_param").value).substring(0, 1);
              var f = (document.getElementById("tata_artistik_param").value).substring(0, 1);

              var total = Number(a) + Number(b) + Number(c) + Number(d) + Number(e) + Number(f);

              document.getElementById("alur_cerita").value = (Number(a) / total).toFixed(2);
              document.getElementById("karakterisasi").value = (Number(b) / total).toFixed(2);
              document.getElementById("penyutradaraan").value = (Number(c) / total).toFixed(2);
              document.getElementById("akting").value = (Number(d) / total).toFixed(2);
              document.getElementById("sinematografi").value = (Number(e) / total).toFixed(2);
              document.getElementById("tata_artistik").value = (Number(f) / total).toFixed(2);
            }
          </script>
          <!--END SCRIPT HITUNG-->


          <!--START SCRIPT INSERT-->
          <?php

          include 'koneksi.php';

          if (isset($_POST['submit'])) {
            $alur_cerita = $_POST['alur_cerita'];
            $karakterisasi = $_POST['karakterisasi'];
            $penyutradaraan = $_POST['penyutradaraan'];
            $akting = $_POST['akting'];
            $sinematografi = $_POST['sinematografi'];
            $tata_artistik = $_POST['tata_artistik'];
            if (($alur_cerita == "") or
              ($karakterisasi == "") or
              ($penyutradaraan == "") or
              ($akting == "") or
              ($sinematografi == "") or
              ($tata_artistik == "")
            ) {
              echo "<script>
              alert('Tolong Lengkapi Data yang Ada!');
              </script>";
            } else {
              $sql = "SELECT * FROM kriteria";
              $hasil = $conn->query($sql);
              $rows = $hasil->num_rows;
              if ($rows > 0) {
                echo "<script>
                alert('Hapus Bobot Lama untuk Membuat Bobot Baru');
                </script>";
              } else {
                $sql = "INSERT INTO kriteria(
                  alur_cerita,karakterisasi,penyutradaraan,akting,sinematografi,tata_artistik)
                  values ('" . $alur_cerita . "',
                  '" . $karakterisasi . "',
                  '" . $penyutradaraan . "',
                  '" . $akting . "',
                  '" . $sinematografi . "',
                  '" . $tata_artistik . "')";
                $hasil = $conn->query($sql);
                echo "<script>
                alert('Bobot Berhasil di Inputkan!');
                </script>";
              }
            }
          }
          ?>
          <!-- END SCRIPT INSERT-->

            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#tambahKriteriaModal">
              <i class="fa fa-plus"></i> Tambah Kriteria
            </button>


          <div class="modal fade" id="tambahKriteriaModal" tabindex="-1" role="dialog" aria-labelledby="tambahKriteriaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahKriteriaModalLabel">Tambah Kriteria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
          </div>
          <div class="modal-body">
          <!--start inputan-->
          <form class="form-validate form-horizontal" id="register_form" method="post" action="">
            <div class="form-group row">
              <label class="col"><b>Kriteria</b></label>
              <div class="col">
                <label><b>Bobot</b></label>
              </div>
              <div class="col">
                <label><b>Perbaikan Bobot</b></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col">Alur Cerita</label>
              <div class="col">
                <select class="form-control" name="alur_cerita_param" id="alur_cerita_param">
                  <option>1. Sangat Rendah</option>
                  <option>2. Rendah</option>
                  <option>3. Cukup</option>
                  <option>4. Tinggi</option>
                  <option>5. Sangat Tinggi</option>
                </select>
              </div>
              <div class="col">
                <input type="text" class="form-control" name="alur_cerita" id="alur_cerita">
              </div>
            </div>
            <div class="form-group row">
              <label class="col">Karakterisasi</label>
              <div class="col">
                <select class="form-control" name="karakterisasi_param" id="karakterisasi_param">
                  <option>1. Sangat Rendah</option>
                  <option>2. Rendah</option>
                  <option>3. Cukup</option>
                  <option>4. Tinggi</option>
                  <option>5. Sangat Tinggi</option>
                </select>
              </div>
              <div class="col">
                <input type="text" class="form-control" name="karakterisasi" id="karakterisasi">
              </div>
            </div>
            <div class="form-group row">
              <label class="col">Penyutradaraan</label>
              <div class="col">
                <select class="form-control" name="penyutradaraan_param" id="penyutradaraan_param">
                  <option>1. Sangat Rendah</option>
                  <option>2. Rendah</option>
                  <option>3. Cukup</option>
                  <option>4. Tinggi</option>
                  <option>5. Sangat Tinggi</option>
                </select>
              </div>
              <div class="col">
                <input type="text" class="form-control" name="penyutradaraan" id="penyutradaraan">
              </div>
            </div>
            <div class="form-group row">
              <label class="col">Akting</label>
              <div class="col">
                <select class="form-control" name="akting_param" id="akting_param">
                  <option>1. Sangat Rendah</option>
                  <option>2. Rendah</option>
                  <option>3. Cukup</option>
                  <option>4. Tinggi</option>
                  <option>5. Sangat Tinggi</option>
                </select>
              </div>
              <div class="col">
                <input type="text" class="form-control" name="akting" id="akting">
              </div>
            </div>
            <div class="form-group row">
              <label class="col">Sinematografi</label>
              <div class="col">
                <select class="form-control" name="sinematografi_param" id="sinematografi_param">
                  <option>1. Sangat Rendah</option>
                  <option>2. Rendah</option>
                  <option>3. Cukup</option>
                  <option>4. Tinggi</option>
                  <option>5. Sangat Tinggi</option>
                </select>
              </div>
              <div class="col">
                <input type="text" class="form-control" name="sinematografi" id="sinematografi">
              </div>
            </div>
            <div class="form-group row">
              <label class="col">Tata Artistik</label>
              <div class="col">
                <select class="form-control" name="tata_artistik_param" id="tata_artistik_param">
                  <option>1. Sangat Rendah</option>
                  <option>2. Rendah</option>
                  <option>3. Cukup</option>
                  <option>4. Tinggi</option>
                  <option>5. Sangat Tinggi</option>
                </select>
              </div>
              <div class="col">
                <input type="text" class="form-control" name="tata_artistik" id="tata_artistik">
              </div>
            </div>
            <div class="mb-4">
              <button class="btn btn-outline-success" type="button" id="hitung" onclick="fungsiku()" name="hitung"><i class="fa fa-calculator"></i> Hitung</button>
              <button class="btn btn-outline-primary" type="submit" name="submit"><i class="fa fa-save"></i> Submit</button>
            </div>
          </form>
          </div>
          </div>
          </div>
          </div>

          <br>
          <br>

          <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th><i class="fa "></i> Alur Cerita</th>
                <th><i class="fa "></i> Karakterisasi</th>
                <th><i class="fa "></i> Penyutradaraan</th>
                <th><i class="fa "></i> Akting</th>
                <th><i class="fa "></i> Sinematografi</th>
                <th><i class="fa "></i> Tata_artistik</th>
                <th><i class="fa "></i> Aksi</th>
              </tr>
            </thead>
            <?php
            $b = 0;
            $sql = "SELECT * FROM kriteria";
            $hasil = $conn->query($sql);
            $rows = $hasil->num_rows;
            if ($rows > 0) {
              while ($row = $hasil->fetch_row()) {
            ?>
                <tr>
                  <td Align="center"><?= $row[1] ?></td>
                  <td Align="center"><?= $row[2] ?></td>
                  <td Align="center"><?= $row[3] ?></td>
                  <td Align="center"><?= $row[4] ?></td>
                  <td Align="center"><?= $row[5] ?></td>
                  <td Align="center"><?= $row[6] ?></td>
                  <td>
                    <div class="btn-group">
                      <a class="btn btn-danger" href="kriteria_hapus.php?id=<?= $row[0] ?>"><i class="fa fa-close"></i></a>
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
          </div>
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