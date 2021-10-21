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
    
    $libelleError = $stockerError = $prixError = $libelle = $stocker = $prix = $quantite_en_stock = $stock = "";
   
    if(!empty($_POST))
    {
        $libelle           = checkInput($_POST['libelle']);
        $stocker           = checkInput($_POST['stocker']);
        $prix              = checkInput($_POST['prix']);

        $isSuccess         = true;

        $db = Database::connect();
        $statement = $db->prepare("SELECT stock FROM produit WHERE id_produit = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $quantite_en_stock = $item['stock'];
        $stock = (int)$stocker + (int)$quantite_en_stock;
        Database::disconnect();

        if(empty($libelle))
        {
            $libelleError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($prix))
        {
            $prixError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($stocker))
        {
            $stockerError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
          

        if($isSuccess)

        {
            $db = Database::connect();
                $statement = $db->prepare("UPDATE produit SET libelle = ?, stock = ?, prix = ? WHERE id_produit = ?");
                $statement->execute(array($libelle,$stock,$prix,$id));              

            Database::disconnect();
            header("Location: liste_produit.php");
        }

    }
    
?>
<?php
    $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM produit WHERE id_produit = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $libelle           = $item['libelle'];
        $stocker           = $item['stock'];
        $prix              = $item['prix'];
        
        Database::disconnect();
    
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
    <link rel="stylesheet" href="../css/style.css">
    <title>ANIMALERIE</title>
</head>
    <body>

    <h1 class="text-logo"> <span class="glyphicon glyphicon-cutlery"></span> ANIMALERIE <span class="glyphicon glyphicon-cutlery"></span> </h1>
    <div class="container admin">
            <div class="row">
                    <h1><strong>Modifier l'enregistrement du produit</strong></h1>
                        <br>
                        <form action="<?php echo 'stock_produit.php?id=' .$id; ?>" role="form" method="post" class="form">
                                    <div class="form-group">
                                        <label for="libelle">Libelle : </label>
                                        <input type="text" readonly class="form-control" name="libelle" id="libelle" placeholder="Libelle du produit" value="<?php echo $libelle; ?>"> 
                                        <span class="help-inline"><?php echo $libelleError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="stocker" class="alert alert-danger">Stock : </label>
                                        <input type="number" class="form-control alert alert-warning" name="stocker" id="stocker" placeholder="Quantite a stocker"> 
                                        <span class="help-inline"><?php echo $stockerError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="prix">Prix (en F CFA) : </label>
                                        <input type="number" class="form-control" name="prix" id="prix" placeholder="Le prix unitaire du produit" value="<?php echo $prix; ?>"> 
                                        <span class="help-inline"><?php echo $prixError; ?></span>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Modifier</span></button>
                                        <a class="btn btn-primary" href="liste.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                                    </div>
                        </form>  
            </div>
    </div>

    </body>
</html>