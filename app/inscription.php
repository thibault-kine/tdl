<?php
include_once '../include/header.php';
?>

<form method="post" id="sign-in-form">
    <label for="fname">Prénom: </label>
    <input type="text" name="fname" id="fname" required/>

    <label for="name">Nom: </label>
    <input type="text" name="name" id="name" required>
    
    <label for="username">Nom d'utilisateur: </label>
    <input type="text" name="username" id="username" required>

    <label for="password">Mot de passe: </label>
    <input type="password" name="password" id="password" required>

    <label for="password2">Confirmation du mot de passe: </label>
    <input type="password" name="password2" id="password2" required>

    <input type="submit" value="S'inscrire">
</form>

<div class="msg"></div>

<?php
// include_once '../include/footer.php';

?>