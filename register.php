<?php 
  session_start();

  // Permet d'éviter le renvoi auto du formulaire F5
  // include 'includes/renvoiFormulaire.php';

  include 'includes/configuration.php';
  include 'includes/connexion.php';
  require_once 'includes/passwordLib.php';
  if(isset($_SESSION["utilisateur"]))
    header("location: ./profil");
  
  $title = "Inscription";
  $pageName = basename($_SERVER['PHP_SELF']);
  include 'includes/head.php';

  if(isset($_POST['register'])){    
    if(isset($_POST['g-recaptcha-response']) AND $_POST['g-recaptcha-response'] == true){

      //On verifie ce qui a été envoyé
      if(isset($_POST['pseudo'], $_POST['email'], $_POST['mot_passe_1'], $_POST['mot_passe_2'], $_POST['nom'], $_POST['prenom'], $_POST['ville'], $_POST['date_naissance']) 
        AND $_POST['pseudo']!='' AND $_POST['nom']!='' AND $_POST['prenom']!='' AND $_POST['ville']!='' AND $_POST['date_naissance']!='')
      {
        //On enleve lechappement si get_magic_quotes_gpc est active
        if(get_magic_quotes_gpc())
        {
          $_POST['pseudo'] = stripslashes($_POST['pseudo']);
          $_POST['email'] = stripslashes($_POST['email']);
          $_POST['mot_passe_1'] = stripslashes($_POST['mot_passe_1']);
          $_POST['mot_passe_2'] = stripslashes($_POST['mot_passe_2']);
          $_POST['nom'] = stripslashes($_POST['nom']);
          $_POST['prenom'] = stripslashes($_POST['prenom']);
          $_POST['ville'] = stripslashes($_POST['ville']);
          $_POST['date_naissance'] = stripslashes($_POST['date_naissance']);
        }
        //On verifie si le mot de passe et celui de la verification sont identiques
        if($_POST['mot_passe_1']==$_POST['mot_passe_2'])      
        {
          //On verifie si le mot de passe a 6 caracteres ou plus
          if(strlen($_POST['mot_passe_1'])>=6)
          {
            //On verifie si lemail est valide
            if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
            {
              //On echape les variables pour pouvoir les mettre dans une requette SQL
              $pseudo = $_POST['pseudo'];
              $email = $_POST['email'];
              $mot_passe = $_POST['mot_passe_1'];
              $nom = $_POST['nom'];
              $prenom = $_POST['prenom'];
              $ville = $_POST['ville'];
              $date_naissance = $_POST['date_naissance'];

              // Appel de la fonction exec requete
              $query = "SELECT id from utilisateur WHERE pseudo='$pseudo' OR email='$email'";
              // Lecture du/des resultats
              $reponse = $pdo->prepare($query);
              $reponse->execute();
              $utilisateur = $reponse->fetchAll(PDO::FETCH_ASSOC);

              // Si la requete envoi qqch
              if(!$utilisateur){
                if(isset($_POST['newsletter'])) {
                  $newsletter = 1;
                } else {
                  $newsletter = 0;
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
                        if($image_width < 500 && $image_height < 500){
                          if($_FILES['photo']['error'] == 0){ // Si il n'y a pas d'erreurs lors d'upload
                            if($_FILES['photo']['size'] <= 1000000){ // Si la taille est < 1Mo
                              $infosfichier = pathinfo($_FILES['photo']['name']);
                              $extension_upload = $infosfichier['extension'];
                              $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                              if(!in_array($extension_upload, $extensions_autorisees)) { // Si l'extension est autorisé
                                $_SESSION['erreur'] = "Extension non autorisée";  
                                $var = false;                       
                              }
                              if(!move_uploaded_file($_FILES['photo']['tmp_name'], 'photos/'.basename($pseudo).'.'.$extension_upload)){ // Si le deplacement du fichier temp/ > images/ est ok
                                $_SESSION['erreur'] = "Erreur lors de l'upload";  
                                $var = false;
                              }
                            } else {
                              $_SESSION['erreur'] = "Fichier supérieur a 1 Mo.";  
                              $var = false;                
                            }
                          } else {
                            $_SESSION['erreur'] = "Erreur de l'envoi de la photo.";  
                            $var = false;
                          }                    
                        } else {
                          $_SESSION['erreur'] = "L'image ne peut pas dépasser 500 px de coter.";  
                          $var = false;
                        }
                      } else {
                        $_SESSION['erreur'] = "La largeur de l'image dois etre la même que la longueur et maximum 100Ko.";  
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

                // Appel de la fonction exec requete
                if($var){
                  if($photo){
                    $query = "INSERT INTO utilisateur (pseudo, mot_passe, email, nom, prenom, ville, date_naissance, newsletter, photo) VALUES (:pseudo, :mot_passe, :email, :nom, :prenom, :ville, :date_naissance, :newsletter, 1)"; 
                  } else {
                    $query = "INSERT INTO utilisateur (pseudo, mot_passe, email, nom, prenom, ville, date_naissance, newsletter, photo) VALUES (:pseudo, :mot_passe, :email, :nom, :prenom, :ville, :date_naissance, :newsletter, 0)"; 
                  }
                  try {
                    $stmt = $pdo->prepare($query);
                    $stmt->bindValue(':mot_passe', password_hash($mot_passe, PASSWORD_BCRYPT)); //Hashage du mot de passe
                    $stmt->bindValue(':pseudo', $pseudo); 
                    $stmt->bindValue(':email', $email); 
                    $stmt->bindValue(':nom', $nom); 
                    $stmt->bindValue(':prenom', $prenom); 
                    $stmt->bindValue(':ville', $ville); 
                    $stmt->bindValue(':date_naissance', $date_naissance); 
                    $stmt->bindValue(':newsletter', $newsletter);
                    $stmt->execute();
                    $_SESSION['succes'] = "Utilisateur inscrit";
                    header('location: login.php');
                  } catch (PDOException $e) {
                    echo "Erreur !<br>".$e->getMessage();
                  }   
                }           
              } else {
                $_SESSION['erreur'] = "L'utilisateur ou l'email existe déja.";         
              }
            } else {
              $_SESSION['erreur'] = "L'email que vous avez entré n'est pas valide";         
            }
          } else {
            $_SESSION['erreur'] = "Le mot de passe doit faire plus de 6 caractères";         
          }
        } else {
          $_SESSION['erreur'] = "Les mots de passe ne sont pas identiques";         
        }
      } else {
        $_SESSION['erreur'] = "Veuillez remplir tout les champs";      
      }
    } else {
      $_SESSION['erreur'] = "Captcha incorrect";      
    }
  }


?>
  
  <body class="hold-transition login-page">
    <div class="login-box">
      <!-- Erreurs/Succes --> 
      <?php include 'includes/infos.php' ?>
      <div class="login-logo">
        <a href="index.php"><b>Nom</b> LOGO</a>
      </div><!-- /.login-logo -->
      <div class="register-box-body">
        <form action="register.php" method="post" enctype="multipart/form-data">
          <div class="form-group has-feedback">
            <label>Pseudo *</label>
            <input type="text" class="form-control" name="pseudo" placeholder="Pseudo">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <label>Adresse Mail *</label>
            <input type="email" class="form-control" name="email" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <label>Mot de passe *</label>
            <input type="password" class="form-control" name="mot_passe_1" placeholder="Mot de passe">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="mot_passe_2" placeholder="Mot de passe">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <label>Nom *</label>
            <input type="text" class="form-control" name="nom" placeholder="Nom">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <label>Prenom *</label>
            <input type="text" class="form-control" name="prenom" placeholder="Prenom">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <label>Ville *</label>
            <input type="text" class="form-control" name="ville" placeholder="Ville">
            <span class="glyphicon glyphicon-globe form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <label>Date de naissance *</label>
            <input type="date" class="form-control" name="date_naissance" placeholder="Pseudo">
            <span class="glyphicon glyphicon-tag form-control-feedback"></span>
          </div>
          <div class="form-group">
            <label>Photo</label>
            <input type="file" name="photo" accept="image/*">
            <p class="help-block">Non obligatoire. 100 ko max.</p>
          </div>
          <div class="g-recaptcha" data-sitekey="6LfzYxYTAAAAAOtqf4gtRtp6zHwBjGIMEbKV9w1M"></div>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="newsletter" checked> Je souhaite recevoir des newsletters
            </label>
          </div>
          <div class="box-footer">
            <button type="submit" name="register" class="btn btn-primary btn-block btn-flat">Inscription</button>
            <p class="help-block">Les champs accompagnés d'un astérisque sont obigatoires.</p>
            <a href="login.php" class="text-center">J'ai déja un compte</a>
          </div>
        </form>
      </div>
    </div><!-- /.login-box -->
    
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo SITE_PATH ?>js/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo SITE_PATH ?>js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo SITE_PATH ?>js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo SITE_PATH ?>js/demo.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </body>
</html>
