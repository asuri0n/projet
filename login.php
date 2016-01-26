<?php 
  session_start();

  // Permet d'éviter le renvoi auto du formulaire F5
  include 'includes/renvoiFormulaire.php';

  include 'includes/configuration.php';
  include 'includes/connexion.php';
  require_once 'includes/passwordLib.php';

  //Si il veux se deconnecter
  if(isset($_GET['logout'])) {
    unset($_SESSION['username'], $_SESSION['userid']);
    header("location: index.php");
  }

  // Si il est connecté, ca va sur le profil
  if(isset($_SESSION["username"]))
    header("location: index.php");
  
  $title = "Connexion";
  $pageName = basename($_SERVER['PHP_SELF']);
  include 'includes/head.php';

  // POST du connexion
  if(isset($_POST['login'])){
    if(isset($_POST['g-recaptcha-response']) AND $_POST['g-recaptcha-response'] == true){
      if(isset($_POST['pseudo'], $_POST['mot_passe'])){
        //On echappe les variables
        if(get_magic_quotes_gpc()){
          $pseudo = stripslashes($_POST['pseudo']);
          $mot_passe = stripslashes($_POST['mot_passe']);
        }else{
          $pseudo = $_POST['pseudo'];
          $mot_passe = $_POST['mot_passe'];
        }

        // Appel de la fonction exec requete
        $query = "SELECT mot_passe,id from utilisateur WHERE pseudo='$pseudo'"; 

        // Lecture du/des resultats
        $reponse = $pdo->prepare($query);
        $reponse->execute();
        $utilisateur = $reponse->fetch(PDO::FETCH_ASSOC);

        // Si la requete envoi qqch
        if($utilisateur){
          //Récuperation du mot de passe
          $hash = $utilisateur['mot_passe'];
          // Vérification entre le Hash de la BDD et du pw donné par l'user
          if(password_verify($mot_passe, $hash)){
            // Set des variables sessions
            $_SESSION["username"] = $pseudo;
            $_SESSION["userid"] = $utilisateur['id'];
            //Rediretion accueil
            header('location: index.php');
          } else {
            // Affiche erreur
            $_SESSION['erreur'] = "Le mot de passe ne correspond pas !";
          }
        } else {
          // Affiche erreur
          $_SESSION['erreur'] = "L'utilisateur n'existe pas";
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
      <div class="login-box-body">
        <form action="login.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Utilisateur" name="pseudo">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Mot de passe" name="mot_passe">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>          
          <div class="g-recaptcha" data-sitekey="6LfzYxYTAAAAAOtqf4gtRtp6zHwBjGIMEbKV9w1M"></div><br>
          <div class="row">
            <div class="col-xs-8">
              <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Connexion</button>
            </div><!-- /.col -->
          </div>
        </form>
        <br>
        <a href="#">Mot de passe oublié</a><br>
        <a href="register.php" class="text-center">Inscription</a>
      </div><!-- /.login-box-body -->
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
