<?php 
  session_start();
  include '../includes/configuration.php';
  include '../includes/connexion.php';

  $title = "Profil";
  $pageName = basename($_SERVER['PHP_SELF']);
  include '../includes/head.php';

  if(isset($_POST['modification'])){
    $_SESSION['succes'] = "";
    $_SESSION['erreur'] = "";
    //On verifie ce qui a été envoyé
    $pseudo = $_SESSION["username"];
    $query = 'SELECT * FROM utilisateur where pseudo = "'.$pseudo.'"'; 
    $reponse = $pdo->prepare($query);
    $reponse->execute();
    $user_info = $reponse->fetch(PDO::FETCH_ASSOC);  

    if(isset($_POST['email']) AND $_POST['email']!='' AND  $_POST['email'] != $user_info['email']){
      if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
      {
        $query = 'UPDATE utilisateur SET email = :email where id = '.$user_info['id']; 
        $reponse = $pdo->prepare($query);
        $reponse->bindValue(':email', $_POST['email']); 
        $reponse->execute();
        $_SESSION['succes'] .= "Email ";
      } else {
        $_SESSION['erreur'] .= "L'adresse mail n'est pas conforme";        
      }
    }
    if(isset($_POST['mot_passe_1'], $_POST['mot_passe_2']) AND $_POST['mot_passe_1']!='' AND $_POST['mot_passe_2']!=''){
      if($_POST['mot_passe_1'] == $_POST['mot_passe_2']){
        if(strlen($_POST['mot_passe_1'])>=6){
          $query = 'UPDATE utilisateur SET mot_passe = :mot_passe where id = '.$user_info['id']; 
          $reponse = $pdo->prepare($query);
          $reponse->bindValue(':mot_passe', password_hash($_POST['mot_passe_1'], PASSWORD_BCRYPT)); 
          $reponse->execute();
          $_SESSION['succes'] .= "Mot de passe ";
        } else {
          $_SESSION['erreur'] .= "Le mot de passe doit faire plus de 6 caractères";
        } 
      } else {
        $_SESSION['erreur'] .= "Les mots de passe ne sont pas identiques";          
      }
    }
    if(isset($_POST['nom']) AND $_POST['nom']!='' AND $_POST['nom'] != $user_info['nom']){     
      $query = 'UPDATE utilisateur SET nom = :nom where id = '.$user_info['id']; 
      $reponse = $pdo->prepare($query);
      $reponse->bindValue(':nom', $_POST['nom']); 
      $reponse->execute();
      $_SESSION['succes'] .= "Nom ";
    }
    if(isset($_POST['prenom']) AND $_POST['prenom']!='' AND $_POST['prenom'] != $user_info['prenom']){     
      $query = 'UPDATE utilisateur SET prenom = :prenom where id = '.$user_info['id']; 
      $reponse = $pdo->prepare($query);
      $reponse->bindValue(':prenom', $_POST['prenom']); 
      $reponse->execute();
      $_SESSION['succes'] .= "Prenom ";
    }
    if(isset($_POST['ville']) AND $_POST['ville']!='' AND $_POST['ville'] != $user_info['ville']){     
      $query = 'UPDATE utilisateur SET ville = :ville where id = '.$user_info['id']; 
      $reponse = $pdo->prepare($query);
      $reponse->bindValue(':ville', $_POST['ville']); 
      $reponse->execute();
      $_SESSION['succes'] .= "Ville ";
    }
    if(isset($_POST['date_naissance']) AND $_POST['date_naissance']!='' AND $_POST['date_naissance'] != $user_info['date_naissance']){     
      $query = 'UPDATE utilisateur SET date_naissance = :date_naissance where id = '.$user_info['id']; 
      $reponse = $pdo->prepare($query);
      $reponse->bindValue(':date_naissance', $_POST['date_naissance']); 
      $reponse->execute();
      $_SESSION['succes'] .= "Date de naissance ";
    }
    if(isset($_POST['newsletter']) AND $user_info['newsletter'] == 0){     
      $query = 'UPDATE utilisateur SET newsletter = 1 where id = '.$user_info['id']; 
      $reponse = $pdo->prepare($query);
      $reponse->execute();
      $_SESSION['succes'] .= "Newsletter ";
    } else if (!isset($_POST['newsletter']) AND $user_info['newsletter'] == 1){    
      $query = 'UPDATE utilisateur SET newsletter = 0 where id = '.$user_info['id']; 
      $reponse = $pdo->prepare($query);
      $reponse->execute();
      $_SESSION['succes'] .= "Newsletter ";
    }
    // Verification Photo 
    $var = true;
    $photo = false;
    if(is_uploaded_file($_FILES['photo']['tmp_name'])){ 
      $type_file = $_FILES['photo']['type'];      
      if(strstr($type_file, 'image/jpeg')){
        if(preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $_FILES['photo']['tmp_name'])){
          $photo = true;    
          $image_info = getimagesize($_FILES["photo"]["tmp_name"]);
          $image_width = $image_info[0];
          $image_height = $image_info[1];

          if($image_width == $image_height){ // Taille Images
            if($_FILES['photo']['error'] == 0){ // Si il n'y a pas d'erreurs lors d'upload
              if($_FILES['photo']['size'] <= 150000){ // Si la taille est < 1Mo
                $infosfichier = pathinfo($_FILES['photo']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if(!in_array($extension_upload, $extensions_autorisees)) { // Si l'extension est autorisé
                  $_SESSION['erreur'] .= "Extension non autorisée";  
                  $var = false;                       
                }
                if(!move_uploaded_file($_FILES['photo']['tmp_name'], '../photos/'.basename($pseudo).'.'.$extension_upload)){ // Si le deplacement du fichier temp/ > images/ est ok
                  $_SESSION['erreur'] .= "Erreur lors de l'upload";  
                  $var = false;
                } else {
                  $query = 'UPDATE utilisateur SET photo = 1 where id = '.$user_info['id']; 
                  $reponse = $pdo->prepare($query);
                  $reponse->execute();
                  $_SESSION['succes'] .= "Photo ";              
                }
              } else {
                $_SESSION['erreur'] .= "Fichier supérieur a 1 Mo.";  
                $var = false;                
              }
            } else {
              $_SESSION['erreur'] .= "Erreur de l'envoi de la photo.";  
              $var = false;
            }    
          } else {
            $_SESSION['erreur'] .= "La largeur de l'image dois etre la même que la longueur et maximum 100Ko.";  
            $var = false;
          }
        } else {
          $_SESSION['erreur'] = "Nom de fichier invalide";  
          $var = false;
        }
      } else {
        $_SESSION['erreur'] = "Le fichier dois etre une image JPG";  
        $var = false;
      }
    }

    if($_SESSION['succes'] != '')
      $_SESSION['succes'] .= " modifié(e)(s)"; 
  }


  if(isset($_GET['edit']))
  {
    if(!isset($_SESSION["username"]))
      header("location: login.php");

    $pseudo = $_SESSION["username"];
    $query = 'SELECT * FROM utilisateur where pseudo = "'.$pseudo.'"'; 
    $reponse = $pdo->prepare($query);
    $reponse->execute();
    $user_info = $reponse->fetch(PDO::FETCH_ASSOC);  

  } 
  else if(isset($_GET['id'])) // Si il a misun ?id=X
  { 
    // Verification si l'ID exite //
    $id = $_GET["id"];
    $query = 'SELECT * FROM utilisateur where id = '.$id; 
    $reponse = $pdo->prepare($query);
    $reponse->execute();
    $user_info = $reponse->fetch(PDO::FETCH_ASSOC);

    if(!$user_info)
      header ('location: index.php');

    // Verification si c'est son propre profil //
    if(isset($_SESSION["username"]) AND $user_info['pseudo'] == $_SESSION["username"]) 
    {
      $info_max = true;

      // Requete des evenements      
      $query = "SELECT * from evenements"; 
      $reponse = $pdo->prepare($query);
      $reponse->execute();
      $evenements = $reponse->fetchAll(PDO::FETCH_ASSOC);
    } 
    else 
    {      
      $info_max = false;
    }
  } 
  else if (isset($_SESSION["username"]))
  {
    $query = 'SELECT id FROM utilisateur where pseudo = "'.$_SESSION["username"].'"'; 
    $reponse = $pdo->prepare($query);
    $reponse->execute();
    $check_id = $reponse->fetch(PDO::FETCH_ASSOC);
    header('location: index.php?id='.$check_id['id']);  
  } 
  else 
  {
    header('location: connexion.php');
  }

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
                <?php 
                  include('../pages/menu_lateral.php'); 
                ?>
              </div>

              <div class="col-md-9">
                <?php 
                  if(isset($_GET['edit']))
                  {
                    include('../pages/mon_profil_info_modif.php');
                  } 
                  else if ($info_max)
                  { 
                    include('../pages/mon_profil.php');
                  } 
                  else if (isset($_GET['contact']))
                  {
                    include('../pages/mon_profil_contact.php');
                  }
                ?>
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
