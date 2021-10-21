<?php
    require 'connexion.php';
    
    $nomError = $coutError = $categoryError = $bruitError = $imageError = $nom = $cout = $category =  $bruit = $image = "";
   
    if(!empty($_POST))
    {
        $nom            = checkInput($_POST['nom']);
        $cout     = checkInput($_POST['cout']);
        $category           = checkInput($_POST['category']);
        $bruit        = checkInput($_POST['bruit']);
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
        if(empty($cout))
        {
            $coutError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($category))
        {
            $categoryError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($bruit))
        {
            $bruitError = "Ce champ ne peut pas etre vide";
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
            $statement = $db->prepare("INSERT INTO oiseaux (nom,cout_oiseau,id_categorie_oiseau,bruit,image) values(?, ?, ?, ?, ?)");
            $statement->execute(array($nom,$cout,$category,$bruit,$image));
            Database::disconnect();
            header("Location: liste_oiseaux.php");
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
                <h1><strong>Ajouter un oiseau</strong></h1>
                <br>
                    <form action="insert_oiseaux.php" role="form" method="post" class="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nom">Nom : </label>
                                <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $nom; ?>"> 
                                <span class="help-inline"><?php echo $nomError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="prix">Coût : (en F CFA)</label>
                                <input type="number" step="5" class="form-control" name="cout" id="cout" placeholder="Prix" value="<?php echo $cout; ?>"> 
                                <span class="help-inline"><?php echo $coutError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="category">Categorie : </label>
                            <select class="form-control" name="category" id="category">
                                <?php 
                                $db = Database::connect();
                                foreach($db->query('SELECT * FROM categorie_oiseaux') as $row)
                                {
                                    echo '<option value="' .$row['id_categorie_oiseau'] . '">' . $row['categorie_oiseau'] . '</option>';
                                }
                                Database::disconnect();
                                ?>
                            </select>
                                <span class="help-inline"><?php echo $categoryError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="nom">Bruit : </label>
                                <input type="text" class="form-control" name="bruit" id="bruit" placeholder="bruit" value="<?php echo $bruit; ?>"> 
                                <span class="help-inline"><?php echo $bruitError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="image">Selectionner une image : </label>
                                <input type="file" name="image" id="image">
                                <span class="help-inline"><?php echo $imageError;?></span>
                            </div>
                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Ajouter</span></button>
                    <a class="btn btn-primary" href="liste_oiseaux.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                </div>
            </form>
        </div>
    </div>

    </body>
</html>