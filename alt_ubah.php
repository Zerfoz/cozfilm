<!doctype html>
<html lang="en">

<?php
include 'components/head.php';
?>

<body>
    

    <div class="wrapper d-flex align-items-stretch">

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5">

            <section id="main-content">
                <section class="wrapper">

                    <!--START SCRIPT UPDATE-->
                    <?php
                    include 'koneksi.php';

                    if (isset($_POST['edit'])) {
                        $nama_awal = $_GET['nama'];
                        $nama = $_POST['nama'];
                        $studio = $_POST['studio'];
                        $genre = $_POST['genre'];

                        // Proses gambar jika ada gambar yang diunggah
                        $gambar = $_FILES['gambar']['name'];
                        $gambar_tmp = $_FILES['gambar']['tmp_name'];
                        $folder = "upload/"; // Folder tempat menyimpan gambar

                        // Jika ada gambar yang diunggah, proses gambar baru
                        if (!empty($gambar)) {
                            $target_file = $folder . basename($gambar);
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                            // Cek apakah file gambar atau bukan
                            $check = getimagesize($_FILES["gambar"]["tmp_name"]);
                            if ($check === false) {
                                echo "<script>alert('File bukan gambar!');</script>";
                                $uploadOk = 0;
                            }

                            // Cek ukuran gambar
                            if ($_FILES["gambar"]["size"] > 500000) {
                                echo "<script>alert('Maaf, gambar terlalu besar!');</script>";
                                $uploadOk = 0;
                            }

                            // Hanya izinkan format gambar tertentu
                            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                echo "<script>alert('Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan!');</script>";
                                $uploadOk = 0;
                            }

                            if ($uploadOk == 0) {
                                echo "<script>alert('Maaf, gambar tidak berhasil diupload!');</script>";
                            } else {
                                // Jika gambar berhasil diupload, pindahkan gambar baru ke folder tujuan
                                move_uploaded_file($gambar_tmp, $target_file);

                                // Hapus gambar lama jika ada, untuk menghindari sampah gambar tidak terpakai di server
                                $sql_select_gambar_lama = "SELECT gambar FROM film WHERE nama='$nama_awal'";
                                $result_select_gambar_lama = $conn->query($sql_select_gambar_lama);
                                if ($result_select_gambar_lama->num_rows > 0) {
                                    $row_gambar_lama = $result_select_gambar_lama->fetch_assoc();
                                    $gambar_lama = $row_gambar_lama['gambar'];
                                    if (file_exists($gambar_lama)) {
                                        unlink($gambar_lama);
                                    }
                                }
                            }
                        }

                        if (empty($nama) || empty($studio)) {
                            echo "<script>alert('Tolong lengkapi data yang ada!');</script>";
                        } else {
                            $sql = "UPDATE film SET nama='$nama', studio='$studio', genre='$genre', gambar='$target_file' 
                                    WHERE nama='$nama_awal'";
                            $result = $conn->query($sql);
                            if ($result) {
                                echo "<script>
                                alert('Berhasil di update!');
                                window.location.href='index.php';
                                </script>";
                            } else {
                                echo "<script>
                                alert('Gagal mengubah data!');
                                </script>";
                            }
                        }
                    }
                    ?>
                    <!-- END SCRIPT UPDATE-->

                    <!--start inputan-->
                    <form method="POST" action="" enctype="multipart/form-data">
                        <?php
                        $nama = $_GET['nama'];
                        $sql = "SELECT * FROM film WHERE nama = '$nama'";
                        $result = $conn->query($sql);
                        $rows = $result->num_rows;
                        if ($rows > 0) {
                            $row = $result->fetch_assoc();
                            $nama = $row['nama'];
                            $studio = $row['studio'];
                            $genre = $row['genre'];
                            $gambar = $row['gambar'];
                        ?>
                            <div class="form-group row">
                                <label class="col">Nama Film</label>
                                <div class="col">
                                    <input type="text" class="form-control" name="nama" value="<?= $nama ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col col-form-label">Studio</label>
                                <div class="col">
                                    <input type="text" class="form-control" name="studio" value="<?= $studio ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col col-form-label">Genre</label>
                                <div class="col">
                                    <select class="form-control" name="genre">
                                        <option <?= $genre == 'Action' ? 'selected' : '' ?>>Action</option>
                                        <option <?= $genre == 'Fantasy' ? 'selected' : '' ?>>Fantasy</option>
                                        <option <?= $genre == 'Horror' ? 'selected' : '' ?>>Horror</option>
                                        <option <?= $genre == 'Romance' ? 'selected' : '' ?>>Romance</option>
                                        <option <?= $genre == 'Mystery' ? 'selected' : '' ?>>Mystery</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col col-form-label">Gambar</label>
                                <div class="col">
                                    <?php
                                    if (!empty($gambar)) {
                                        echo '<img src="' . $gambar . '" alt="Gambar Film" style="max-width: 200px;">';
                                    } else {
                                        echo '<p>Tidak Ada Gambar</p>';
                                    }
                                    ?>
                                    <input type="file" class="form-control" name="gambar">
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-danger mr-3"><a href="index.php"><i class="fa fa-close"></i> Cancel</a></button>
                                <button type="submit" name="edit" class="btn btn-outline-primary"><i class="fa fa-edit"></i> Edit</button>
                            </div>
                    </form>
                <?php } ?>
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
