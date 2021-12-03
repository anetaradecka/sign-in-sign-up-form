<?php

session_start();

if (isset($_POST['email'])) {
    //udana walidacja?
    $success = true;

    //Sprawdzamy poprawność nicka
    $nick = $_POST['nick']; //pobieramy wartość z pola do zmiennej 

    //Sprawdzamy długość nicka
    if ((strlen($nick) < 3) || (strlen($nick) > 20)) {
        $success = false;
        $_SESSION['error_nick'] = "Nick musi posiadać od 3 do 20 znaków";
    }

    if (ctype_alnum($nick) == false) {
        $success = false;
        $_SESSION['error_nick'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
    }

    //Sprawdź poprawność adresu email
    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
        $success = false;
        $_SESSION['error_email'] = "Podaj poprawny adres email";
    }

    //Sprawdź poprawność hasła
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if ((strlen($password1) < 8) || (strlen($password1) > 20)) {
        $success = false;
        $_SESSION['error_password'] = "Hasło musi posiadać od 8 do 20 znaków";
    }

    if ($password1 != $password2) {
        $success = false;
        $_SESSION['error_password'] = "Podane hasła nie są identyczne";
    }

    $password_hash = password_hash($password1, PASSWORD_DEFAULT);

    //Czy zaakceptowano regulamin?
    if (!isset($_POST['conditions'])) {
        $success = false;
        $_SESSION['error_conditions'] = "Musisz zaakceptować regulamin";
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try 
    {
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        if($connection->connect_errno != 0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            //czy e-mail już istnieje?
            $result = $connection->query("SELECT id FROM uzytkownicy WHERE email = '$email'");

            if (!$result) throw new Exception($connection->error);

            $how_many_emails = $result->num_rows;

            if($how_many_emails > 0)
            {
                $success = false;
                $_SESSION['error_email'] = "Istnieje już taki email w bazie danych";
            }

            //czy nick jest juz zarezerwowany?
            $result = $connection->query("SELECT id FROM uzytkownicy WHERE user = '$nick'");

            if (!$result) throw new Exception($connection->error);

            $how_many_nicks = $result->num_rows;

            if($how_many_nicks > 0)
            {
                $success = false;
                $_SESSION['error_nick'] = "Istnieje już użytkownik o takim nicku";
            }
            
            if ($success == true) {
                // testy zaliczone

                if ($connection->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$password_hash', '$email', 100, 100, 100, 14)"))
                {
                    $_SESSION['registration_success'] = true;
                    header('Location: welcome.php');
                }
                else
                {
                    throw new Exception($connection->error);
                }
            }

            $connection->close();
        }
        
    }
    catch(Exception $error)
    {
        echo '<span style="color: red;">Błąd serwera</span>';
        //echo '</br> informacja deweloperska: '.$error;
    }

}

?>

<!DOCTYPE HTML>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <title>Mechanizm rejestracji</title>

    <style>
        .error {
            color: red;
            margin: 10 0 10 0;
        }
    </style>
</head>

<body>

    <form method="post">

        Nickname: </br> <input type="text" name="nick" /> </br>

        <?php
        if (isset($_SESSION['error_nick'])) {
            echo '<div class="error">' . $_SESSION['error_nick'] . '</div>';
            unset($_SESSION['error_nick']);
        }
        ?>

        E-mail: </br> <input type="text" name="email" /> </br>

        <?php
        if (isset($_SESSION['error_email'])) {
            echo '<div class="error">' . $_SESSION['error_email'] . '</div>';
            unset($_SESSION['error_email']);
        }
        ?>

        Hasło: </br> <input type="password" name="password1" /> </br>

        <?php
        if (isset($_SESSION['error_password'])) {
            echo '<div class="error">' . $_SESSION['error_password'] . '</div>';
            unset($_SESSION['error_password']);
        }
        ?>

        Powtórz hasło: </br> <input type="password" name="password2" /> </br>

        <label>
            <input type="checkbox" name="conditions" /> Akceptuję regulamin
        </label>

        <?php
        if (isset($_SESSION['error_conditions'])) {
            echo '<div class="error">' . $_SESSION['error_conditions'] . '</div>';
            unset($_SESSION['error_conditions']);
        }
        ?>

        </br>

        <input type="submit" value="Zarejestruj się" />

    </form>

</body>

</html>