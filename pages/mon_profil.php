<!-- Wrapper Principal -->
<div class="box box-danger">
  <!-- Info Bulle -->
  <div class="box-header with-border">
    <span class="label label-primary pull-left" style="padding: .4em .8em .5em;">4</span>
    <h3 class="box-title" style="margin-left: 10px">Soiré(es) en cours d'organisation</h3>
  </div>
  <!-- Barre Progression -->
  <div class="box-body"> 
      <?php
      if($evenements){
        while ($row = array_shift($evenements)) { // Tant que ya des données
          echo '<div class="ads">';
            echo '<a href="evenement.php?id='.$row["id"].'" class="titre"> '.$row["titre"].' </a>';
            echo '<ul>';
              echo '<li><i class="fa fa-fw fa-clock-o"></i> '.$row["date_evenement"].'</li>';
            echo '</ul>';
          echo '</div>';
        }
      ?>
  <?php } else {} ?>
  </div>
</div>
<div class="box box-danger">
  <!-- Info Bulle -->
  <div class="box-header with-border">
    <span class="label label-primary pull-left" style="padding: .4em .8em .5em;">4</span>
    <h3 class="box-title" style="margin-left: 10px">Invitation(s)</h3>
  </div>
  <!-- Barre Progression -->
  <div class="box-body"> 
    <?php
    if($evenements){
      while ($row = array_shift($evenements)) { // Tant que ya des données
        echo '<div class="ads">';
          echo '<a href="?id='.$row["id"].'" class="titre"> '.$row["titre"].' </a>';
          echo '<ul>';
            echo '<li><i class="fa fa-fw fa-clock-o"></i> '.$row["date_evenement"].'</li>';
          echo '</ul>';
        echo '</div>';
      }
    }
    ?>
  </div>
</div>