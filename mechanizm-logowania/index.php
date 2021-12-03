<?php

   session_start(); 
    if((isset($_SESSION['userlogged'])) && ($_SESSION['userlogged'] == true))
    {
        header('Location: main-page.php');
        exit();
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

    Mechanizm logowania i rejestracji</br></br>

    <a href="registration.php">rejestracja</a>
    </br></br>

    <form action="login.php" method="post">
        Login:</br> <input type="text" name="login" /></br>
        Hasło:</br> <input type="password" name="password" /></br></br>
        <input type="submit" value="Zaloguj się"/>
    </form>

<?php
    if(isset($_SESSION['error'])) echo $_SESSION['error'];
?>

</body>
</html>