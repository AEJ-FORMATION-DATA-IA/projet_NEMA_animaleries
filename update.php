<?php
    require 'connexion.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }
    
    $nameError = $raceError = $categorieError  = $poidsError = $ageError = $coutError = $tailleError = $fourrureError = $imageError = $name = $race = $categorie  = $poids = $age = $cout = $taille = $fourrure = $image= "";
   
    if(!empty($_POST))
    {
        $name            = checkInput($_POST['name']);
        $race            = checkInput($_POST['race']);
        $categorie       = checkInput($_POST['categorie']);
        $poids           = checkInput($_POST['poids']);
        $age             = checkInput($_POST['age']);
        $cout            = checkInput($_POST['cout']);
        $taille          = checkInput($_POST['taille']);
        $fourrure        = checkInput($_POST['fourrure']);
        $image           = checkInput($_FILES['image']['name']);
        $imagePath       = 'images/' .basename($image);
        $imageExtension  = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess       = true;

        if(empty($name))
            {
                $nameError = "Ce champ ne peut pas etre vide";
                $isSuccess = false;
            }
        if(empty($race))
        {
            $raceError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($categorie))
        {
            $categorieError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($poids))
        {
            $poidsError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($age))
        {
            $ageError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($cout))
        {
            $coutError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($taille))
        {
            $tailleError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($fourrure))
        {
            $fourrureError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($image))
        {
           $isImageUpdated = false;
        }    
        else{
            $isImageUpdated = true;
            $isUploadSuccess = true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
            {
                $imageError = "Les fichiers autorises sont : .jpg, .jpeg, .png, .gif";
                $isSuccess = false;
            }
            if(file_exists($imagePath))
            {
                $imageError = "Le fichier existe deja";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 500000)
            {
                $imageError = "Le fichier ne dois pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess)
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
                {
                    $imageError = "Il y a une erreur lors de l'upload";
                    $isUploadSuccess = false;
                }
            }
        }    

        if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))

        {
            $db = Database::connect();
            if($isImageUpdated)
            {
                $statement = $db->prepare("UPDATE animal SET nom = ?, race = ?, id_categorie = ?, poids = ?, age = ?, cout = ?, taille = ?, id_fourrure = ?, image = ? WHERE id_animal = ?");
                $statement->execute(array($name,$race,$categorie,$poids,$age,$cout,$taille,$fourrure,$image,$id));
            }
            else
            {
                $statement = $db->prepare("UPDATE animal SET nom = ?, race = ?, id_categorie = ?, poids = ?, age = ?, cout = ?, taille = ?, id_fourrure = ? WHERE id_animal = ?");
                $statement->execute(array($name,$race,$categorie,$poids,$age,$cout,$taille,$fourrure,$id));            
            }

            Database::disconnect();
            header("Location: liste.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("SELECT image FROM animal WHERE id_animal = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image = $item['image'];
            Database::disconnect();
        }

    }
    else
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM animal WHERE id_animal = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $name            = $item['nom'];
        $description     = $item['race'];
        $categorie       = $item['id_categorie'];
        $poids           = $item['poids'];
        $age             = $item['age'];
        $cout            = $item['cout'];
        $taille      = $item['taille'];
        $fourrure       = $item['id_fourrure'];
        $image           = $item['image'];
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
                    <h1><strong>Modifier un animal</strong></h1>
                        <br>
                        <form action="<?php echo 'update.php?id=' .$id; ?>" role="form" method="post" class="form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="name">Nom : </label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Nom" value="<?php echo $name; ?>"> 
                                        <span class="help-inline"><?php echo $nameError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="race">Race : </label>
                                        <input type="text" class="form-control" name="race" id="race" placeholder="Race" value="<?php echo $race; ?>"> 
                                        <span class="help-inline"><?php echo $raceError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="categorie">categorie : </label>
                                        <select class="form-control" name="categorie" id="categorie">
                                        <?php 
                                        $db = Database::connect();
                                        foreach($db->query('SELECT * FROM categorie') as $row)
                                        {
                                            if($row['id_categorie'] == $categorie)
                                            echo '<option selected="selected" value="' .$row['id_categorie'] . '">' . $row['categorie'] . '</option>';
                                            else
                                             echo '<option value="' .$row['id_categorie'] . '">' . $row['categorie'] . '</option>';
                                        }
                                        Database::disconnect();
                                        ?>
                                        </select>
                                        <span class="help-inline"><?php echo $fourrureError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="poids">Poids : (en Kg)</label>
                                        <input type="number" step="0.1" class="form-control" name="poids" id="poids" placeholder="Poids" value="<?php echo $poids; ?>"> 
                                        <span class="help-inline"><?php echo $poidsError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="poids">Age : (en Mois)</label>
                                        <input type="number" step="0.1" class="form-control" name="age" id="age" placeholder="Age" value="<?php echo $age; ?>"> 
                                        <span class="help-inline"><?php echo $ageError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="cout">Coût : (en F CFA)</label>
                                        <input type="number" step="0.1" class="form-control" name="cout" id="poids" placeholder="Coût" value="<?php echo $cout; ?>"> 
                                        <span class="help-inline"><?php echo $coutError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="poids">Taille : (en metres)</label>
                                        <input type="number" step="0.1" class="form-control" name="taille" id="taille" placeholder="Taille" value="<?php echo $taille; ?>"> 
                                        <span class="help-inline"><?php echo $tailleError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="fourrure">Fourrure : </label>
                                        <select class="form-control" name="fourrure" id="fourrure">
                                        <?php 
                                        $db = Database::connect();
                                        foreach($db->query('SELECT * FROM fourrure') as $row)
                                        {
                                            if($row['id_fourrure'] == $fourrure)
                                            echo '<option selected="selected" value="' .$row['id_fourrure'] . '">' . $row['fourrure'] . '</option>';
                                            else
                                             echo '<option value="' .$row['id_fourrure'] . '">' . $row['fourrure'] . '</option>';
                                        }
                                        Database::disconnect();
                                        ?>
                                        </select>
                                        <span class="help-inline"><?php echo $fourrureError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Image:</label>
                                        <p><?php echo $image; ?></p>
                                        <label for="image">Selectionner une image : </label>
                                        <input type="file" name="image" id="image">
                                        <span class="help-inline"><?php echo $imageError;?></span>
                                        <br>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Modifier</span></button>
                                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                                    </div>
                        </form>
                </div>
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo 'images/' . $image; ?>" alt="...">
                        <div class="price"><?php echo number_format((float)$cout,2, '.', '') . ' F CFA'; ?></div>
                        <div class="caption">
                            <h4><?php echo $name; ?></h4>
                            <p><?php echo $race; ?></p>
                            <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span>Commander</a>
                        </div>
                    </div>
                </div>
        
        </div>
    </div>

    </body>
</html>