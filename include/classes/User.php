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

    public function __consruct(string $firstname, string $lastname, string $username, string $password, string $email, ?int $rights = 0) {

        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->rights = $rights;

        $this->register();
    }


    private function register() {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $query = 'INSERT INTO users (firstname, lastname, username, password, email, rights) VALUES (:firstname, :lastname, :username, :password, :email, :rights)';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':firstname', $this->firstname);
        $stmt->bindValue(':lastname', $this->lastname);
        $stmt->bindValue(':username', $this->username);
        $stmt->bindValue(':password', $this->password);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':rights', $this->rights);

        $stmt->execute();

        $this->getIDFromDB();
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
}