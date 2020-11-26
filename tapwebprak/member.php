<?php
    session_start();

    if( !isset($_SESSION["username"]) ) {
        header("Location: index.php");
        exit;
    }

    
    require 'functions.php';
    $artikel = query("SELECT * FROM artikel");
    // var_dump($artikel);
    // die();
    if( isset($_POST["upload"]) ) {
	
      // cek apakah data berhasil di tambahkan atau tidak
      if( tambah($_POST) > 0 ) {
        echo "
          <script>
            alert('data berhasil ditambahkan!');
            document.location.href = 'index.php';
          </script>
        ";
      } else {
        echo "
          <script>
            alert('data gagal ditambahkan!');
            document.location.href = 'index.php';
          </script>
        ";
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
    
    <!-- my css -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    
    <!-- fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">

    <title>kel10</title>
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
                    <button type="submit" class="btn btn-primary btn-block" name="upload" id="upload">Upload</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
      </div>
        
          <!-- navigasi -->
          <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
              <a class="navbar-brand" href="#">KUYJogja</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                  <a class="nav-item nav-link" href="#">Home</a>
                  <a class="nav-item active" href="eventadmin.php">Event</a>
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

          <!-- jumbotron -->
          <header>
              <div class="container">
                <div class="col">
                  <div class="row justify-content-center">
                  <h1 class="display-5"><span>AMAZING</span> Place <br> With Traditional <span>CULTURE</h1>
                  <a class="btn btn-secondary tombol" href="#">Gallery</a>
              </div>
              </div>
              </div>
          </header>

        <!-- container -->
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-10 info-panel">
              <div class="row">
                <div class="col-lg">
                  <a href="#">
                    <img src="img/Path 2.png" alt="path" class="float-left">
                    <h4>GAMING</h4>
                    <p>Friendship on gaming make  new experiences</p>
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
        <div class="penutup"></div>
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
          </div>
          
      </div>
      <footer>
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
                            <span class="fas fa-phone-alt"></span>
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
                                <input type="email" required>
                            </div>
                             <div class="msg">
                              <div class="text">Message *</div>
                              <textarea id=".msgForm" rows="2" cols="25" required></textarea><br />
                                <textarea id=".msgForm" rows="2" cols="25" required></textarea>
                                <div class="btn">
                                  <button type="submit">Send</button>
                                </div>
            </footer> -->
          
          
                          
                
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
      var x =document.getElementById("signup");
      var y =document.getElementById("register");
      
      function register(){
        x.style.left = "-470px";
        y.style.left = "0";
        y.style.top = "-220px";
        TransitionEvent
      }
    
      function login(){
        x.style.left = "0";
        y.style.left = "480px";
        TransitionEvent
      }
    
    </script>
      <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/jscript.js"></script>
  </body>
</html>