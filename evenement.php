<?php 
  session_start();
  include 'includes/configuration.php';
  include 'includes/connexion.php';

  $title = "Accueil";
  $pageName = basename($_SERVER['PHP_SELF']);
  include 'includes/head.php';

  if(isset($_GET['id'])){
    $id = $_GET["id"];
    $query = 'SELECT * FROM evenements where id = '.$id; 
    $reponse = $pdo->prepare($query);
    $reponse->execute();
    $evenement = $reponse->fetch(PDO::FETCH_ASSOC);
    if(!$evenement){
      header ('location: index.php');
    }
  }
?>

  <body class="hold-transition skin-red layout-top-nav">
    <div class="wrapper">
      <!-- Menu -->
      <?php
        include 'includes/menu.php';
      ?>
      
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">

          <!-- Main content -->
          <section class="content">
            <?php include 'includes/infos.php'; ?>
                    
            <div class="row">              
              <!-- Wrapper Principal -->
              <div class="box box-danger">
                <!-- Info Bulle -->
                <div class="box-header with-border">
                  <h3 class="box-title">Evenement : <?php echo $evenement["titre"] ?></h3>
                </div>
                <!-- Barre Progression -->
                <div class="box-body">        
                  <div class="ads" style="padding:0px;">
                    <ul>
                      <li>
                        Date evenement : <?php echo $evenement["date_evenement"] ?>
                      </li>
                      <br>
                      <li>
                        Date butoir : <?php echo $evenement["date_butoir"] ?>
                      </li>
                      <br>
                    </ul>
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
