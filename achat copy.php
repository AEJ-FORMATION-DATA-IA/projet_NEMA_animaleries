<?php
    require 'connexion.php';
    
    $clientError = $animalError = $nombreError = $produitError = $quantiteError = $oiseauError = $nbreError = $client = $animal = $nombre = $produit = $quantite = $oiseau = $nbre = "";
   
    if(!empty($_POST))
    {
        $client            = checkInput($_POST['client']);
        $animal            = checkInput($_POST['animal']);
        $nombre            = checkInput($_POST['nombre']);
        $produit           = checkInput($_POST['produit']);
        $quantite          = checkInput($_POST['quantite']);
        $oiseau            = checkInput($_POST['oiseau']);
        $nbre              = checkInput($_POST['nbre']);
        $cout_animal = $cout_oiseau = $cout_produit = $total = $total_animal = $total_produit = $total_oiseau = 0;
        
        $isSuccess = true;


        if(empty($client))
            {
                $clientError = "Ce champ ne peut pas etre vide";
                $isSuccess = false;
            }
            else
            {
                    if(($animal=0) && ($produit=0) && ($oiseau=0))
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
                                $donnee = $db->query('SELECT cout FROM animal WHERE id_animal = '.$animal);

                                $cout_animal = $donnee->fetch(PDO::FETCH_ASSOC);
                                
                                    // echo 'total animal' . $total_animal .'<br>';
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
                            else
                            {
                                $db = Database::connect();
                                $donnee = $db->query('SELECT prix FROM produit WHERE id_produit = '.$produit);
                                $cout_produit = $donnee->fetch(PDO::FETCH_ASSOC);
                                
                                // echo 'total produit' . $total_produit .'<br>';
                                    Database::disconnect();
                            }
                    }
                    elseif(($oiseau!=0))
                    {
                        if(empty($nbre))
                        {
                            $nbreError = "Ce champ ne peut pas etre vide. Veuillez saisir la quantite";
                            $isSuccess = false;
                        }
                        else
                        {
                            $db = Database::connect();
                            $donnee = $db->query('SELECT cout_oiseau FROM oiseaux WHERE id_oiseau = '.$oiseau);
                            $cout_oiseau = $donnee->fetch(PDO::FETCH_ASSOC);
                                
                                // echo 'total oiseau' . $total_oiseau .'<br>';
                                Database::disconnect();


                        }
                    }
            }
        
                if($isSuccess)
                {
                    $total_animal = (int)$nombre * (int)$cout_animal;
                    $total_produit = (int)$quantite * (int)$cout_produit;
                    $total_oiseau = (int)$nbre * (int)$cout_oiseau;

                    $total = (int)$total_animal + (int)$total_produit + (int)$total_oiseau;
                
                // echo 'total' . $total;
                    $db = Database::connect();
                    $statement = $db->prepare("INSERT INTO achat (id_client,id_animal,nombre_aml,t_animal,id_produit,qte_produit,t_produit,id_oiseau,nombre_oiseau,t_oiseau,date,total_achat) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
                    $statement->execute(array($client,$animal,$nombre,$total_animal,$produit,$quantite,$total_produit,$oiseau,$nbre,$total_oiseau,$total));
                    Database::disconnect();
                    header("Location: liste_achat.php");
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

    <h1 class="text-logo"> <span class="glyphicon glyphicon"></span> ANIMALERIE <span class="glyphicon glyphicon"></span> </h1>
    <div class="container admin">
            <div class="row">
            <?php require 'menu.php'; ?>
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
                                    <option value="0" selected>---Choisissez votre animal---</option>
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
                                    <option value="0" selected>---Pas de produit choisi---</option>
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
                                    <option value="0" selected>---Pas d'oiseau choisi---</option>
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