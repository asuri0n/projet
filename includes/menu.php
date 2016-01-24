<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <a href="<?php echo SITE_PATH ?>index.php" class="navbar-brand"><b>Party</b>MANAGEMENT</a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <!--<li<?php if ($pageName == 'regles.php') {echo ' class="active"';} ?>><a href="<?php echo SITE_PATH ?>regles.php">Règles </a></li>-->
        </ul>
      </div>
      <!-- /.navbar-collapse -->

      <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
  					<!-- Menu Toggle Button -->
            <?php if(isset($_SESSION["username"])) { ?>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs"><?php echo $_SESSION["username"] ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a class="btn btn-default btn-flat" href="profil.php">Profil</a>
                    </div>
                    <div class="pull-right">
                      <a href="login.php?logout" class="btn btn-default btn-flat">Déconnexion</a>
                    </div>
                  </li>
                </ul>
              </li>
            <?php } else { ?>
  					  <li><a href="login.php">Connexion</a></li>
            <?php } ?>
          </ul>
        </div><!-- /.navbar-custom-menu -->
    </div><!-- /.container-fluid -->
  </nav>
</header>