<?php
  declare(strict_types = 1);

  class Faq {
    public int $id;
    public string $title;
    public string $description;
    
    public function __construct(int $id, string $title, string $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    static function getAll(PDO $db){
      $stmt = $db->prepare('
        SELECT id, title, description
        FROM Faq 
        ORDER by id asc
      ');

      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }

    static function create(PDO $db, string $title, string $description) : int {

      $sql = "INSERT INTO Faq (title, description) VALUES (:title, :description)";
      $stmt= $db->prepare($sql);
      $stmt->bindValue('title', $title, PDO::PARAM_STR);
      $stmt->bindValue('description', $description, PDO::PARAM_STR);
      $stmt->execute();
      
      //Return new faq id
      $sql = "SELECT id from Faq ORDER BY ID DESC LIMIT 1";
      $stmt= $db->prepare($sql);
      $stmt->execute();
      $id = $stmt->fetch();
      return intval($id['id']);
    }
  }
?>