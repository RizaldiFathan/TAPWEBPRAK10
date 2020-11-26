<?php
require 'functions.php';

if (! isset($_POST["daftar"])) {
    header("Location:index.php");
}
if( isset($_POST["daftar"]) ) {

    if( registrasi($_POST) > 0 ) {
      echo "<script>
          alert('user baru berhasil ditambahkan!');
          document.location.href = 'index.php';
          </script>";
    } else {
      echo mysqli_error($conn);
    }

}
?>
