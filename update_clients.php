<?php
    require 'connexion.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }
    
    $nameError = $adresseError = $telephoneError = $name = $adresse = $telephone = "";
   
    if(!empty($_POST))
    {
        $name            = checkInput($_POST['name']);
        $adresse            = checkInput($_POST['adresse']);
        $telephone       = checkInput($_POST['telephone']);

        $isSuccess       = true;

        if(empty($name))
            {
                $nameError = "Ce champ ne peut pas etre vide";
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

        if(($isSuccess))

        {
            $db = Database::connect();
            
                $statement = $db->prepare("UPDATE clients SET nom = ?, adresse = ?, telephone = ? WHERE id_client = ?");
                $statement->execute(array($name,$adresse,$telephone,$id));
                Database::disconnect();
            header("Location: liste_clients.php");
        }

    }
    else
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM clients WHERE id_client = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $name            = $item['nom'];
        $adresse     = $item['adresse'];
        $telephone           = $item['telephone'];
        Database::disconnect();
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

    <h1 class="text-logo"> <span class="glyphicon glyphicon-"></span> ANIMALERIE <span class="glyphicon glyphicon-"></span> </h1>
    <div class="container admin">
            <div class="row">
            <?php require 'menu.php'; ?>
                <div class="col-sm-6">
                    <h1><strong>Modifier un client</strong></h1>
                        <br>
                        <form action="<?php echo 'update_clients.php?id=' .$id; ?>" role="form" method="post" class="form">
                                    <div class="form-group">
                                        <label for="name">Nom : </label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Nom & Prenom(s)" value="<?php echo $name; ?>"> 
                                        <span class="help-inline"><?php echo $nameError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="race">Adresse : </label>
                                        <input type="text" class="form-control" name="adresse" id="race" placeholder="Adresse" value="<?php echo $adresse; ?>"> 
                                        <span class="help-inline"><?php echo $adresseError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="telephone">telephone : </label>
                                        <input type="number" step="0.1" class="form-control" name="telephone" id="telephone" placeholder="Telephone" value="<?php echo $telephone; ?>"> 
                                        <span class="help-inline"><?php echo $telephoneError; ?></span>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Modifier</span></button>
                                        <a class="btn btn-primary" href="liste_clients.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                                    </div>
                        </form>
                </div>
        
        </div>
    </div>

    </body>
</html>