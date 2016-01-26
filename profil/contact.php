<?php 
  session_start();
  include '../includes/configuration.php';
  include '../includes/connexion.php';

  $title = "Profil";
  $pageName = basename($_SERVER['PHP_SELF']);
  include '../includes/head.php';

  if(!isset($_SESSION["username"]))
    header("location: login.php");

    $pseudo = $_SESSION["username"];
    $query = 'SELECT * FROM utilisateur where pseudo = "'.$pseudo.'"'; 
    $reponse = $pdo->prepare($query);
    $reponse->execute();
    $user_info = $reponse->fetch(PDO::FETCH_ASSOC);  

?>

  <body class="hold-transition skin-red layout-top-nav">
    <div class="wrapper">
      <!-- Menu -->
      <?php
        include '../includes/menu.php';
        include '../pages/ajouter_evenement.php';
        include '../pages/rejoindre_evenement.php';
      ?>
      
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">

          <!-- Main content -->
          <section class="content">
            <?php include '../includes/infos.php'; ?>
                    
            <div class="row">
              <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
              <script>tinymce.init({ selector:'textarea' });</script>

              <div class="col-md-3">
                <?php include('../includes/menu_lateral.php'); ?>
              </div>

              <div class="col-md-3">                 
                <div class="box box-danger">
                  <!-- Info Bulle -->
                  <div class="box-header with-border">
                    <h3 class="box-title" style="margin-left: 10px">Importer son carnet de contact (.csv)</h3>
                  </div>
                  <!-- Barre Progression -->
                  <div class="box-body"> 

                  </div>
                </div>
              </div>

              <div class="col-md-6">                 
                <div class="box box-danger">
                  <!-- Info Bulle -->
                  <div class="box-header with-border">
                    <h3 class="box-title" style="margin-left: 10px">Ajouter manuellement</h3>
                  </div>
                  <!-- Barre Progression -->
                  <div class="box-body"> 

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

    <?php include '../includes/footer.php'; ?>
