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
                                <li><i class="fa fa-user"></i><a href="index.php">Data Film</a></li>
                            </ol>
                        </div>
                    </div>

                    <!--START SCRIPT INSERT-->
                    <?php
                    include 'koneksi.php';

                    if (isset($_POST['submit'])) {
                        $nama = $_POST['nama'];
                        $studio = $_POST['studio'];
                        $genre = $_POST['genre'];
                    
                        // Proses upload gambar
                        $gambar = $_FILES['gambar']['name'];
                        $gambar_tmp = $_FILES['gambar']['tmp_name'];
                        $folder = "upload/"; // Folder tempat menyimpan gambar
                    
                        // Pastikan folder untuk menyimpan gambar ada dan memiliki izin tulis
                        if (!is_dir($folder)) {
                            mkdir($folder, 0777, true);
                        }
                    
                        // Pindahkan gambar yang diupload ke folder tujuan
                        move_uploaded_file($gambar_tmp, $folder . $gambar);
                    
                        if (($nama == "") or ($studio == "") or ($gambar == "")) {
                            echo "<script>alert('Tolong Lengkapi Data yang Ada!');</script>";
                        } else {
                            $sql = "SELECT * FROM film WHERE nama='$nama'";
                            $hasil = $conn->query($sql);
                            $rows = $hasil->num_rows;
                            if ($rows > 0) {
                                $row = $hasil->fetch_row();
                                echo "<script>alert('Film $nama Sudah Ada!');</script>";
                            } else {
                                $sql = "INSERT INTO film(nama, studio, genre, gambar) 
                                        VALUES ('" . $nama . "','" . $studio . "','" . $genre . "','" . $folder . $gambar . "')";
                                $hasil = $conn->query($sql);
                                echo "<script>alert('Data Berhasil di Tambahkan!');</script>";
                            }
                        }
                    }
                    
                    ?>
                    <!-- END SCRIPT INSERT-->

                    <!-- Tombol untuk memicu modal tambah film -->
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#tambahFilmModal">
                        <i class="fa fa-plus"></i> Tambah Film
                    </button>
                    <br>
                    <br>

                    <!-- Tabel untuk menampilkan data -->
                    <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Film</th>
                            <th>Studio</th>
                            <th>Genre</th>
                            <th>Gambar</th> <!-- Tambahkan kolom gambar -->
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
    <?php
    $b = 0;
    $sql = "SELECT * FROM film ORDER BY nama ASC";
    $hasil = $conn->query($sql);
    $rows = $hasil->num_rows;
    if ($rows > 0) {
        while ($row = $hasil->fetch_row()) {
    ?>
            <tr>
                <td><?php echo $b = $b + 1; ?></td>
                <td><?= $row[0] ?></td>
                <td><?= $row[1] ?></td>
                <td><?= $row[2] ?></td>
                <td>
                    <?php
                    // Jika ada URL atau direktori gambar, tampilkan gambar
                    if (isset($row[3]) && !empty($row[3])) {
                    ?>
                        <img src="<?= $row[3] ?>" alt="<?= $row[0] ?>" style="width: 100px;"> <!-- Tambahkan tag img -->
                    <?php
                    } else {
                        echo "Tidak Ada Gambar";
                    }
                    ?>
                </td>
                <td>
                    <div class="btn-group">
                         <a class="btn btn-success" href="alt_ubah.php?nama=<?= $row[0] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger" href="alt_hapus.php?nama=<?= $row[0] ?>"><i class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
    <?php }
    } else {
        echo "<tr>
                <td>Data Tidak Ada</td>
            </tr>";
    } ?>
</tbody>

                    </table>

                </section>
            </section>
        </div>
    </div>

    <!-- Modal tambah film -->
    <div class="modal fade" id="tambahFilmModal" tabindex="-1" role="dialog" aria-labelledby="tambahFilmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahFilmModalLabel">Tambah Film</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
    <!-- Form inputan untuk tambah film -->
    <form method="POST" action="" enctype="multipart/form-data"> <!-- Tambahkan atribut enctype untuk menghandle input file -->
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Nama Film</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="nama">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Nama Studio</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="studio">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Genre</label>
            <div class="col-sm-8">
                <select class="form-control" name="genre">
                    <option>Action</option>
                    <option>Fantasy</option>
                    <option>Horror</option>
                    <option>Romance</option>
                    <option>Mystery</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Gambar</label>
            <div class="col-sm-8">
                <input type="file" name="gambar"> <!-- Tambahkan input file untuk gambar -->
            </div>
        </div>
        <div class="mb-4">
            <button type="submit" name="submit" class="btn btn-outline-primary"><i class="fa fa-save"></i> Submit</button>
        </div>
    </form>
    <!-- AKHIR Form inputan -->
</div>
            </div>
        </div>
    </div>

<!-- Modal ubah film -->
<!-- <div class="modal fade" id="ubahFilmModal" tabindex="-1" role="dialog" aria-labelledby="ubahFilmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahFilmModalLabel">Ubah Film</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> -->
                <!-- Konten dari alt_ubah.php akan dimasukkan di sini menggunakan JavaScript -->
            <!-- </div>
        </div>
    </div>
</div> -->






    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
//     $(document).ready(function() {
//         // Pemanggilan konten alt_ubah.php saat tombol "Ubah" ditekan
//         $(".btn-ubah-film").on("click", function() {
//             var namaFilmClicked = $(this).data("nama");
//             var studioFilmClicked = $(this).data("studio");
//             var genreFilmClicked = $(this).data("genre");
            
//             var modal = $("#ubahFilmModal");
//             $.ajax({
//                 url: "alt_ubah.php?nama=" + namaFilmClicked,
//                 success: function(result) {
//                     modal.find(".modal-body").html(result);
//                     // Setel nilai pada form dengan data yang sesuai
//                     modal.find("[name='nama']").val(namaFilmClicked);
//                     modal.find("[name='studio']").val(studioFilmClicked);
//                     modal.find("[name='genre']").val(genreFilmClicked);
//                 }
//             });
//         });

//         // Fungsi untuk melakukan reload data setelah modal ditutup
//         $('#ubahFilmModal').on('hidden.bs.modal', function () {
//             location.reload();
//         });
//     });
// </script>




</body>

</html>
