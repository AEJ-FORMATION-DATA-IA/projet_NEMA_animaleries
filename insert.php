<?php
    require 'connexion.php';
    
    $nomError = $raceError = $poidsError =  $ageError = $coutError = $tailleError = $imageError = $nom = $race = $category = $poids =  $age = $cout = $taille = $fourrure = $image = "";
   
    if(!empty($_POST))
    {
        $nom            = checkInput($_POST['nom']);
        $race     = checkInput($_POST['race']);
        $category           = checkInput($_POST['category']);
        $poids        = checkInput($_POST['poids']);
        $age            = checkInput($_POST['age']);
        $cout     = checkInput($_POST['cout']);
        $taille           = checkInput($_POST['taille']);
        $fourrure        = checkInput($_POST['fourrure']);
        $image           = checkInput($_FILES['image']['name']);
        $imagePath       = 'images/' .basename($image);
        $imageExtension  = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess       = true;
        $isUploadSuccess = false;

        if(empty($nom))
            {
                $nomError = "Ce champ ne peut pas etre vide";
                $isSuccess = false;
            }
        if(empty($race))
        {
            $raceError = "Ce champ ne peut pas etre vide";
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
        
        if(empty($image))
        {
            $imageError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }    
        else{
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

        if($isSuccess && $isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO animal (nom,race,id_categorie,poids,age,cout,taille,id_fourrure,image) values(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $statement->execute(array($nom,$race,$category,$poids,$age,$cout,$taille,$fourrure,$image));
            Database::disconnect();
            header("Location: liste.php");
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
                <h1><strong>Ajouter un animal</strong></h1>
                <br>
                    <form action="insert.php" role="form" method="post" class="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nom">Nom : </label>
                                <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $nom; ?>"> 
                                <span class="help-inline"><?php echo $nomError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="description">Race : </label>
                                <input type="text" class="form-control" name="race" id="race" placeholder="Race" value="<?php echo $race; ?>"> 
                                <span class="help-inline"><?php echo $raceError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="category">Categorie : </label>
                            <select class="form-control" name="category" id="category">
                                <?php 
                                $db = Database::connect();
                                foreach($db->query('SELECT * FROM categorie') as $row)
                                {
                                    echo '<option value="' .$row['id'] . '">' . $row['categorie'] . '</option>';
                                }
                                Database::disconnect();
                                ?>
                            </select>
                            </div>
                            <div class="form-group">
                            <label for="price">Poids : (en Kg)</label>
                                <input type="number" step="0.1" class="form-control" name="poids" id="poids" placeholder="Poids" value="<?php echo $poids; ?>"> 
                                <span class="help-inline"><?php echo $poidsError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="price">Age : (en Mois)</label>
                                <input type="number" class="form-control" name="age" id="age" placeholder="Age" value="<?php echo $age; ?>"> 
                                <span class="help-inline"><?php echo $ageError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="prix">Coût : (en F CFA)</label>
                                <input type="number" step="5" class="form-control" name="cout" id="cout" placeholder="Prix" value="<?php echo $cout; ?>"> 
                                <span class="help-inline"><?php echo $coutError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="prix">Taille : (en metre)</label>
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
                                    echo '<option value="' .$row['id'] . '">' . $row['fourrure'] . '</option>';
                                }
                                Database::disconnect();
                                ?>
                            </select>
                            </div>
                            <div class="form-group">
                            <label for="image">Selectionner une image : </label>
                                <input type="file" name="image" id="image">
                                <span class="help-inline"><?php echo $imageError;?></span>
                            </div>
                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Ajouter</span></button>
                    <a class="btn btn-primary" href="accueil.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                </div>
            </form>
        </div>
    </div>

    </body>
</html>