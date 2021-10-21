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

    <h1 class="text-logo"> <span class="glyphicon glyphicon-"></span> animaleries <span class="glyphicon glyphicon-"></span> </h1>
    <div class="container admin">
        <div class="row">
        <h1><strong>Liste des animaux</strong><a href="insert.php" class="btn btn-succcess btn-lg"> <span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Race</th>
                    <th>Categorie</th>
                    <th>Poids</th>
                    <th>Age</th>
                    <th>Coût</th>
                    <th>Taille</th>
                    <th>Fourrure</th>
                    <th>Actions</th>
                </tr>
            </head>
            <tbody>
                <?php
                    require 'connexion.php';
                    $db = Database::connect();
                    $statement = $db->query('SELECT * FROM animal, categorie, fourrure WHERE animal.id_categorie = categorie.id_categorie AND animal.id_fourrure = fourrure.id_fourrure ORDER BY animal.id_animal ASC;');
                    while($item = $statement->fetch())
                    {
                        echo '<tr>';
                        echo '<td>' . $item['id_animal'] . '</td>';
                        echo '<td>' . $item['nom'] . '</td>';
                        echo '<td>' . $item['race'] . '</td>';
                        echo '<td>' . $item['categorie'] . '</td>';
                        echo '<td>' . number_format((float)$item['poids'],2, '.', '') . '</td>';
                        echo '<td>' . number_format((float)$item['age'],2, '.', '') . '</td>';
                        echo '<td>' . number_format((float)$item['cout'],2, '.', '') . '</td>';
                        echo '<td>' . number_format((float)$item['taille'],2, '.', '') . '</td>';
                        echo '<td>' . $item['fourrure'] . '</td>';                     
                        echo '<td width="300">';
                        echo '<a href="view.php?id='. $item['id_animal'] . '" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                        echo ' ';
                        echo '<a href="update.php?id=' . $item['id_animal'] . '" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                        echo ' ';
                        echo '<a href="delete.php?id=' . $item['id_animal'] . '" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
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