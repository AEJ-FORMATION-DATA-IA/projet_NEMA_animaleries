<?php
    require 'connexion.php';

    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }
    if(!empty($_POST))
    {
        $id = checkInput($_POST['id']);
        $db = Database::connect();
        $statement = $db->prepare("DELETE FROM clients WHERE id_client = ?");
        $statement->execute(array($id));
        Database::disconnect();
        header("Location: liste_clients.php");

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
    <title>ANIMALERIES</title>
</head>
    <body>

    <h1 class="text-logo"> <span class="glyphicon glyphicon-"></span> ANIMALERIES <span class="glyphicon glyphicon-"></span> </h1>
    <div class="container admin">
            <div class="row">
                    <h1><strong>Supprimer un client </strong></h1>
                    <br>
                <form action="delete_clients.php" role="form" method="post" class="form">
                        <input type="hidden" name="id" value="<?php echo $id;?>" />
                        <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>    
                        <div class="form-actions">
                            <button type="submit" class="btn btn-warning"> Oui</button>
                            <a class="btn btn-default" href="liste_clients.php"> Non</a>
                        </div>
                </form>
            </div>
    </div>

    </body>
</html>