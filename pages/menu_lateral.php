<div class="box box-danger">
  <div class="box-body box-profile">
    <?php 
      if($user_info['photo']){ 
        echo '<img class="profile-user-img img-responsive img-circle" src="'.SITE_PATH.'/photos/'.$user_info['pseudo'].'.jpg" alt="User profile picture">';
      } else {
        echo '<img class="profile-user-img img-responsive img-circle" src="'.SITE_PATH.'/photos/template/inviter_image.png" alt="User profile picture">';
      } 
    ?>

    <h3 class="profile-username text-center"><?php echo ucfirst($user_info['pseudo']) ?></h3>
    <p class="text-muted text-center"><?php echo ucfirst($user_info['nom']).' '.ucfirst($user_info['prenom']) ?><br><?php echo ucfirst($user_info['ville']) ?></p>
    
      <?php
        if((isset($_GET['id']) AND $info_max) OR isset($_GET['edit'])) {
      ?>
      <a href="<?php echo SITE_PATH ?>profil/index.php?edit"><button class="btn btn-primary btn-block" data-toggle="modal"><b>Modifier mes informations</b></button></a><br>
      <a href="<?php echo SITE_PATH ?>profil/index.php?contact"><button class="btn btn-primary btn-block" data-toggle="modal"><b>Mes contacts</b></button></a><br>
      <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#ajout_evenement"><b>Ajouter une soirée</b></button>
      <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#rejoindre_evenement"><b>Rejoindre une soirée</b></button>
    <?php } else { ?>
      <a href="#"><button class="btn btn-primary btn-block" data-toggle="modal"><b>Envoyer un mail</b></button></a>
    <?php } ?>
  </div>
</div>