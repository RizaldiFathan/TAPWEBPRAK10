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
  <!-- <link rel="stylesheet" href="coba.css"> -->
  <link rel="stylesheet" href="css/bootstrap.min.css">


  <!-- fonts -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">

  <title>kel10</title>
</head>

<body>
  <!-- navigasi -->
  <nav class="navbar navbar-expand-lg navbar-light" id="navArea">
    <div class="container">
      <a class="navbar-brand" href="#">KUYJogja</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto">
          <a class="nav-item nav-link" href="index.php">Home</a>
          <a class="nav-item active" href="event.php">Event</a>
          <a class="nav-item active" href="#info">About</a>
          <a class="btn btn-secondary tombol" href="#" data-toggle="modal" data-target="#login">JOIN US</a>
        </div>
      </div>
    </div>
  </nav>
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
              <?php if (isset($error)) : ?>
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
                  <label for="username1">Username</label>
                  <input type="text" class="form-control" id="username1" aria-describedby="username" placeholder="Masukkan username" name="username" required>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label class="" for="password1">Password</label>
                  <input type="password" class="form-control" id="password1" placeholder="Masukkan password" name="password" required>
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

  <!-- jumbotron -->
  <div class="jumbotron">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col">
          <div class="row">
            <div class="col">
              <h1 class="display-5"><span>AMAZING</span> Place <br> With Traditional <span>CULTURE</h1>
              <a class="btn btn-secondary tombol" href="#">Gallery</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- container -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-10 info-panel">
        <div class="row">
          <div class="col-lg">
            <a href="#">
              <img src="img/Path 2.png" alt="path" class="float-left">
              <h4>GAMING</h4>
              <p>Friendship on gaming make new experiences</p>
            </a>
          </div>
          <div class="col-lg">
            <a href="">
              <img src="img/gunung.png" alt="bola" class="float-left">
              <h4>ADVENTURES</h4>
              <p>The Nature make you refresh and brave</p>
            </a>
          </div>
          <div class="col-lg">
            <a href="">
              <img src="img/bola.png" alt="path" class="float-left">
              <h4>SPORTS</h4>
              <p>Get the real Friendship in sports and make you sportsmanship</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="penutup"> -->
  <div class="container">
    <div class="container post">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="row">
            <?php $artikel = query("SELECT * FROM artikel"); ?>
            <?php foreach ($artikel as $row) : ?>
              <div class="col-lg-4 kotak">
                <div class="card mb box-shadow">
                  <img class="card-img-top" src="img/<?= $row['gambar']; ?>" style="height: 200px;" alt="Card image cap">
                  <div class="card-body">
                    <p class="card-text"><?= $row['judul_artikel']; ?></p>
                    <p style="text-align:justify;"><?php $desc = substr($row['deskripsi'], 0, 90);
                                                    echo $desc . "..." ?></p>
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
  <!-- author -->
  <!-- <div class="row justify-content-center">
        <div class="col-lg-6 justify-content-center d-flex">
          <figure class="figure">
            <a href="#">
              <img src="img/zalfa3.jpg" class="figure-img img-fluid rounded-circle" alt="zlf">
              <figcaption class="figure-caption">
                <h5>IZAL</h5>
                <p>author</p>
              </figcaption>
            </a>
          </figure>
        </div>
      </div>-->


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
  <script>
    var x = document.getElementById("signup");
    var y = document.getElementById("register");

    function register() {
      x.style.left = "-470px";
      y.style.left = "0";
      y.style.top = "-220px";
      TransitionEvent
    }

    function login() {
      x.style.left = "0";
      y.style.left = "480px";
      TransitionEvent
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
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
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>