<?php
// on commence une session
session_start();
//si il n'y a pas de session username setter (un utilisateur conecter) on retourne a la page login 
if (!isset($_SESSION["username"])) {
    // on retourne a la page login
    header("Location:login.php");
}
//on cree un nouveau tableau nommee data 
$data = [
    ["id" => 1, "Nom" => "Yolo", "Prénom" => "Swag", "Mail" => "yolo@swag.fr", "Code Postal" => "13006"],
    ["id" => 2, "Nom" => "Yala", "Prénom" => "Swog", "Mail" => "yala@swog.com", "Code Postal" => "06000"],
    ["id" => 3, "Nom" => "Yili", "Prénom" => "Swog", "Mail" => "yala@swog.com", "Code Postal" => "06000"],
    ["id" => 4, "Nom" => "Yulu", "Prénom" => "Swog", "Mail" => "yala@swog.com", "Code Postal" => "06000"],
    ["id" => 5, "Nom" => "Yyly", "Prénom" => "Swog", "Mail" => "yala@swog.com", "Code Postal" => "06000"],
];

// si  une session appeller data ( notre tableau quoi ) n'est pas setter ( si elle n'existe pas)
if (!isset($_SESSION["data"])) {
    // on cree une session data ( on cree notre tableau dans la session )
    $_SESSION["data"] = $data;
}

if (isset($_POST["newValue"])) {
    if (!empty($_POST["Enom"]) && !empty($_POST["Eprenom"]) && !empty($_POST["Email"] && !empty($_POST["EcodePostale"]))) {
        $IDnewb = count($_SESSION["data"])-1;
        $IDnew = $_SESSION["data"][$IDnewb]["id"];
            array_push($_SESSION["data"], [
                "id" => ($IDnew + 1),
                "Nom" => $_POST["Enom"],
                "Prénom" => $_POST["Eprenom"],
                "Mail" => $_POST["Email"],
                "Code Postal" => $_POST["EcodePostale"]
            ]);
    } else {
        echo "veuillez remplir correctement les champs";
    }
}

// si un bouton d'un formulaire en "POST" nommee "confirm" à etait cliquer
if (isset($_POST["confirm"])) {
    // la variable session[data]( notre tableau stocker dans la session)a la position stocker (index) dans notre bouton "confirm"
    $_SESSION["data"][$_POST["confirm"]] = [
        // on remplace la ligne par les info de nos input POST corespondant , sauf l'id qu'on recupere a la position de l'ancienne ligne
        "id" => $_SESSION["data"][$_POST["confirm"]]["id"],
        "Nom" => $_POST["nom"],
        "Prénom" => $_POST["prenom"],
        "Mail" => $_POST["mail"],
        "Code Postal" => $_POST["codePostal"]
    ];
}
// si on clique sur un bouton nommee delete
else if (isset($_POST["delete"])) {
    // on detruit la ligne qui corespon dans notre tableau de session a la ligne ( index ) stocker dans le bouton delete 
    unset($_SESSION["data"][$_POST["delete"]]);
}
//  si on clique sur un bouton nommee disconnect
else if (isset($_POST["disconnect"])) {
    // on detruit la session en cours
    session_destroy();
    // et on redirige vers les page login
    header("Location:login.php");
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
<header>
    <form method="post">
        <button name="disconnect">Déconnexion</button>
</header>

<body>


    <div class="inputNew">
        <input type="text" name="Enom" placeholder="entrer un nom">
        <input type="text" name="Eprenom" placeholder="entrer un prénom">
        <input type="mail" name="Email" placeholder="entrer un mail">
        <input type="number" name="EcodePostale" placeholder="entrer un code postal">
        <button name="newValue">Valider</button>
    </div>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Mail</th>
            <th>Code Postal</th>
            <th>Actions</th>
        </tr>
        <!-- on parcours notre tableau data dans la session  -->
        <?php foreach ($_SESSION["data"] as $index => $value) { ?>
            <tr>
                <!-- si le bouton nommee update est setter ( si on a cliquer dessus ) et si ce bouton a une valeur egal a l'id de la ligne -->
                <?php if (isset($_POST["update"]) && $_POST["update"] == $value["id"]) { ?>
                    <!-- alors la ligne avec le meme id transform le tableau en input  -->
                    <td><input name="nom" value="<?php echo $value["Nom"] ?>" /></td>
                    <td><input name="prenom" value="<?= $value["Prénom"] ?>" /></td>
                    <td><input name="mail" value="<?= $value["Mail"] ?>" /></td>
                    <td><input name="codePostal" value="<?= $value["Code Postal"] ?>" /></td>
                    <td>
                        <!--un bouton nommee confirm avec comme valeur l'index de la ligne   -->
                        <button name="confirm" value="<?php echo $index ?>">Confirmer</button>
                        <!--on reouvre et referme les balises php pour le else  -->
                    <?php } else { ?>
                        <!-- on affiche le tableau avec les valeurs du tableau data dans la session  -->
                    <td><?= $value["Nom"] ?></td>
                    <td><?= $value["Prénom"] ?></td>
                    <td><?= $value["Mail"] ?></td>
                    <td><?= $value["Code Postal"] ?></td>
                    <td>
                        <!-- un bouton nommee update avec comme valeur l'id de la ligne -->
                        <button name="update" value="<?php echo $value["id"] ?>">Modifier</button>
                        <!-- on reouvre et referme php pour ferme la braquette  -->
                    <?php } ?>
                    <!-- un bouton nommee delete avec comme valeur l'index de la ligne  -->
                    <button name="delete" value="<?php echo $index ?>">Supprimer</button>
                    </td>
            </tr>
            <!-- on reouvre et referme php pour fermer la braquette  -->
        <?php } ?>
    </table>
    </form>
</body>

</html>