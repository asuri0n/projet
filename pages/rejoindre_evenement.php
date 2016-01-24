<div class="modal fade" id="rejoindre_evenement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="myModalLabel">Rejoindre un Evenement</h4>
        </div>
        <div class="modal-body">
          <p>Pour rejoindre un evenement auquelle vous avez été invité, vous devez renseigner l'identifiant de l'evenement ainsi que le mot de passe de l'evenement qui vous ont été envoyé par mail.</p>
          <input style="display:none"> <!-- Pour éviter l'auto remplissage des inpute -->
          <input type="password" style="display:none"> <!-- Pour éviter l'auto remplissage des inpute -->
          <div class="form-group has-feedback">
            <label>Numero de l'evenement</label>
            <input name="sujet" class="form-control" type="text" autocomplete="off">
          </div>
          <div class="form-group has-feedback">
            <label>Mot de passe</label>
            <input name="sujet" class="form-control" type="password" autocomplete="off">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-success">Envoyer</button>
        </div>
      </form>
    </div>
  </div>
</div>  