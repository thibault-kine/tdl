<?php

$pdo = new PDO('mysql:host=localhost;dbname=tdl', 'root', '');


// === INSCRIPTION === // 
if(!empty($_POST) && $_SERVER['REQUEST_URI'] == '/tdl/app/inscription.php') {
    $user = [
        'fname' => $_POST['fname'],
        'name' => $_POST['name'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'password2' => $_POST['password2']
    ];

    if($user['password'] != $user['password2']) {
        echo '<div class="err-msg">Les mots de passe ne correspondent pas</div>';
    } else {
        $sql = $pdo->exec('INSERT INTO users (firstname, lastname, username, password, rights) VALUES ('. $user['fname'] .', '. $user['name'] .', '. $user['username'] .', '. $user['password'] .', 0)');
        
        if($sql) {
            echo '<div class="success">Inscription réussie !</div>';
        }
    }
} 

// === CONNEXION === //
if(!empty($_POST) && $_SERVER['REQUEST_URI'] == '/tdl/app/connexion.php') {
    $user = [
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ];

    $sql = $pdo->query('SELECT * FROM users WHERE username = "' . $user['username'] . '"');
    
    if($sql) {
        $_SESSION['user'] = $sql->fetch();
        echo '<div class="success">Connexion réussie !</div>';
        session_start();
    } else {
        echo '<div class="err-msg">Utilisateur inconnu</div>';
    }
}