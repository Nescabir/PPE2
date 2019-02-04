<?php
  session_start();

  $name = "Accueil";
  $nameCon = "Connexion";

  $error1 = "Mot-de-passe et/ou identifiant incorrect!";
  $error2 = "Impossible de joindre la base de données! </br> Merci de contacter l'administrateur.";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta charset="utf-8">
    <title>Jingle Contest 2018 - <?php if (empty($_SESSION)){echo $nameCon;}else{echo $name;}?></title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <script defer src="assets/js/fontawesome-all.min.js"></script>
  </head>
  <body>
    <?php if (empty($_SESSION)): ?>
      <section class="connection"> 
        <div class="title">
          <p>Jingle Contest 2018</p>
        </div>
        <div class="logo">
          <img src="assets/img/default_logo.png">
        </div>
        <div class="errorHandler">
            <p>
              <?php if (isset($_GET['errorCon'])){
                  if ($_GET['errorCon'] == 1) {
                    echo $error1;
                    echo "</br>&nbsp";
                  }
                  elseif ($_GET['errorCon'] == 2) {
                    echo $error2;
                  }
              }
              else {
                echo "</br>&nbsp";
              }
              ?></p>
          </div>
        <form class="connectionForm" action="assets/php/login.php" method="post">
          <input class="inputs input1" type="text" name="name" value="" placeholder="Identifiant" required><br>
          <input class="inputs input2" type="password" name="password" value="" placeholder="Mot-de-passe" required><br>
          <input class="submitBtn" type="submit" name="submitBtn" value="Connexion" required>
        </form>
        <div class="Fgtpass">
          <a href="mailto:email@st-michel.fr">Mot-de-passe oublié?</a> <!--A MODIF-->
        </div>
      </section>

    <?php endif; ?>
    <?php if (!empty($_SESSION)): ?>
      <section class="main">
        <div class="searchbar">
          <div class="logout">
            <a href="assets/php/logout.php"><i class="fas fa-sign-out-alt fa-lg"></i> Se déconnecter</a>
          </div>
          <div class="search">
            <form class="searchForm" action="index.php" method="get">
              <input type="search" name="search" value="" placeholder="Que cherchez-vous?">
              <button type="submit" name="submitBtn" value="1"><i class="fas fa-search"></i></button>
            </form>
          </div>
        </div>
        <div class="content">
          <div class="jingles">
            <?php
              if ($_SERVER["REQUEST_METHOD"] == "GET") {
                include_once ('assets/php/db.php');

                if (empty($_GET)) {
                  $sql = "SELECT id, nom, path FROM jingles";
                  if ($res = mysqli_query($conn, $sql)) {
                    $row = mysqli_fetch_assoc($res);
                    if (!empty($row)) {
                      $numRows = mysqli_num_rows($res);

                      foreach ($res as $row) {
                        ?>
                           <div class='jingle'>
                             <div class="id">
                               <H1><?php echo $row['id'] ?></H1>
                             </div>
                             <div class="nom">
                               <?php echo $row['nom'] ?>
                             </div>
                             <audio controls class="audiosource">
                               <source src='<?php echo $row['path'] ?>' type='audio/ogg; codecs=opus'/>
                               <source src='<?php echo $row['path'] ?>' type='audio/ogg; codecs=vorbis'/>
                               <source src='<?php echo $row['path'] ?>' type='audio/mpeg'/>
                               <source src='<?php echo $row['path'] ?>' type='audio/wav'>
                               Votre navigateur ne prend pas en charge l'élément <code>audio</code>.
                             </audio>
                         </div>
                         <?php
                      }
                    }
                    else {
                      echo "Aucun jingle n'a encore été ajoutés, <span style='text-decoration: underline; cursor: pointer;' onclick='openDiv()'>cliquez pour en ajouter un!</span>";
                    }
                    mysqli_free_result($res);
                    mysqli_close($conn);
                  }
                } else {
                  $search = mysqli_real_escape_string($conn, $_GET['search']);
                  $submitBtn = $_GET['submitBtn'];

                  if ($submitBtn == 1) {
                    if (empty($search)) {
                      $sql = "SELECT id, nom, path FROM jingles";

                      if ($res = mysqli_query($conn, $sql)) {
                        $row = mysqli_fetch_assoc($res);
                        if (!empty($row)) {
                          $numRows = mysqli_num_rows($res);

                          foreach ($res as $row) {
                            ?>
                               <div class='jingle'>
                                 <div class="id">
                                   <H1><?php echo $row['id'] ?></H1>
                                 </div>
                                 <div class="nom">
                                   <?php echo $row['nom'] ?>
                                 </div>
                                 <audio controls class="audiosource">
                                   <source src='<?php echo $row['path'] ?>' type='audio/ogg; codecs=opus'/>
                                   <source src='<?php echo $row['path'] ?>' type='audio/ogg; codecs=vorbis'/>
                                   <source src='<?php echo $row['path'] ?>' type='audio/mpeg'/>
                                   <source src='<?php echo $row['path'] ?>' type='audio/wav'>
                                   Votre navigateur ne prend pas en charge l'élément <code>audio</code>.
                                 </audio>
                             </div>
                             <?php
                          }
                        }
                        else {
                          echo "Aucun jingle n'a encore été ajoutés, <span style='text-decoration: underline; cursor: pointer;' onclick='openDiv()'>cliquez pour en ajouter un!</span>";
                        }
                        mysqli_free_result($res);
                        mysqli_close($conn);
                      }
                    }
                    else {
                      $sql = "SELECT id, nom, path FROM jingles WHERE nom Like '%$search%'";
                      if ($res = mysqli_query($conn, $sql)) {
                        $row = mysqli_fetch_assoc($res);
                        if (!empty($row)) {
                          $numRows = mysqli_num_rows($res);

                          foreach ($res as $row) {
                            ?>
                               <div class='jingle'>
                                 <div class="id">
                                   <H1><?php echo $row['id'] ?></H1>
                                 </div>
                                 <div class="nom">
                                   <?php echo $row['nom'] ?>
                                 </div>
                                 <audio controls class="audiosource">
                                   <source src='<?php echo $row['path'] ?>' type='audio/ogg; codecs=opus'/>
                                   <source src='<?php echo $row['path'] ?>' type='audio/ogg; codecs=vorbis'/>
                                   <source src='<?php echo $row['path'] ?>' type='audio/mpeg'/>
                                   <source src='<?php echo $row['path'] ?>' type='audio/wav'>
                                   Votre navigateur ne prend pas en charge l'élément <code>audio</code>.
                                 </audio>
                             </div>
                             <?php
                          }
                        }
                        else {
                          echo "Le jingle que vous recherchez n'existe pas! <span style='text-decoration: underline; cursor: pointer;' onclick='openDiv()'>Cliquez-ici pour le créer.</span>";
                        }
                        mysqli_free_result($res);
                        mysqli_close($conn);
                      }
                    }
                  }
                }
              }
             ?>
          </div>
          <div class="footer">
              <p>&copy; 2018 - <a href="https://github.com/Nescabir">Nescabir</a> </p>
          </div>
        </div>
        <div class="add" onclick="openDiv()">
          <i class="fas fa-plus-circle fa-5x"></i>
        </div>
      </section>
      <section id="add" style="display:none">
        <div class="close" onclick="closeDiv()">
          <i class="fas fa-times fa-2x"></i>
        </div>
        <div class="mainWindow">
          <div class="wrapper">
            <h1>Ajouter un jingle</h1>
            <form class="addJingle" action="#" method="post">
              <input type="text" name="name" value="" placeholder="Nom de votre Jingle" required> <br>
              <input id="upload" type="file" name="file" accept="audio/*" required>
              <span class="upload" onclick="openFile()"><i class="fas fa-upload"></i> Choisir un fichier</span>
              <span id="uploadName" onchange="getName()"></span>
              <input type="submit" name="submitBtn">
            </form>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <script type="text/javascript">
      function closeDiv() {
        document.getElementById('add').setAttribute("style","display:none");
      }
      function openDiv() {
        document.getElementById('add').setAttribute("style","display:block");
      }
      function openFile() {
        document.getElementById('upload').click();
      }

      var vid = document.getElementByClassName("audiosource").
      vid.volume = 0.3;
    </script>
  </body>
</html>
