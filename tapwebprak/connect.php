<?php
$host = "localhost"; // Nama hostnya
$user = "root"; // Username
$pass = ""; // Password (Isi jika menggunakan password)
$conn = mysqli_connect($host, $user, $pass, "member"); // Koneksi ke MySQL
if ($conn) {
    echo "<script>
				alert('Berhasil Menginputkan Data');
				document.location.href = '';
              </script>";
              header("location: index.php");
}
?>