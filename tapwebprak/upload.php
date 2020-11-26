<?php
require 'functions.php';

if (! isset($_POST["upload"])) {
    header("Location:member.php");
}
if( isset($_POST["upload"]) ) {
    if( tambah($_POST) > 0 ) {
      echo "<script>
          alert('artikel berhasil ditambahkan!');
          document.location.href = 'member.php';
          </script>";
    } else {
      echo mysqli_error($conn);
    }

}
?>
