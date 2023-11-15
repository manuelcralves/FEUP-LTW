<?php
  declare(strict_types = 1);

  class Hashtag {
    public int $id;
    public string $tag;

    public function __construct(int $id, string $tag)
    { 
      $this->id = $id;
      $this->tag = $tag;
    }

    static function getAll(PDO $db){
        $stmt = $db->prepare('
          SELECT id, tag
          FROM Hashtag
        ');
  
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
      }
  }