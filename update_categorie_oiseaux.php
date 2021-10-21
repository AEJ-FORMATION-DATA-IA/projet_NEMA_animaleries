<?php
    require 'connexion.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }
    
    $categorieError = $categorie = "";
   
    if(!empty($_POST))
    {
        $categorie       = checkInput($_POST['categorie']);
        $isSuccess       = true;

        if(empty($categorie))
            {
                $categorieError = "Ce champ ne peut pas etre vide";
                $isSuccess = false;
            }
            

        if(($isSuccess))

        {
            $db = Database::connect();
            $statement = $db->prepare("UPDATE categorie_oiseaux SET categorie_oiseau = ? WHERE id_categorie_oiseau = ?");
            $statement->execute(array($categorie,$id));            

            Database::disconnect();
            header("Location: liste_categorie_oiseaux.php");
        }  

    }
    else
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM categorie_oiseaux WHERE id_categorie_oiseau = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $categorie = $item['categorie_oiseau'];
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
                    <h1><strong>Modifier une categorie d'animal</strong></h1>
                        <br>
                        <form action="<?php echo 'update_categorie_oiseaux.php?id=' .$id; ?>" role="form" method="post" class="form">
                                    <div class="form-group">
                                        <label for="categorie">Categorie : </label>
                                        <input type="text" class="form-control" name="categorie" id="name" placeholder="Categorie" value="<?php echo $categorie; ?>"> 
                                        <span class="help-inline"><?php echo $categorieError; ?></span>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Modifier</span></button>
                                        <a class="btn btn-primary" href="liste_categorie_oiseaux.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                                    </div>
                        </form>
                </div>
        
        </div>
    </div>

    </body>
</html>