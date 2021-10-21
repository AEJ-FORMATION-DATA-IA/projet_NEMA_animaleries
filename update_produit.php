<?php
    require 'connexion.php';

    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }
    
    $libelleError = $prixError = $stockError = $libelle = $stock = $prix = "";
   
    if(!empty($_POST))
    {
        $libelle           = checkInput($_POST['libelle']);
        $stock             = checkInput($_POST['stock']);
        $prix              = checkInput($_POST['prix']);
        $isSuccess         = true;

        if(empty($libelle))
        {
            $libelleError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($stock))
        {
            $stockError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
          

        if($isSuccess)

        {
            $db = Database::connect();
            
                $statement = $db->prepare("UPDATE produit SET libelle = ?, stock = ?, prix = ? WHERE id_produit = ?");
                $statement->execute(array($libelle, $stock, $prix, $id));              

            Database::disconnect();
            header("Location: liste_produit.php");
        }

    }
    else
    {
    $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM produit WHERE id_produit = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $libelle  = $item['libelle'];
        $stock    = $item['stock'];
        $prix     = $item['prix'];
        Database::disconnect();
    }
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <title>ANIMALERIE</title>
</head>
    <body>

    <h1 class="text-logo"> <span class="glyphicon glyphicon-"></span> ANIMALERIE <span class="glyphicon glyphicon-"></span> </h1>
    <div class="container admin">
            <div class="row">
            <?php require 'menu.php'; ?>
                    <h1><strong>Modifier l'enregistrement du produit</strong></h1>
                        <br>
                        <form action="<?php echo 'update_produit.php?id=' .$id; ?>" role="form" method="post" class="form">
                                    <div class="form-group">
                                        <label for="libelle">Libelle : </label>
                                        <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Libelle du produit" value="<?php echo $libelle; ?>"> 
                                        <span class="help-inline"><?php echo $libelleError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="stock">Quantite : </label>
                                        <input type="number" class="form-control" name="stock" id="stock" placeholder="Quantite du produit" value="<?php echo $stock; ?>"> 
                                        <span class="help-inline"><?php echo $stockError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="prix">Prix : </label>
                                        <input type="number" class="form-control" name="prix" id="prix" placeholder="Prix unitaitre du produit" value="<?php echo $prix; ?>"> 
                                        <span class="help-inline"><?php echo $prixError; ?></span>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Modifier</span></button>
                                        <a class="btn btn-primary" href="liste_produit.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                                    </div>
                        </form>  
            </div>
    </div>

    </body>
</html>