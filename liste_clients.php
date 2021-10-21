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

    <h1 class="text-logo"> <span class="glyphicon glyphicon-"></span> ANIMALERIES <span class="glyphicon glyphicon-"></span> </h1>
    <div class="container admin">
        <div class="row">
        <?php require 'menu.php'; ?>
        <h1><strong>Liste des Clients</strong><a href="insert_clients.php" class="btn btn-succcess btn-lg"> <span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom & Prenom(s)</th>
                    <th>Adresse</th>
                    <th>Telephone</th>
                    <th>Actions</th>
                </tr>
            </head>
            <tbody>
                <?php
                    require 'connexion.php';
                    $db = Database::connect();
                    $statement = $db->query('SELECT * FROM clients ORDER BY id_client ASC;');
                    while($item = $statement->fetch())
                    {
                        echo '<tr>';
                        echo '<td>' . $item['id_client'] . '</td>';
                        echo '<td>' . $item['nom'] . '</td>';
                        echo '<td>' . $item['adresse'] . '</td>';
                        echo '<td>' . $item['telephone'] . '</td>';  
                        echo '<td width="230">';
                        echo '<a href="update_clients.php?id=' . $item['id_client'] . '" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                        echo ' ';
                        echo '<a href="delete_clients.php?id=' . $item['id_client'] . '" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                            echo '</td>';
                        echo '</tr>';
                    }
                    Database::disconnect();
                ?>
            </tbody>
        </table>


    </div>
    </div>


    </body>
</html>