<?php
session_start();

if (!isset($_SESSION["username"])) {
    // 
    header("Location:login.php");
}
$error = [];

try {
    $db = new PDO("mysql:host=localhost;dbname=td_cours_sql", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->beginTransaction();


    if (isset($_POST["confirm"])) {
        $id = $_POST["confirm"];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $CP = $_POST['codePostal'];
        $modifRequest = "UPDATE client SET nom='$nom', prenom='$prenom' ,Code_postal='$CP'  where id_client = '$id'";
        $db->query($modifRequest);
    }
    // 
    else if (isset($_POST["delete"])) {
        $removeRequest = "DELETE FROM client WHERE id_client=" . $_POST["delete"];
        $db->query($removeRequest);
    }
    // 
    else if (isset($_POST["disconnect"])) {
        // 
        session_destroy();
        // 
        header("Location:login.php");
    } else if (isset($_POST["newValue"])) {
        if (!empty($_POST["Enom"]) && !empty($_POST["Eprenom"]) && !empty($_POST["EcodePostale"])) {
            $nom = $_POST["Enom"];
            $prenom = $_POST["Eprenom"];
            $code_postal = $_POST['EcodePostale'];
            $addRequest = "insert into client (nom , prenom , Code_postal) values ('$nom', '$prenom' , '$code_postal')";
            $db->query($addRequest);
        } else {
            $error["add_error"] = "<p>veuillez remplir les champs</p>";
        }
    }
    $requeteSQL = "SELECT * FROM client";
    $dataDb = $db->query($requeteSQL)->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Document</title>
</head>

<body>
    <form method="post">
        <button name="disconnect">Déconnexion</button>

        <div class="inputNew">
            <input type="text" name="Enom" placeholder="entrer un nom">
            <input type="text" name="Eprenom" placeholder="entrer un prénom">
            <input type="number" name="EcodePostale" placeholder="entrer un code postal">
            <button name="newValue">Valider</button>
        </div>
        <table>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Code Postal</th>
                <th>Actions</th>
            </tr>
            <!--  -->
            <?php foreach ($dataDb as $index => $value) { ?>
                <tr>
                    <!--  -->
                    <?php if (isset($_POST["update"]) && $_POST["update"] == $value["id_client"]) { ?>
                        <!--  -->
                        <td><?php echo $value["id_client"] ?></td>
                        <td><input name="nom" value="<?php echo $value["nom"] ?>" /></td>
                        <td><input name="prenom" value="<?= $value["prenom"] ?>" /></td>
                        <td><input name="codePostal" value="<?= $value["Code_postal"] ?>" /></td>
                        <td>
                            <!--  -->
                            <button name="confirm" value="<?php echo $value["id_client"] ?>">Confirmer</button>
                            <!--  -->
                        <?php } else { ?>
                            <!--  -->
                        <td><?php echo $value["id_client"] ?></td>
                        <td><?= $value["nom"] ?></td>
                        <td><?= $value["prenom"] ?></td>
                        <td><?= $value["Code_postal"] ?></td>
                        <td>
                            <!--  -->
                            <button name="update" value="<?php echo $value["id_client"] ?>">Modifier</button>
                            <!--  -->
                        <?php } ?>
                        <!--  -->
                        <button name="delete" value="<?php echo $value["id_client"] ?>">Supprimer</button>
                        </td>
                </tr>
                <!--  -->
            <?php } ?>
        </table>
    </form>
    <?php if (isset($error["add_error"])) {
        echo $error["add_error"];
    }
    ?>
</body>

</html>