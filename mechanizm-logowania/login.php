<?php

    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['password'])))
    {
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";
    
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno != 0)
    {
        echo "Error: ".$connection->connect_errno;
    }
    else
    {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        //$password = htmlentities($password, ENT_QUOTES, "UTF-8");

        if($result = @$connection->query(sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
        mysqli_real_escape_string($connection,$login))))
        //mysqli_real_escape_string($connection,$password))))
        {
            $users_number = $result->num_rows;
            if($users_number > 0)
            {
                $line = $result->fetch_assoc();
                
                if (password_verify($password, $line['pass']))
                {
                    $_SESSION['userlogged'] = true;
                
                    $_SESSION['id'] = $line['id'];
                    $_SESSION['user'] = $line['user'];
                    $_SESSION['drewno'] = $line['udrewnoser'];
                    $_SESSION['kamien'] = $line['kamien'];
                    $_SESSION['zboze'] = $line['zboze'];
                    $_SESSION['email'] = $line['email'];
                    $_SESSION['dnipremium'] = $line['dnipremium'];

                    unset($_SESSION['error']);
                    $result->close();

                    header('Location: main-page.php');
                }
                else
                {
                    $_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                    header('location: index.php');  
                }
            }
            else
            {
                $_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                header('location: index.php');
            }
        }

        $connection->close();
    }   

?>