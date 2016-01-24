<?php
    function query_fetchAll($query, $pdo){
      $reponse = $pdo->prepare($query);
      $reponse->execute();
      return $donnees = $reponse->fetchAll(PDO::FETCH_ASSOC);
    }
    function query_fetch($query, $pdo){
      $reponse = $pdo->prepare($query);
      $reponse->execute();
      return $donnees = $reponse->fetch();
    }
?>
