<?php
    session_start();
    // 
    $error="";
    // 
    if(isset($_POST["username"])){
        // 
        if(preg_match("/^[A-z]*$/",$_POST["username"]) && preg_match("/^(?![\d-])[a-zA-Z0-9-]{3,16}$/",$_POST["password"])){
            // 
            $_SESSION["username"] = $_POST["username"];
            header("Location:indexbrendan.php");
            // 
            exit();
        }
        // 
        else{
            $error = "Username ou mot de passe incorrect";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <form method="post">
            <input type="text" name="username" placeholder="Your name"/>
            <input type="text" name="password" placeholder="Your password"/>
            <button>Se connecter</button>
        </form>
        <!--  -->
        <?= $error!=="" ? $error : null ?>
    </body>
</html>