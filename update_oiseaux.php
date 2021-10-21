<?php
    require 'connexion.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }
    
    $nameError = $coutError = $categorieError = $bruitError = $imageError = $name = $cout = $categorie  = $bruit = $image= "";
   
    if(!empty($_POST))
    {
        $name            = checkInput($_POST['name']);
        $cout            = checkInput($_POST['cout']);
        $categorie       = checkInput($_POST['categorie']);
        $bruit        = checkInput($_POST['bruit']);
        $image           = checkInput($_FILES['image']['name']);
        $imagePath       = 'images/' .basename($image);
        $imageExtension  = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess       = true;

        if(empty($name))
            {
                $nameError = "Ce champ ne peut pas etre vide";
                $isSuccess = false;
            }
            if(empty($cout))
            {
                $coutError = "Ce champ ne peut pas etre vide";
                $isSuccess = false;
            }
        if(empty($categorie))
        {
            $categorieError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($bruit))
        {
            $bruitError = "Ce champ ne peut pas etre vide";
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
                $statement = $db->prepare("UPDATE oiseaux SET nom = ?, cout_oiseau = ?, id_categorie_oiseau = ?, bruit = ?, image = ? WHERE id_oiseau = ?");
                $statement->execute(array($name,$cout,$categorie,$bruit,$image,$id));
            }
            else
            { 
                $statement = $db->prepare("UPDATE oiseaux SET nom = ?, cout_oiseau = ?, id_categorie_oiseau = ?, bruit = ? WHERE id_oiseau = ?");
                $statement->execute(array($name,$cout,$categorie,$bruit,$id));          
            }

            Database::disconnect();
            header("Location: liste_oiseaux.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("SELECT image FROM oiseaux WHERE id_oiseau = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image = $item['image'];
            Database::disconnect();
        }

    }
    else
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM oiseaux WHERE id_oiseau = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $name            = $item['nom'];
        $cout            = $item['cout_oiseau'];
        $categorie       = $item['id_categorie_oiseau'];
        $bruit       = $item['bruit'];
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
                    <h1><strong>Modifier un oiseau</strong></h1>
                        <br>
                        <form action="<?php echo 'update_oiseaux.php?id=' .$id; ?>" role="form" method="post" class="form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="name">Nom : </label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Nom" value="<?php echo $name; ?>"> 
                                        <span class="help-inline"><?php echo $nameError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="cout">Coût : (en F CFA)</label>
                                        <input type="number" step="0.1" class="form-control" name="cout" id="poids" placeholder="Coût" value="<?php echo $cout; ?>"> 
                                        <span class="help-inline"><?php echo $coutError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="categorie">categorie : </label>
                                        <select class="form-control" name="categorie" id="categorie">
                                        <?php 
                                        $db = Database::connect();
                                        foreach($db->query('SELECT * FROM categorie_oiseaux') as $row)
                                        {
                                            if($row['id_categorie_oiseau'] == $categorie)
                                            echo '<option selected="selected" value="' .$row['id_categorie_oiseau'] . '">' . $row['categorie_oiseau'] . '</option>';
                                            else
                                             echo '<option value="' .$row['id_categorie_oiseau'] . '">' . $row['categorie_oiseau'] . '</option>';
                                        }
                                        Database::disconnect();
                                        ?>
                                        </select>
                                        <span class="help-inline"><?php echo $categorieError; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="bruit">Bruit : </label>
                                        <input type="text" class="form-control" name="bruit" id="bruit" placeholder="Bruit" value="<?php echo $bruit; ?>"> 
                                        <span class="help-inline"><?php echo $bruitError; ?></span>
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
                                        <a class="btn btn-primary" href="liste_oiseaux.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                                    </div>
                        </form>
                </div>
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo 'images/' . $image; ?>" alt="...">
                        <div class="price"><?php echo number_format((float)$cout,2, '.', '') . ' F CFA'; ?></div>
                        <div class="caption">
                            <h4><?php echo $name; ?></h4>
                            <p><?php echo $categorie; ?></p>
                            <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span>Commander</a>
                        </div>
                    </div>
                </div>
        
        </div>
    </div>

    </body>
</html>