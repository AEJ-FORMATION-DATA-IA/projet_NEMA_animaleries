<?php
    require 'connexion.php';
    
    $nomError = $adresseError = $telephoneError = $nom = $adresse = $telephone = "";
   
    if(!empty($_POST))
    {
        $nom             = checkInput($_POST['nom']);
        $adresse         = checkInput($_POST['adresse']);
        $telephone       = checkInput($_POST['telephone']);
        $isSuccess       = true;

        if(empty($nom))
            {
                $nomError = "Ce champ ne peut pas etre vide";
                $isSuccess = false;
            }
        if(empty($adresse))
        {
            $adresseError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($telephone))
        {
            $telephoneError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }

        if($isSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO clients (nom,adresse,telephone) values(?, ?, ?)");
            $statement->execute(array($nom,$adresse,$telephone));
            Database::disconnect();
            header("Location: liste_clients.php");
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
                <h1><strong>Ajouter un client</strong></h1>
                <br>
                    <form action="insert_clients.php" role="form" method="post" class="form">
                            <div class="form-group">
                                <label for="nom">Nom : </label>
                                <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom & Prenom(s)" value="<?php echo $nom; ?>"> 
                                <span class="help-inline"><?php echo $nomError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="adresse">Adresse : </label>
                                <input type="text" class="form-control" name="adresse" id="adresse" placeholder="Adresse" value="<?php echo $adresse; ?>"> 
                                <span class="help-inline"><?php echo $adresseError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="price">Telephone : </label>
                                <input type="number"  class="form-control" name="telephone" id="telephone" placeholder="Numero telephone" value="<?php echo $telephone; ?>"> 
                                <span class="help-inline"><?php echo $telephoneError; ?></span>
                            </div>
                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Ajouter</span></button>
                    <a class="btn btn-primary" href="liste_clients.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                </div>
            </form>
        </div>
    </div>

    </body>
</html>