<?php if(!empty($_SESSION['erreur'])){ ?>

	<div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	  <h4><i class="icon fa fa-ban"></i> ERREUR !</h4>
	    <?php echo $_SESSION['erreur'] ?>
	</div>

<?php }
if(!empty($_SESSION['succes'])){ ?>

	<div class="alert alert-success alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	  <h4><i class="icon fa fa-ban"></i> SUCCES !</h4>
	    <?php echo $_SESSION['succes'] ?>
	</div>

<?php }
	unset($_SESSION['succes'], $_SESSION['erreur']);
?>