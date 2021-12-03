<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" 
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" 
        crossorigin="anonymous"/>
        <link rel="stylesheet" href="style.css">
        <title>Sliding Sign In & Sign Up Form</title>
    </head>

    <body>
        <div class="div">
            <?php
                if(isset($_SESSION["userid"]))
            ?>
            <li><a href="#"><?php echo isset($_SESSION["userid"]) ? $_SESSION["userid"] : ''; ?></a></li>
        </div>
        <div class="container" id="container">
            <div class="form-container sign-up-container">
                <form action="includes/signup.inc.php" method="post">
                    <h1>Create Account</h1>
                    <div class="social-container">
                        <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <span>or use your email for registration</span>
                    <input type="text" name="uid" placeholder="Username" />
                    <input type="password" name="pwd" placeholder="Password" />
                    <input type="password" name="pwdRepeat" placeholder="Repeat Password" />
                    <input type="email" name="email" placeholder="E-mail" />
                    <button type="submit" name="submit">Sign Up</button>
                </form>
            </div>

            <div class="form-container sign-in-container">
                <form action="includes/login.inc.php" method="post">
                    <h1>Sign In</h1>
                    <div class="social-container">
                        <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <span>or use your account</span>
                    <input type="text" name="uid" placeholder="Username" />
                    <input type="password" name="pwd" placeholder="Password" />
                    <a href="#">Forgot your password?</a>
                    <button type="submit" name="submit">Sign In</button>
                </form>
            </div>

            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please login with your personal info</p>
                        <button class="ghost" id="signIn">Sign In</button>
                    </div>

                    <div class="overlay-panel overlay-right">
                        <h1>Hello, Friend!</h1>
                        <p>Enter your personal details and start journey with us</p>
                        <button class="ghost" id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="main.js"></script>
    </body>
</html>