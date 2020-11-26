<?php 
require 'functions.php';

if( isset($_POST["daftar"]) ) {

	if( registrasi($_POST) > 0 ) {
		echo "<script>
        alert('user baru berhasil ditambahkan!');
        document.location.href = 'login.php';
			  </script>";
	} else {
		echo mysqli_error($conn);
	}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
      <form method="post" enctype="multipart/form-data" action="upload.php">
                  <div class="form-group">
                    <?php 
                      // ambil data di URL
                        $id = $_GET["id_member"];

                        // query data mahasiswa berdasarkan id
                        $art = query("SELECT * FROM register WHERE id_member = $id")[0];
                    ?>
                    <input type="text" name="id" value="<?= $art["id_member"]; ?>">
                    <label for="judul_artikel">Judul Artikel</label>
                    <input type="text" name="judul_artikel" class="form-control" required>
                    <label for="artike">Upload Gambar</label>
                    <input type="file" name="artikel" id="artikel">
                    <br>
                    <label for="desc">Isi Artikel</label>
                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="2" placeholder="masukan isi artikel!" class="form-control" required></textarea>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                      <option value="Gaming">-Pilih Kategori-</option>
                      <option value="gaming">Gaming</option>
                      <option value="adventur">Adventures</option>
                      <option value="sport">Sports</option>
                    </select>
                    <br>
                    <a href="upload.php" class="btn btn-primary btn-block" name="upload" id="upload">Upload</a>
                  </div>
                </form>
      </div>
    </div>
  </div>
</body>
</html>