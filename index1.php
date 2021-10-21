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
    <title>Burger Code</title>
</head>
    <body>

    <h1 class="text-logo"> <span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span> </h1>
    <div class="container admin">
        <div class="row">
        <h1><strong>Liste des items</strong><a href="insert.php" class="btn btn-succcess btn-lg"> <span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Categorie</th>
                    <th>Actions</th>
                </tr>
            </head>
            <tbody>
                <?php
                    require 'database.php';
                    $db = Database::connect();
                    $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name As category 
                    FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id ASC');
                    while($item = $statement->fetch())
                    {
                        echo '<tr>';
                        echo '<td>' . $item['name'] . '</td>';
                        echo '<td>' . $item['description'] . '</td>';
                        echo '<td>' . number_format((float)$item['price'],2, '.', '') . '</td>';
                        echo '<td>' . $item['category'] . '</td>';
                        echo '<td width="300">';
                        echo '<a href="view.php?id=' . $item['id'] . '" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                        echo ' ';
                        echo '<a href="update.php?id=' . $item['id'] . '" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                        echo ' ';
                        echo '<a href="delete.php?id=' . $item['id'] . '" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
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