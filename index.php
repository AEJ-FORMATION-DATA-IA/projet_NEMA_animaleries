<?php
    require 'connexion.php';

    $Error = $pseudoError = $emailError = $passwordError = $passError = $pseudo = $email = $password = $pass = "";
    
    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

   
    if(!empty($_POST))
    {
        $pseudo          = checkInput($_POST['pseudo']);
        $email           = checkInput($_POST['email']);
        $password        = checkInput($_POST['password']);
        $pass            = checkInput($_POST['pass']);
        $isSuccess       = true;

        if(empty($pseudo))
            {
                $pseudoError = "Ce champ ne peut pas etre vide";
                $isSuccess = false;
            }
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
        if(empty($pass))
        {
            $passError = "Ce champ ne peut pas etre vide";
            $isSuccess = false;
        }
          

        if($isSuccess)

        {
            if($password != $pass){
                $Error = "Le mot de pass et la confirmation ne doivent pas etre differents";
            }
            else{

                $db = Database::connect();
                $statement = $db->prepare("INSERT INTO users (pseudo, email, pass,date) values(?, ?, ?, NOW())");
                $statement->execute(array($pseudo,$email,$pass));
                Database::disconnect();
                $Error = "Votre compte a été crée avec succes !";
                header("Location: connecter.php");
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
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="text-left offset-4">Inscription </h3>
                        </div>
                        <div class="col-md-6">
                        <span class="glyphicon glyphicon-pencil"></span></div>
                    </div>
                    <hr>
                    <form action="index.php" role="form" method="post" class="form">
                    <div class="row">
                        <label class="label col-md-3 control-label">Pseudo : </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="pseudo" placeholder="Nom & Prenom(s)">
                            <span class="help-inline"><?php echo $pseudoError; ?></span>
                        </div>
                    </div>
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
                    <div class="row">
                        <label class="label col-md-3 control-label">Confirmation : </label>
                        <div class="col-md-9">
                            <input type="Password" class="form-control" name="pass" placeholder="Renseignez le même mot de pass">
                            <span class="help-inline"><?php echo $passError; ?></span>
                        </div>
                    </div>
                        <input type="submit" name="envoyer" value="S'inscrire" class="btn btn-info">
                        <input type="cancel" name="annuler" value="Annuler" class="btn btn-warning">
                    </div>
                </div>    
            </class>
        </class>
    </form>
</body>
</html>