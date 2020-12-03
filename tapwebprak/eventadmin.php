<?php 
session_start();

if (isset($_SESSION['login'])) {
  header("Location: member.php");
  exit;
}
                                
    require 'functions.php';
    $artikel = query("SELECT * FROM artikel")[0];
//jika tombol login ditekan, maka akan mengirimkan variabel yang berisi username dan password
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $userpass = $_POST['password']; //password yang di inputkan oleh user lewat form login

        //query ke database
        $sql = mysqli_query($conn, "SELECT username, password, nama_member FROM register WHERE username = '$username'");

        list($username, $password, $nama) = mysqli_fetch_array($sql);
                  
        //jika data ditemukan dalam database, maka akan melakukan validasi dengan password_verify
        if (mysqli_num_rows($sql) > 0) {

            /*
            validasi login dengan password_verify
            $userpass -----> diambil dari password yang diinputkan user lewat form login
            $password -----> diambil dari password dalam database
            */
            if (password_verify($userpass, $password)) {

                //buat session baru
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['nama_member'] = $nama;

                //jika login berhasil, user akan diarahkan ke halaman admin
                header("Location: member.php");
                die();
            } else {
                //Jika password tidak cocok, maka user akan diarahkan ke form login dan menampilkan pesan error
                echo '<script language="javascript">
                        window.alert("LOGIN GAGAL! Silakan coba lagi");
                        window.location.href="./";
                      </script>';
            }
        } else {
            //jika data tidak ditemukan dalam database, maka user akan diarahkan ke halaman error maka user akan diarahkan ke form login dan menampilkan pesan error
            echo '<script language="javascript">
                    window.alert("LOGIN GAGAL! Silakan coba lagi");
                    window.location.href="./";
                  </script>';
        }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
    <!-- my css -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script> -->

    
    <!-- fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merienda&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
	
    <title>kel10</title>
    <style>
      .slide{
          margin-top: -86px;
          margin-bottom: 90px;
      }
      .carousel-item {
          height: 95vh;
          min-height: 300px;
      }
      .carousel-caption {
          bottom: 120px;
          margin-bottom: 30px;
      }
      .carousel-caption h5 {
          font-size: 45px;
          text-transform: uppercase;
          letter-spacing: 2px;
          margin-top: 25px;
          font-family: merienda;
      }
      .carousel-caption p {
          width: 60%;
          margin: auto;
          font-size: 18px;
          line-height: 1.9;
          font-family: poppins;
      }
      .carousel-caption a {
          text-transform: uppercase;
          padding: 10px 30px;
          display: inline-block;
          margin-top: 15px;
      }

    </style>
  </head>
  <body>      
  <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <span>Form Upload Gambar</span>
                <div id="btn"></div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="upload.php">
                  <div class="form-group">
                    <?php foreach( $artikel as $art ) : ?>
                    <input type="hidden" name="id" value="<?= $art["id_member"]; ?>">
                    <?php endforeach; ?>
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
                    <button type="submit" class="btn btn-primary btn-block" name="upload">Upload</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
      </div>        
          <!-- navigasi -->
          <nav class="navbar navbar-expand-lg navbar-light" id="navArea">
            <div class="container">
              <a class="navbar-brand" href="#">KUYJogja</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                  <a class="nav-item active" href="member.php">Home</a>
                  <a class="nav-item nav-link" href="eventadmin.php">Event</a>
                  <a class="nav-item active" href="#info">About</a>
                  <?php 
                  $artikel = query("SELECT * FROM register");
                  ?>
                  <?php foreach( $artikel as $art ) : ?>
                  <a class="btn btn-secondary tombol" href="?id_member=<?= $art["id_member"]; ?>" data-toggle="modal" data-target="#upload">UPLOAD</a>
                  <?php endforeach; ?>
                  <a class="btn btn-secondary tombol" href="logout.php">LOGOUT</a>
                </div>
              </div>
            </div>
          </nav>
          <main role="main">
          <div class="carousel slide" data-ride="carousel" id="carouselExampleIndicators">
            <ol class="carousel-indicators">
              <li class="active" data-slide-to="0" data-target="#carouselExampleIndicators"></li>
              <li data-slide-to="1" data-target="#carouselExampleIndicators"></li>
              <li data-slide-to="2" data-target="#carouselExampleIndicators"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img alt="First slide" class="d-block w-100" src="img/5fbd2afaa8f7b.jpg">
                <div class="carousel-caption d-none d-md-block">
                  <h5 class="animated bounceInRight" style="animation-delay: 1s;">Candi Borobudur</h5>
                  <p class="animated bounceInLeft" style="animation-delay: 2s;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</p>
                  <p class="animated bounceInRight" style="animation-delay: 3s;"><a href="#" class="btn btn-warning">More Info</a></p>
                </div>
              </div>
              <div class="carousel-item">
                <img alt="Second slide" class="d-block w-100" src="img/dsdgsr.jpg">
                <div class="carousel-caption d-none d-md-block">
                  <h5 class="animated slideInDown" style="animation-delay: 1s;">Candi Perambanan</h5>
                  <p class="animated fadeInUp" style="animation-delay: 2s;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</p>
                  <p class="animated zoomIn" style="animation-delay: 3s;"><a href="#" class="btn btn-warning">More Info</a></p>
                </div>
              </div>
              <div class="carousel-item">
                <img alt="Third slide" class="d-block w-100" src="img/5fbd41d89c98d.jpg">
                <div class="carousel-caption d-none d-md-block">
                  <h5 class="animated zoomIn" style="animation-delay: 1s;">Stadion Mandala Krida</h5>
                  <p class="animated fadeInLeft" style="animation-delay: 2s;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</p>
                  <p class="animated zoomIn" style="animation-delay: 3s;"><a href="#" class="btn btn-warning">More Info</a></p>
                </div>
              </div>
            </div><a class="carousel-control-prev" data-slide="prev" href="#carouselExampleIndicators" role="button"><span aria-hidden="true" class="carousel-control-prev-icon"></span> <span class="sr-only">Previous</span></a> <a class="carousel-control-next" data-slide="next" href="#carouselExampleIndicators" role="button"><span aria-hidden="true" class="carousel-control-next-icon"></span> <span class="sr-only">Next</span></a>
          </div>
  <div class="container">
              <div class="container post">
                <div class="row justify-content-center">
                  <div class="col-12">
                    <div class="row">
                      <?php $artikel = query("SELECT * FROM artikel");?>
                        <?php foreach( $artikel as $row ) : ?>
                      <div class="col-md-4 kotak">
                        <div class="card mb box-shadow">
                          <img class="card-img-top" src="img/<?= $row['gambar']; ?>" style="height: 200px;" alt="Card image cap">
                          <div class="card-body">
                          <p class="card-text"><?= $row['judul_artikel']; ?></p>
                          <p style="text-align:justify;"><?php $desc=substr($row['deskripsi'],0,150); echo $desc."..."?></p>
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="btn-group">
                              <button type="button" class="btn btn-sm btn-outline-secondary">Tampil</button>
                              </div>
                              <small class="text-muted"><?= $row['kategori']; ?></small>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php endforeach; ?>  
                    </div>
                  </div>
                </div>
              </div>
            </div>
      <footer class="footer mt-auto py-3" id="info">
        <div class="main-content">
          <div class="left box">
            <h2>About us</h2>
              <div class="content">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto reprehenderit vel facere adipisci natus sint? Praesentium quam autem assumenda quis eaque eius debitis dignissimos sequi unde. Dolor eos, exercitationem ipsum libero quis quibusdam odit, odio soluta, inventore iste vero impedit hic nostrum delectus esse optio autem quae! Aut, atque consequatur?</p>
                  <div class="social">
                    <a href="#"><span class="fab fa-facebook-f"></span></a>
                    <a href="#"><span class="fab fa-twitter"></span></a>
                    <a href="#"><span class="fab fa-instagram"></span></a>
                    <a href="#"><span class="fab fa-youtube"></span></a>
                  </div>
                  <div class="bottom">
                    <center>
                      <span class="credit">Created By <a href="#">KUYJogja</a> | </span>
                      <span class="far fa-copyright"></span> 2020 All rights reserved.
                    </center>
                  </div>
                </div>
              </div>
                <div class="center box">
                  <h2>Address</h2>
                    <div class="content">
                      <div class="place">
                        <span class="fas fa-map-marker-alt"></span>
                        <span class="text">Sleman, Yogyakarta</span>
                      </div>
                      <div class="phone">
                        <span class="fas fa-phone"></span>
                        <span class="text">+62-765432100</span>
                      </div>
                      <div class="email">
                        <span class="fas fa-envelope"></span>
                        <span class="text">kuyjogja@example.com</span>
                      </div>
                    </div>
                 </div>
                <div class="right box">
                  <h2>Contact us</h2>
                  <div class="content">
                    <form action="#">
                      <div class="email">
                        <div class="text">Email *</div>
                          <input type="email" class="form-control" required>
                      </div>
                      <div class="msg">
                        <div class="text">Message *</div>
                        <textarea id=".msgForm" rows="2" cols="25" class="form-control" required></textarea>
                        <br>
                        <button type="submit" class="btn btn-warning col-12">Send</button>
                      </div>
                    </form>
                  </div>
                </div>
        </footer>
          </main>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>
      window.addEventListener("scroll", function() {
      let navArea = document.getElementById("navArea");

      if (window.pageYOffset > 0) {
      navArea.classList.add("is-sticky");
      } else {
      navArea.classList.remove("is-sticky");
      }
      });

    </script> 
</body>
</html>
