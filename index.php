<?php 
  session_start();
  
  // Permet d'éviter le renvoi auto du formulaire F5
  include 'includes/renvoiFormulaire.php';

  include 'includes/configuration.php';
  include 'includes/connexion.php';

  $title = "Accueil";
  $pageName = basename($_SERVER['PHP_SELF']);
  include 'includes/head.php';
?>
  
  <body class="hold-transition skin-red layout-top-nav">
    <div class="wrapper">

      <!-- Menu -->
      <?php 
        include_once 'includes/menu.php';
      ?>
      
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">

          <!-- Main content -->
          <section class="content">		
            <?php 
              include 'pages/rejoindre_evenement.php';
              include 'includes/infos.php'; 
            ?>

            <div class="box box-danger">
              <div class="box-body box-profile">
                <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#rejoindre_evenement"><b>Rejoindre un evenement</b></button>
              </div><!-- /.box-body -->
            </div>
          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->

      <?php include 'includes/footer.php'; ?>