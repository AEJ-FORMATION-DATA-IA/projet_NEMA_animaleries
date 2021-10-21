<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="jquery-1.12.4.js"></script>
  <script src="jquery-ui.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>ANIMALERIE</title>
</head>

<script>

 $( function() {
    var dateFormat = "yy-mm-dd",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
		  dateFormat: "yy-mm-dd"
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
		dateFormat: "yy-mm-dd"
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  </script>
    <body>

    <h1 class="text-logo"> <span class="glyphicon glyphicon-"></span> animaleries <span class="glyphicon glyphicon-"></span> </h1>
    <div class="container admin">
        <div class="row">
        <?php require 'menu.php'; ?>
        <h1><strong>Liste des ventes</strong><a href="achat.php" class="btn btn-succcess btn-lg"> <span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
        <table>
    <form action="" method="post" name="form" id="form"><table width="108" border="0">
      <tr>
    <td colspan="5">Listez des ventes sur une periode :</td>
   
  </tr>
  <tr>
    <td nowrap="nowrap">Periode du :</td>
    <td><input name="from" type="date" id="from" value="<?php echo(isset($_POST['from'])? $_POST['from']:"") ?>"></td>
    <td nowrap="nowrap">Au :</td>
    <td><label for="au"></label>
      <input type="date" name="to" id="to"  value="<?php echo(isset($_POST['to'])? $_POST['to']:"") ?>"/></td>
    <td><input name="rechercher" type="submit" value="Rechercher"></td>
  </tr>
</table></form><br />
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Client</th>
                    <th>Animal</th>
                    <th>Nombre Anml</th>
                    <th>Montant</th>
                    <th>Produit</th>
                    <th>Quantite pdt</th>
                    <th>Montant</th>
                    <th>Oiseau</th>
                    <th>Nombre Oiseau</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Total Achat</th>
                    <th>Actions</th>
                </tr>
            </head>
            <tbody>
                <?php
                include("connecte.php");
 
                if(isset($_POST['to'])){  
                
                //echo $_POST['form'];
                $from=$_POST['from'];
                $to=$_POST['to'];
                
                  $requet="SELECT achat.id_achat, achat.nombre_aml, achat.t_animal, achat.qte_produit, achat.t_produit, 
                  achat.nombre_oiseau, achat.t_oiseau, achat.date, achat.total_achat, clients.nom, animal.nom AS nom_aml, 
                  produit.libelle, oiseaux.nom AS nom_oiseau FROM achat, clients, animal, produit, oiseaux
                  WHERE achat.id_client = clients.id_client  AND achat.id_animal = animal.id_animal AND  achat.id_produit = produit.id_produit 
                  AND achat.id_oiseau = oiseaux.id_oiseau AND date BETWEEN ? AND ? ORDER BY id_achat ASC";
                  $prepare=$connexion->prepare($requet);
                  $reponse=$prepare->execute(array($from, $to));
                 
                }else{
                  $requet="SELECT achat.id_achat, achat.nombre_aml, achat.t_animal, achat.qte_produit, achat.t_produit, 
                  achat.nombre_oiseau, achat.t_oiseau, achat.date, achat.total_achat, clients.nom, animal.nom AS nom_aml, 
                  produit.libelle, oiseaux.nom AS nom_oiseau FROM achat, clients, animal, produit, oiseaux
                  WHERE achat.id_client = clients.id_client  AND achat.id_animal = animal.id_animal AND  achat.id_produit = produit.id_produit 
                  AND achat.id_oiseau = oiseaux.id_oiseau ORDER BY achat.id_achat ASC";
                  $prepare=$connexion->prepare($requet);
                  $reponse=$prepare->execute();
                }
                    
                while ($donnee=$prepare->Fetch()){
                    
                        echo '<tr>';
                        echo '<td>' . $donnee['id_achat'] . '</td>';
                        echo '<td width="80">' . $donnee['nom'] . '</td>';
                        echo '<td>' . $donnee['nom_aml'] . '</td>';
                        echo '<td>' . $donnee['nombre_aml'] . '</td>';
                        echo '<td>' . $donnee['t_animal'] . '</td>';
                        echo '<td width="80">' . $donnee['libelle'] . '</td>';
                        echo '<td>' . $donnee['qte_produit'] . '</td>';
                        echo '<td>' . $donnee['t_produit'] . '</td>';
                        echo '<td width="80">' . $donnee['nom_oiseau'] . '</td>';
                        echo '<td>' . $donnee['nombre_oiseau'] . '</td>';
                        echo '<td >' . $donnee['t_oiseau'] . '</td>';
                        echo '<td width="100">' . $donnee['date'] . '</td>';
                        echo '<td>' . $donnee['total_achat'] . '</td>';                    
                        echo '<td width="240">';
                        echo '<a href="update_achat.php?id=' . $donnee['id_achat'] . '" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                        echo ' ';
                        echo '<a href="delete_achat.php?id=' . $donnee['id_achat'] . '" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                            echo '</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>


    </div>
    </div>


    </body>
</html>