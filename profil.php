<?php 
  session_start();
  include 'includes/configuration.php';
  include 'includes/connexion.php';

  $title = "Accueil";
  $pageName = basename($_SERVER['PHP_SELF']);
  include 'includes/head.php';

  if(isset($_GET['id'])){
    $id = $_GET["id"];
    $query = 'SELECT id FROM utilisateur where id = '.$id; 
    $reponse = $pdo->prepare($query);
    $reponse->execute();
    $userid = $reponse->fetchAll();
    if(!$userid){
      header ('location: index.php');
    }
  }

  $query = "SELECT * from evenements"; 
  $reponse = $pdo->prepare($query);
  $reponse->execute();
  $evenements = $reponse->fetchAll(PDO::FETCH_ASSOC);
?>

  <body class="hold-transition skin-red layout-top-nav">
    <div class="wrapper">
      <!-- Menu -->
      <?php
        include 'includes/menu.php';
        include 'pages/ajouter_evenement.php';
        include 'pages/rejoindre_evenement.php';
      ?>
      
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">

          <!-- Main content -->
          <section class="content">
            <?php include 'includes/infos.php'; ?>
                    
            <div class="row">
              <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
              <script>tinymce.init({ selector:'textarea' });</script>

              <div class="col-md-3">
                <div class="box box-danger">
                  <div class="box-body box-profile">
                    <h3 class="profile-username text-center"><?php echo $_SESSION["username"] ?></h3>
                    <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#ajout_evenement"><b>Ajouter un evenement</b></button>
                    <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#rejoindre_evenement"><b>Rejoindre un evenement</b></button>
                  </div><!-- /.box-body -->
                </div>
              </div>
              
              <?php include 'pages/ajouter_evenement.php' ?>
              <?php include 'pages/rejoindre_evenement.php' ?>

              <div class="col-md-9">
                <!-- Wrapper Principal -->
                <div class="box box-danger">
                  <!-- Info Bulle -->
                  <div class="box-header with-border">
                    <h3 class="box-title">Mes evenements</h3>
                  </div>
                  <!-- Barre Progression -->
                  <div class="box-body"> 
                      <?php
                      if($evenements){
                        while ($row = array_shift($evenements)) { // Tant que ya des données
                          echo '<div class="ads">';
                            echo '<a href="evenement.php?id='.$row["id"].'" class="titre"> '.$row["titre"].' </a>';
                            echo '<ul>';
                              echo '<li><i class="fa fa-fw fa-clock-o"></i> '.$row["date_evenement"].'</li>';
                            echo '</ul>';
                          echo '</div>';
                        }
                      ?>
                  <?php } ?>
                  </div>
                </div>
                <div class="box box-danger">
                  <!-- Info Bulle -->
                  <div class="box-header with-border">
                    <h3 class="box-title">Mes invitations</h3>
                  </div>
                  <!-- Barre Progression -->
                  <div class="box-body"> 
                    <?php
                    if($evenements){
                      while ($row = array_shift($evenements)) { // Tant que ya des données
                        echo '<div class="ads">';
                          echo '<a href="?id='.$row["id"].'" class="titre"> '.$row["titre"].' </a>';
                          echo '<ul>';
                            echo '<li><i class="fa fa-fw fa-clock-o"></i> '.$row["date_evenement"].'</li>';
                          echo '</ul>';
                        echo '</div>';
                      }
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
    <script type="text/javaScript"> 
    function ajouterLigne() //fonction ajouter ligne
    {
      var table = document.getElementById("tableau");
      var row = table.insertRow(1);
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      cell1.innerHTML = "<input type='text'>";
      cell2.innerHTML = "<input type='number' min='0' value='0'>";
    }
    </script>   

    <?php include 'includes/footer.php'; ?>
