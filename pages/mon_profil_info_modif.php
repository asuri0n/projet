<div class="box box-danger">
  <!-- Info Bulle -->
  <div class="box-header with-border">
    <h3 class="box-title">Modification des informations</h3>
  </div>
  <!-- Barre Progression -->
  <div class="box-body"> 
    <form action="index.php?edit" method="post" enctype="multipart/form-data">
      <div class="form-group has-feedback">
        <label>Pseudo *</label>
        <input type="text" class="form-control" name="pseudo" placeholder="Pseudo" value="<?php echo $user_info['pseudo'] ?>" disabled>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label>Adresse Mail *</label>
        <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $user_info['email'] ?>">
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
        <input type="text" class="form-control" name="nom" placeholder="Nom" value="<?php echo $user_info['nom'] ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label>Prenom *</label>
        <input type="text" class="form-control" name="prenom" placeholder="Prenom" value="<?php echo $user_info['prenom'] ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label>Ville *</label>
        <input type="text" class="form-control" name="ville" placeholder="Ville" value="<?php echo $user_info['ville'] ?>">
        <span class="glyphicon glyphicon-globe form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label>Date de naissance *</label>
        <input type="date" class="form-control" name="date_naissance" value="<?php echo $user_info['date_naissance'] ?>">
        <span class="glyphicon glyphicon-tag form-control-feedback"></span>
      </div>
      <div class="form-group">
        <label>Photo</label>
        <input type="file" name="photo" accept="image/*">
        <p class="help-block">Non obligatoire. 100 Ko max.</p>
      </div>
      <div class="g-recaptcha" data-sitekey="6LfzYxYTAAAAAOtqf4gtRtp6zHwBjGIMEbKV9w1M"></div>
      <div class="checkbox">
        <label>
          <input type="checkbox" name="newsletter" <?php if($user_info['newsletter']){ echo "checked"; } ?>> Je souhaite recevoir des newsletters
        </label>
      </div>
      <div class="box-footer">
        <button type="submit" name="modification" class="btn btn-primary btn-block btn-flat">Modification</button>
      </div>
    </form>
  </div>
</div>