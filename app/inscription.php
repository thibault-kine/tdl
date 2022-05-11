<form action="connexion.php" method="post">
    <div class="field">
        <label for="name">Prénom :</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div class="field">
        <label for="lastname">Nom :</label>
        <input type="text" name="lastname" id="lastname" required>
    </div>
    <div class="field">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required>
    </div>
    <div class="field">
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div class="field">
        <label for="password_confirm">Confirmation du mot de passe :</label>
        <input type="password" name="password_confirm" id="password_confirm" required>
    </div>
    <div class="field">
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
    </div>

    <input type="submit" value="S'inscrire">
</form>

<?php
// include_once '../include/footer.php';

$user = new Classes\User(
    $_POST['name'],
    $_POST['lastname'],
    $_POST['username'],
    $_POST['password'],
    $_POST['password_confirm'],
    $_POST['email']
);

if(!isset($_SESSION['user'])) {
    $_SESSION['user'] = $user;
}
?>