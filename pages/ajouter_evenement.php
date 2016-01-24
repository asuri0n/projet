<div class="modal fade" id="ajout_evenement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="myModalLabel">Nouvel Evenement</h4>
        </div>
        <div class="modal-body">
          <div class="form-group has-feedback">
            <label>Titre de l'evenement</label>
            <input name="sujet" class="form-control" type="text" placeholder="Titre">
          </div>
          <div class="form-group has-feedback">
            <label>Mot de passe de l'evenement</label>
            <input name="sujet" class="form-control" type="password" >
          </div>
          <div class="form-group has-feedback">
            <label>Date evenement</label>
            <input type="date" class="form-control">
            <input type="time" class="form-control">
          </div>
          <div class="form-group has-feedback">
            <label>Inviters (Adresses mails séparées par une virgule)</label>
            <input type="email" class="form-control" name="emailto" placeholder="exemple@gmail.com, exemple2@laposte.net">
          </div>
          <div class="form-group has-feedback">
            <label>Date butoir</label>
            <input type="date" class="form-control">
          </div>
          <div class="form-group has-feedback">
            <label>A ramener</label>
            <table class="table table-bordered" id="tableau">
              <tbody>
                <tr>
                  <th>Nom</th>
                  <th>Quantité</th>
                </tr>
              </tbody>
            </table>
            <button type="button" onclick="ajouterLigne();">Ajouter ligne</button>
          </div><br>
          <div class="form-group has-feedback">
            <label>Contenue de l'invitation</label>
            <form action="#" method="post">
              <div>
                <textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              </div>
            </form>
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