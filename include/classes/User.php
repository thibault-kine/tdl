<?php
namespace Classes;

use PDO;

class User {

    private int $id;
    public string $firstname;
    public string $lastname;
    public string $username;
    public string $password;
    public string $email;
    private int $rights;

    public function __consruct(string $firstname, string $lastname, string $username, string $password, string $password2, string $email, ?int $rights = 0) {

        if($this->checkPassword($password, $password2)) {
            
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->rights = $rights;
        }
    }


    public function register() {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $sql = $db->exec("INSERT INTO users (firstname, lastname, username, password, email, rights) VALUES ('$this->firstname', '$this->lastname', '$this->username', '$this->password', '$this->email', '$this->rights')");

        if($sql) {
            echo "<div class='success'>Inscription réussie !</div>";
        }
    }

    private function getIDFromDB() {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $query = 'SELECT id FROM users WHERE username = :username';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':username', $this->username);

        $stmt->execute();

        $this->id = $stmt->fetch()['id'];
    }

    public function update(string $field, mixed $value) {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $query = 'UPDATE users SET ' . $field . ' = :value WHERE id = :id';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':value', $value);
        $stmt->bindValue(':id', $this->id);

        $stmt->execute();
    }

    public function selectAll(int $id) {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $query = 'SELECT * FROM users WHERE id = :id';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function updateAll(array $fields) {

        $data = $this->selectAll($this->id);

        foreach ($fields as $field => $value) {
            if ($data[$field] != $value) {
                $this->update($field, $value);
            }
        }
    }

    public function delete(int $id) {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $query = 'DELETE FROM users WHERE id = :id';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id);

        $stmt->execute();
    }

    public function checkPassword(string $password1, string $password2) {

        if ($password1 == $password2) {
            return true;
        } else {
            return false;
        }
    }
}