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
      }
      .carousel-item {
          height: 100vh;
          min-height: 300px;
          
          /* margin-top: -90px !important; */
      }
      .carousel-caption {
          bottom: 220px;
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
          /* background: #262626; */
          padding: 10px 30px;
          display: inline-block;
          color: #fff;
          margin-top: 15px;
      }

    </style>
  </head>
  <body>      
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <div id="btn"></div>
                <button type="button" class="modal-title" onclick="login()">LOGIN</button>
                <button type="button" class="modal-title" onclick="register()">REGISTER</button>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <form action="" id="signup" method="POST">
                  <div class="form-group">
                    <?php if( isset($error) ) : ?>
                      <p style="color: red; font-style: italic;">username / password salah</p>
                    <?php endif; ?>
                    <label for="username">Username</label>
                    <input type="text" id="username" placeholder="Masukkan username" class="form-control" name="username" required>
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Masukkan password" class="form-control" name="password" required>
                    <br>
                    <button type="submit" class="btn btn-primary btn-block" name="login">Masuk</button>
                  </div>
                </form>
                
                <form id="register" action="input_act.php" method="POST">
                  <div class="form-group">
                    <div class="row">
                      <div class="col">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" aria-describedby="email" placeholder="Masukkan email" name="email" required>
                        </div>
                        <div class="col">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" aria-describedby="username" placeholder="Masukkan username" name="username" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label class="" for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Masukkan password" name="password" required>                        
                        </div>
                      <div class="col">
                        <label class="" for="password2">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password2" placeholder="Konfirmasi password" name="password2" required>                        
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <label for="nama_member">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_member" placeholder="Masukkan Nama Lengkap" name="nama_member" required>
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" placeholder="Alamat Domisili" name="alamat" required>
                        <label for="no_identitas">No Identitas</label>
                        <input type="text" class="form-control" id="no_identitas" placeholder="Masukkan Nomor Identitas (KTP/PASPOR/DLL)" name="no_identitas" required>
                      </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary btn-block" name="daftar">Daftar</button>
                  </div>
                </form>
              </div>
          </div>
      </div>
  </div>        
          <!-- navigasi -->
          <div class="sticky-top">
          <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
              <a class="navbar-brand" href="#">KUYJogja</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                  <a class="nav-item active" href="member.php">Home</a>
                  <a class="nav-item nav-link" href="eventadmin.php">Event</a>
                  <a class="nav-item active" href="#">About</a>
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
          </div>
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
                  <p class="animated bounceInRight" style="animation-delay: 3s;"><a href="#" class="btn btn-secondary">More Info</a></p>
                </div>
              </div>
              <div class="carousel-item">
                <img alt="Second slide" class="d-block w-100" src="img/dsdgsr.jpg">
                <div class="carousel-caption d-none d-md-block">
                  <h5 class="animated slideInDown" style="animation-delay: 1s;">Candi Perambanan</h5>
                  <p class="animated fadeInUp" style="animation-delay: 2s;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</p>
                  <p class="animated zoomIn" style="animation-delay: 3s;"><a href="#" class="btn btn-secondary">More Info</a></p>
                </div>
              </div>
              <div class="carousel-item">
                <img alt="Third slide" class="d-block w-100" src="img/5fbd41d89c98d.jpg">
                <div class="carousel-caption d-none d-md-block">
                  <h5 class="animated zoomIn" style="animation-delay: 1s;">Stadion Mandala Krida</h5>
                  <p class="animated fadeInLeft" style="animation-delay: 2s;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</p>
                  <p class="animated zoomIn" style="animation-delay: 3s;"><a href="#" class="btn btn-secondary">More Info</a></p>
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
          </main>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script>
      var x =document.getElementById("signup");
      var y =document.getElementById("register");
      var z =document.getElementById("btn");
      
      function register(){
        x.style.left = "-400px";
        y.style.left = "25px";
        z.style.left = "0px";
        TransitionEvent
      }
    
      function login(){
        x.style.left = "25px";
        y.style.left = "480px";
        z.style.left = "0px";
        TransitionEvent
      }
    
    </script>
        <!-- <script src="js/jquery-3.3.1.min.js"></script> -->
        <!-- <script src="js/jscript.js"></script>  -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script> -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script> 
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>