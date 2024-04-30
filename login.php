<?php
session_start();

$error = "";

try {
    $db = new PDO("mysql:host=localhost;dbname=td_cours_sql", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->beginTransaction();

    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $nom = $_POST["username"];
        $password = $_POST["password"];
        $usernamePattern = "/^[a-zA-Z0-9_-]+$/";
        $passwordPattern = "/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{4,10}$/";

        if (preg_match($usernamePattern, $passwordPattern)) {
            $error = "veuillez remplir les champs avec des caracteres valides";
        } else {
            $requeteSQL = "SELECT id_client FROM client where nom='$nom' and password= '$password'";
            $dataDb = $db->query($requeteSQL)->fetchAll(PDO::FETCH_ASSOC); //<- query lance la requete ( l'eclair sur workbench) et le fetchall converti en tableau ( fetch_assoc en tableau associatif)
            if (count($dataDb) == 1) {
                $_SESSION["id"] = $dataDb[0]["id_client"];
                header("Location:indexbrendan.php");
                exit();
            } else {
                $error = "Nom ou mot de passe introuvable";
            }
        }
    }
    $db->commit();
} catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post">
        <input type="text" name="username" placeholder="Your name" />
        <input type="text" name="password" placeholder="Your password" />
        <button>Se connecter</button>
    </form>

    <?= $error !== "" ? $error : null ?>
</body>

</html>