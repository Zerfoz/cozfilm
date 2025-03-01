<?php
include 'koneksi.php';

$id = $_GET['id'];  

$sql = "DELETE FROM kriteria WHERE id = '$id'";  

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Data berhasil dihapus!');
            window.location.href = 'kriteria.php';
          </script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
