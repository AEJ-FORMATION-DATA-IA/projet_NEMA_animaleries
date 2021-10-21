<?php
    require 'connexion.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }

    $db = Database::connect();
    $statement = $db->prepare('SELECT * FROM animal, categorie, fourrure WHERE animal.id_categorie = categorie.id_categorie AND animal.id_fourrure = fourrure.id_fourrure AND  animal.id_animal = ? ORDER BY animal.id_animal ASC;');
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
    <title>Burger Code</title>
</head>
    <body>

    <h1 class="text-logo"> <span class="glyphicon glyphicon-"></span> ANIMALERIE <span class="glyphicon glyphicon-"></span> </h1>
    <div class="container admin">
            <div class="row">
            <?php require 'menu.php'; ?>
                <div class="col-sm-6">
                <h1><strong>Voir un animal</strong></h1>
                <br>
                <form action="">
                    <div class="form-group">
                        <label>Nom : </label><?php echo ' ' . $item['nom']; ?>
                    </div>
                    <div class="form-group">
                        <label>Race : </label><?php echo ' ' . $item['race']; ?>
                    </div>
                    <div class="form-group">
                        <label>Categorie : </label><?php echo ' ' . $item['categorie']; ?>
                    </div>
                    <div class="form-group">
                        <label>Poids : </label><?php echo ' ' . number_format((float)$item['poids'],2, '.', '') . ' Kg'; ?>
                    </div>
                    <div class="form-group">
                        <label>Age : </label><?php echo ' ' . number_format((float)$item['age'],2, '.', '') . ' mois'; ?>
                    </div>
                    <div class="form-group">
                        <label>Coût : </label><?php echo ' ' . $item['cout']; ?>
                    </div>
                    <div class="form-group">
                        <label>Taille : </label><?php echo ' ' . $item['taille']; ?>
                    </div>
                    <div class="form-group">
                        <label>Fourrure : </label><?php echo ' ' . $item['fourrure']; ?>
                    </div>
                    <div class="form-group">
                        <label>Image : </label><?php echo ' ' . $item['image']; ?>
                    </div>
                </form>
                <br>
                <div class="form-actions">
                <a class="btn btn-primary" href="liste.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
            </div>
        </div>
        <div class="col-sm-6 site">
            <div class="thumbnail">
                <img src="<?php echo 'images/' . $item['image']; ?>" alt="...">
                <div class="price"><?php echo number_format((float)$item['cout'],2, '.', '') . ' FCFA'; ?></div>
                <div class="caption">
                    <h4><?php echo $item['nom']; ?></h4>
                    <p><?php echo $item['id_categorie']; ?></p>
                    <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span>Commander</a>
                </div>
            </div>
         </div>
        
        </div>
    </div>

    </body>
</html>