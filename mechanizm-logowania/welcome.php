<?php

   session_start(); 
    if((!isset($_SESSION['registration_success'])))
    {
        header('Location: index.php');
        exit();
    }
    else
    {
        unset($_SESSION['registration_success']);
    }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <title>Mechanizm logowania</title>
</head>
<body>

    Dziękujemy za rejestrację w serwisie. Możesz już zalogować się na konto </br></br>
    <a href="login.php">Zaloguj się na swoje konto</a>
    </br></br>

</body>
</html>