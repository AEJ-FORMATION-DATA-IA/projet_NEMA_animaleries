<?php
    require 'connexion.php';

    $Error = $emailError = $passwordError = $email = $password = "";
    
    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

   
    if(!empty($_POST))
    {
        $email           = checkInput($_POST['email']);
        $password        = checkInput($_POST['password']);
        $isSuccess       = true;

        if(empty($email))
        {
            $emailError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
        if(empty($password))
        {
            $passwordError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }   

            if($isSuccess)

            {
                    $db = Database::connect();
                    $req= $db->prepare("SELECT * FROM users WHERE email=:email AND pass=:pass");
                    $req->execute(array(
                        "email"=>$email,
                        "pass"=>$password
                        ));                    
                        Database::disconnect();

                        $resultat = $req->fetch();

                if(!$resultat)
                    {
                        $msg=" Email et / ou Mot de passe incorrecte !";
                    }
                else
                    {
                        header("Location: liste.php");
                    }
            }
        

    }

  
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>Inscription</title>
</head>
<body>
    <class class="container">
        <class class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-5 connecter">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="text-left offset-4">Se connecter </h3>
                        <span class="help-inline"><?php echo $Error; ?></span>
                    </div>
                    <div class="col-md-6">
                    <span class="glyphicon glyphicon-pencil"></span></div>
                </div>
                <hr>
                <form action="connecter.php" role="form" method="post" class="form">
                    <div class="row">
                        <label class="label col-md-3 control-label">E-mail : </label>
                        <div class="col-md-9">
                            <input type="Email" class="form-control" name="email" placeholder="E-mail">
                            <span class="help-inline"><?php echo $emailError; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <label class="label col-md-3 control-label">Mot de pass : </label>
                        <div class="col-md-9">
                            <input type="Password" class="form-control" name="password" placeholder="Mot de pass">
                            <span class="help-inline"><?php echo $passwordError; ?></span>
                        </div>
                    </div>
                
                <input type="submit" name="envoyer" value="Se connecter" class="btn btn-info">
                <input type="cancel" name="annuler" value="Annuler" class="btn btn-warning">
            </div>
            </form>
        </class>
    </class>
</body>
</html>