<?php
namespace Classes;

use PDO;

class Category {

    private int $id;    
    public string $name;

    public function __construct(string $name) {

        $this->name = $name;

        $this->register();
    }


    private function register() {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $query = 'INSERT INTO categories (name) VALUES (:name)';
        
        $stmt = $db->prepare($query);
        $stmt->bindValue(':name', $this->name);

        $stmt->execute();

        $this->getIDFromDB();
    }

    private function getIDFromDB() {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $query = 'SELECT id FROM categories WHERE name = :name';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':name', $this->name);

        $stmt->execute();

        $this->id = $stmt->fetch()['id'];
    }

    public function delete(int $id) {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $query = 'DELETE FROM categories WHERE id = :id';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id);

        $stmt->execute();
    }
}