<?php 
  session_start();

  // Permet d'éviter le renvoi auto du formulaire F5
  include 'includes/renvoiFormulaire.php';

  include 'includes/configuration.php';
  include 'includes/connexion.php';
  require_once 'includes/passwordLib.php';
  if(isset($_SESSION["utilisateur"]))
    header("location: profil.php");
  
  $title = "Inscription";
  $pageName = basename($_SERVER['PHP_SELF']);
  include 'includes/head.php';

  if(isset($_POST['register'])){
    //On verifie ce qui a été envoyé
    if(isset($_POST['nom'], $_POST['email'], $_POST['mot_passe_1'], $_POST['mot_passe_2']) AND $_POST['nom']!='' )
    {
      //On enleve lechappement si get_magic_quotes_gpc est active
      if(get_magic_quotes_gpc())
      {
        $_POST['nom'] = stripslashes($_POST['nom']);
        $_POST['email'] = stripslashes($_POST['email']);
        $_POST['mot_passe_1'] = stripslashes($_POST['mot_passe_1']);
        $_POST['mot_passe_2'] = stripslashes($_POST['mot_passe_2']);
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
            $nom = $_POST['nom'];
            $mot_passe = $_POST['mot_passe_1'];
            $email = $_POST['email'];

            // Appel de la fonction exec requete
            $query = "SELECT id from utilisateur WHERE nom='$nom' OR email='$email'";
            // Lecture du/des resultats
            $reponse = $pdo->prepare($query);
            $reponse->execute();
            $utilisateur = $reponse->fetchAll(PDO::FETCH_ASSOC);

            // Si la requete envoi qqch
            if(!$utilisateur){

              // Appel de la fonction exec requete
              $query = "INSERT INTO utilisateur (mot_passe, nom, email) VALUES (:mot_passe, :nom, :email)"; 

              try {
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':mot_passe', password_hash($mot_passe, PASSWORD_BCRYPT)); //Hashage du mot de passe
                $stmt->bindValue(':nom', $nom); 
                $stmt->bindValue(':email', $email); 
                $stmt->execute();
                $_SESSION['succes'] = "Utilisateur inscrit";
              } catch (PDOException $e) {
                echo "Erreur !<br>".$e->getMessage();
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
        <form action="register.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="nom" placeholder="Utilisateur">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="mot_passe_1" placeholder="Mot de passe">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="mot_passe_2" placeholder="Mot de passe">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="register" class="btn btn-primary btn-block btn-flat">Inscription</button>
            </div><!-- /.col -->
          </div>
        </form>
        <a href="login.php" class="text-center">J'ai déja un compte</a>
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
  </body>
</html>
