<?php
    require 'connexion.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }

    $db = Database::connect();
    $statement = $db->prepare('SELECT * FROM oiseaux, categorie_oiseaux WHERE oiseaux.id_categorie_oiseau = categorie_oiseaux.id_categorie_oiseau AND  oiseaux.id_oiseau = ? ORDER BY oiseaux.id_oiseau ASC;');
    $statement->execute(array($id));
    $item = $statement->fetch();
    Database::disconnect();

    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
    <link rel="stylesheet" href="..css/style.css">
    <title>ANIMALERIE</title>
</head>
    <body>

    <h1 class="text-logo"> <span class="glyphicon glyphicon-"></span> ANIMALERIE <span class="glyphicon glyphicon-"></span> </h1>
    <div class="container admin">
            <div class="row">
            <?php require 'menu.php'; ?>
                <div class="col-sm-6">
                <h1><strong>Voir un oiseau</strong></h1>
                <br>
                <form action="">
                    <div class="form-group">
                        <label>Nom : </label><?php echo ' ' . $item['nom']; ?>
                    </div>
                    <div class="form-group">
                        <label>Coût : </label><?php echo ' ' . $item['cout_oiseau']; ?>
                    </div>
                    <div class="form-group">
                        <label>Categorie : </label><?php echo ' ' . $item['categorie_oiseau']; ?>
                    </div>
                    <div class="form-group">
                        <label>Bruit : </label><?php echo ' ' . $item['bruit']; ?>
                    </div>
                    <div class="form-group">
                        <label>Image : </label><?php echo ' ' . $item['image']; ?>
                    </div>
                </form>
                <br>
                <div class="form-actions">
                <a class="btn btn-primary" href="liste_oiseaux.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
            </div>
        </div>
        <div class="col-sm-6 site">
            <div class="thumbnail">
                <img src="<?php echo 'images/' . $item['image']; ?>" alt="...">
                <div class="price"><?php echo number_format((float)$item['cout_oiseau'],2, '.', '') . ' FCFA'; ?></div>
                <div class="caption">
                    <h4><?php echo $item['nom']; ?></h4>
                    <p><?php echo $item['id_categorie_oiseau']; ?></p>
                    <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span>Commander</a>
                </div>
            </div>
         </div>
        
        </div>
    </div>

    </body>
</html>