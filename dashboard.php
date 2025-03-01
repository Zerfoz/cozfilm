<!doctype html>
<html lang="en">

<style>
/* CSS kustom untuk tata letak grid */
.grid-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    background-color: lightgray; /* Setel warna latar belakang kotak */
    padding: 10px; /* Tambahkan jarak antar elemen */
}

.grid-item {
    flex-basis: 23%; /* Setel lebar setiap elemen agar sesuai dengan empat kolom */
    padding: 5px;
    border: 1px solid white; /* Tambahkan garis pembatas untuk memisahkan elemen */
    margin-bottom: 10px; /* Tambahkan jarak antara kotak-kotak */
    text-align: center; /* Tengahkan konten */
    position: relative; /* Buat posisi relatif untuk mengatur teks di atas gambar */
    overflow: hidden; /* Sembunyikan teks saat tidak di-hover */
}

/* Gaya untuk teks di bawah gambar */
.film-content {
    position: relative;
    cursor: pointer;
}

.film-info {
    position: absolute;
    bottom: -100%; /* Sembunyikan teks di bawah grid-item saat tidak di-hover */
    left: 0;
    background-color: rgba(255, 255, 255, 0.7);
    padding: 5px;
    border-radius: 5px;
    width: 100%;
    transition: bottom 0.3s; /* Animasi untuk muncul ketika di-hover */
}

.film-number,
.film-name,
.film-studio,
.film-genre {
    margin: 5px;
}

/* Gaya untuk gambar */
img {
    max-width: 100%; /* Memastikan gambar tidak melebihi lebar parent (grid-item) */
    height: 100%; /* Mengatur tinggi sesuai proporsi gambar */
    transition: transform 0.3s; /* Animasi untuk memperkecil gambar saat di-hover */
}

/* Animasi memperkecil gambar saat di-hover */
.film-content:hover img {
    transform: scale(0.8);
}

/* Menampilkan teks di bawah gambar saat di-hover */
.film-content:hover .film-info {
    bottom: 0;
}


</style>

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
                                <li><i class="fa fa-user"></i><a href="index.php"> Dashboard</a></li>
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

<!-- Tabel untuk menampilkan data -->
<div class="grid-container">
    <?php
    $b = 0;
    $sql = "SELECT * FROM film ORDER BY nama ASC";
    $hasil = $conn->query($sql);
    $rows = $hasil->num_rows;
    if ($rows > 0) {
        while ($row = $hasil->fetch_assoc()) {
            $gambar = $row['gambar'];
    ?>
            <div class="grid-item">
                <div class="film-content">
                    <img src="<?= $gambar ?>" alt="Gambar Film">
                    <div class="film-info">
                        <div class="film-number">No: <?php echo $b = $b + 1; ?></div>
                        <div class="film-name"><?= $row['nama'] ?></div>
                        <div class="film-studio"><?= $row['studio'] ?></div>
                        <div class="film-genre"><?= $row['genre'] ?></div>
                    </div>
                </div></div>
    <?php
        }
    } else {
        echo "<div class='grid-item' style='flex-basis: 100%; text-align: center;'>Data Tidak Ada</div>";
    }
    ?>
</div>






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
