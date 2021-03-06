<?php
require_once('identifier.php');
require_once('connexion_db.php');

$login = $_SESSION['user']['login'];
$email = $_SESSION['user']['login'];
$id = $_SESSION['utilisateur']['iduser'];

if (isset($_POST['oldpwd']))
    $oldpwd = $_POST['oldpwd'];
else
    $oldpwd = "";

if (isset($_POST['newpwd']))
    $newpwd = $_POST['newpwd'];
else
    $newpwd = "";

$dataErrors=array();

$requete = "select * from utilisateur where iduser=? and pwd=MD5(?)";

$param = array($id,$oldpwd);

$resultat = $pdo->prepare($requete);

$resultat->execute($param);

if ($user = $resultat->fetch()) {

    $id = $user['iduser'];

    $requete = "update utilisateur set pwd=MD5(?) where iduser=?";

    $param = array($newpwd,$id);

    $resultat = $pdo->prepare($requete);

    $resultat->execute($param);

} else {

    $dataErrors[] = "<strong>Erreur!</strong> L'ancien mot de passe est incorrect!!!";

    //header("Location:editPwd.php");
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Changement de mot de passe</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
    <script src="../js/jquery-3.3.1.js"></script>
    <script src="../js/myjs.js"></script>
</head>
<body>

<h1 class="text-center">Changement de mot de passe</h1>

<div class="container">
    <?php
    if(empty($dataErrors)){ ?>
        <div class="alert alert-success">
            <h3>Le Changement de votre compte est achevé avec succes</h3>
            <p>
                <label for="login" class="control-label">Login :<?php echo $login; ?></label>
            </p>
            <p>
                <label for="email" class="control-label">Email :<?php echo $email; ?></label>
            </p>
            <?php header("refresh:3;url=login.php");?>


        </div>
    <?php }
    else{
        foreach ($dataErrors as $error) {
            echo '<div class="alert alert-danger">'. $error .'</div>';
        }

        $seconds=3;

        $url=$_SERVER['HTTP_REFERER'];

        header("refresh:$seconds;url=$url");
    }?>

</div>

</body>
</html>