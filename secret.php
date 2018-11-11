<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Video anniv Juliette</title>
</head>
<body>

<?php
if (isset($_POST['mot_de_passe']) AND $_POST['mot_de_passe'] ==  "annivjuliette") // Si le mot de passe est bon
{
    // On affiche les codes
    ?>
    <h1>Voici la video à apprendre :</h1>
    <video controls src="video-1539024472.mp4"></video>

    <?php
}
else // Sinon, on affiche un message d'erreur
{
    echo '<p>Mot de passe incorrect</p>';
}
?>


</body>
</html>