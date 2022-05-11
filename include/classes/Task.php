<?php
namespace Classes;

use PDO;

class Task {

    private int $id;
    public string $title;
    public string $description;
    public string $creationDate;
    public string $dueDate;
    public int $userID;
    public int $categID;
    public bool $isFinished;


    public function __construct(string $title, string $description, string $creationDate, string $dueDate, int $userID, int $categID, ?bool $isFinished = false) {
    
        $this->title = $title;
        $this->description = $description;
        $this->creationDate = $creationDate;
        $this->dueDate = $dueDate;
        $this->userID = $userID;
        $this->categID = $categID;
        $this->isFinished = $isFinished;

        $this->register();
    }


    private function register() {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $query = 'INSERT INTO tasks (title, description, creationDate, dueDate, userID, categID, isFinished) VALUES (:title, :description, :creationDate, :dueDate, :userID, :categID, :isFinished)';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':title', $this->title);
        $stmt->bindValue(':description', $this->description);
        $stmt->bindValue(':creationDate', $this->creationDate);
        $stmt->bindValue(':dueDate', $this->dueDate);
        $stmt->bindValue(':userID', $this->userID);
        $stmt->bindValue(':categID', $this->categID);
        $stmt->bindValue(':isFinished', $this->isFinished);

        $stmt->execute();

        $this->getIDFromDB();
    }

    private function getIDFromDB() {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $query = 'SELECT id FROM tasks WHERE title = :title AND userID = :userID';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':title', $this->title);
        $stmt->bindValue(':userID', $this->userID);

        $stmt->execute();

        $this->id = $stmt->fetch()['id'];
    }

    public function update(string $field, mixed $value) {

        $db = new PDO(
            'mysql:host=localhost;dbname=tdl;charset=utf8',
            'root',
            ''
        );
        $query = 'UPDATE tasks SET ' . $field . ' = :value WHERE id = :id';
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
        $query = 'SELECT * FROM tasks WHERE id = :id';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $this->id);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function updateAll(array $fields) {

        $data = $this->selectAll($this->id);

        foreach ($fields as $field => $value) {
            if($data[$field] != $value) {
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
        $query = 'DELETE FROM tasks WHERE id = :id';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':id', $id);

        $stmt->execute();
    }
}