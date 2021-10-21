<?php
    require 'connexion.php';
    
    $clientError = $animalError = $nombreError = $produitError =  $quantiteError = $oiseauError = $nbreError = $client = $animal = $nombre = $produit = $quantite = $oiseau =  $nbre  = "";
   
    if(!empty($_POST))
    {
        $client            = checkInput($_POST['client']);
        $animal     = checkInput($_POST['animal']);
        $nombre           = checkInput($_POST['nombre']);
        $produit        = checkInput($_POST['produit']);
        $quantite            = checkInput($_POST['quantite']);
        $oiseau     = checkInput($_POST['oiseau']);
        $nbre           = checkInput($_POST['nbre']);
        $total = $total_animal + $total_produit + $total_oiseau;
        $isSuccess = true;


        if(empty($client))
            {
                $clientError = "Ce champ ne peut pas etre vide";
                $isSuccess = false;
            }
            else{
                    if(($animal=0) && empty($produit=0) && empty($oiseau=0))
                    {
                        $animalError = $produitError = $oiseauError = "Ces champs ne peuvent pas tous etre vides. Veuillez choisir un animal, un produit ou un oiseau";
                        $isSuccess = false;
                    }
                    elseif(($animal!=0))
                        {
                            if(empty($nombre))
                            {
                                $nombreError = "Ce champ ne peut pas etre vide. Veuillez saisir la quantite";
                                $isSuccess = false;
                            }
                            else
                            {
                                $db = Database::connect();
                                foreach($db->query('SELECT cout FROM animal WHERE id_animal = $animal') as $row)
                                    $statement = $db->prepare("SELECT cout FROM animal WHERE id_animal = $animal");
                                    $statement->execute(array($id));
                                    $item = $statement->fetch();
                                    $quantite_en_stock = $item['stock'];
                                    $stock = (int)$stocker + (int)$quantite_en_stock;
                                    Database::disconnect();
                            }
                        }
                    elseif(($produit!=0))
                    {
                        if(empty($quantite))
                        {
                            $quantiteError = "Ce champ ne peut pas etre vide. Veuillez saisir la quantite";
                            $isSuccess = false;
                        }
                    }
                    elseif(($oiseau!=0))
                    {
                        if(empty($nbre))
                        {
                            $nbreError = "Ce champ ne peut pas etre vide. Veuillez saisir la quantite";
                            $isSuccess = false;
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
                <h1><strong>Enregistrer un achat</strong></h1>
                <br>
                    <form action="achat.php" role="form" method="post" class="form">
                            <div class="form-group">
                                <label for="client">Client : </label>
                                    <select class="form-control" name="client" id="client">
                                    <option value="0" selected>---Choisissez votre client---</option>
                                        <?php 
                                        $db = Database::connect();
                                        foreach($db->query('SELECT * FROM clients') as $row)
                                        {
                                            echo '<option value="' .$row['id_client'] . '">' . $row['nom'] . '</option>';
                                        }
                                        Database::disconnect();
                                        ?>
                                    </select>
                                <span class="help-inline"><?php echo $clientError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="animal">Animal : </label>
                                    <select class="form-control" name="animal" id="animal">
                                    <option value="0" selected>---Choisissez un animal---</option>
                                        <?php 
                                        $db = Database::connect();
                                        foreach($db->query('SELECT * FROM animal') as $row)
                                        {
                                            echo '<option value="' .$row['id_animal'] . '">' . $row['nom'] . '</option>';
                                        }
                                        Database::disconnect();
                                        ?>
                                    </select>
                                <span class="help-inline"><?php echo $animalError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="nombre">Nombre : </label>
                                <input type="number" class="form-control" name="nombre" id="nombre" placeholder="nombre animal" value="<?php echo $nombre; ?>"> 
                                <span class="help-inline"><?php echo $nombreError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="produit">Produit : </label>
                                    <select class="form-control" name="produit" id="produit">
                                    <option value="0" selected>---Choisissez un produit---</option>
                                        <?php 
                                        $db = Database::connect();
                                        foreach($db->query('SELECT * FROM produit') as $row)
                                        {
                                            echo '<option value="' .$row['id_produit'] . '">' . $row['libelle'] . '</option>';
                                        }
                                        Database::disconnect();
                                        ?>
                                    </select>
                                <span class="help-inline"><?php echo $produitError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="quantite">Quantite du produit : </label>
                                <input type="number" class="form-control" name="quantite" id="quantite" placeholder="quantite du produit" value="<?php echo $quantite; ?>"> 
                                <span class="help-inline"><?php echo $quantiteError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="oiseau">Oiseau : </label>
                                    <select class="form-control" name="oiseau" id="oiseau">
                                    <option value="0" selected>---Choisissez un oiseau---</option>
                                        <?php 
                                        $db = Database::connect();
                                        foreach($db->query('SELECT * FROM oiseaux') as $row)
                                        {
                                            echo '<option value="' .$row['id_oiseau'] . '">' . $row['nom'] . '</option>';
                                        }
                                        Database::disconnect();
                                        ?>
                                    </select>
                                <span class="help-inline"><?php echo $oiseauError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="nbre">Nombre d'oiseaux : </label>
                                <input type="number" class="form-control" name="nbre" id="nbre" placeholder="Nombre d'oiseaux " value="<?php echo $nbre; ?>">
                                <span class="help-inline"><?php echo $nbreError; ?></span>
                            </div>
                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> Ajouter</span></button>
                    <a class="btn btn-primary" href="vente.php"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a>
                </div>
            </form>
        </div>
    </div>

    </body>
</html>