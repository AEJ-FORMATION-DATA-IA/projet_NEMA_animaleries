<?php
    require 'connexion.php';
    
    $libelleError = $stockError = $prixError = $libelle = $stock = $prix = "";
   
    if(!empty($_POST))
    {
        $libelle             = checkInput($_POST['libelle']);
        $stock               = checkInput($_POST['stock']);
        $prix                = checkInput($_POST['prix']);
        $isSuccess           = true;
        $isUploadSuccess     = false;


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
            $statement = $db->prepare("INSERT INTO produit (libelle,stock,prix) values(?, ?, ?)");
            $statement->execute(array($libelle,$stock,$prix));
            Database::disconnect();
            header("Location: liste_produit.php");
        }

    }


    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>ANIMALERIE</title>
</head>
    <body>

    <h1 class="text-logo"> <span class="glyphicon glyphicon"></span> ANIMALERIE <span class="glyphicon glyphicon"></span> </h1>
    <div class="container admin">
            <div class="row">
            <?php require 'menu.php'; ?>
                <h1><strong>Ajouter un produit</strong></h1>
                <br>
                    <form action="insert_produit.php" role="form" method="post" class="form">
                            <div class="form-group">
                            <label for="libelle">Libelle : </label>
                                <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Libelle du produit" value="<?php echo $libelle; ?>"> 
                                <span class="help-inline"><?php echo $libelleError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="stock">Quantite : </label>
                                <input type="number" class="form-control" name="stock" id="stock" placeholder="La quantite du produit" value="<?php echo $stock; ?>"> 
                                <span class="help-inline"><?php echo $stockError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="prix">Prix du produit : </label>
                                <input type="number" class="form-control" name="prix" id="prix" placeholder="Le prix unitaire du produit" value="<?php echo $prix; ?>"> 
                                <span class="help-inline"><?php echo $prixError; ?></span>
                            </div>
                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Ajouter</span></button>
                    <a class="btn btn-primary" href="liste_produit.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                </div>
            </form>
        </div>
    </div>

    </body>
</html>