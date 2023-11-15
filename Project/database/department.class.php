<?php
  declare(strict_types = 1);

  class Department {
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    { 
      $this->id = $id;
      $this->name = $name;
    }

    static function getDepartments(PDO $db, int $count) : array {
      $stmt = $db->prepare('SELECT id, name FROM Department LIMIT ?');
      $stmt->execute(array($count));
  
      $departments = array();
      while ($department = $stmt->fetch()) {
        $departments[] = new Department(
          intval($department['id']),
          $department['name']
        );
      }
  
      return $departments;
    }

    static function getAll(PDO $db){
      $stmt = $db->prepare('
        SELECT id, name
        FROM Department
        ORDER by name ASC
      ');

      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }

    static function getDepartmentsWithinRange(PDO $db, int $startId, int $endId) : array {
      $stmt = $db->prepare('SELECT id, name FROM Department WHERE id BETWEEN ? AND ?');
      $stmt->execute(array($startId, $endId));

      $departments = array();
      while ($department = $stmt->fetch()) {
          $departments[] = new Department(
              intval($department['id']),
              $department['name']
          );
      }

      return $departments;
  }

  static function getTotalDepartments(PDO $db): int {
    $stmt = $db->query('SELECT COUNT(*) as total FROM Department');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return intval($result['total']);
  }


  static function drawPagination($currentPage, $perPage, PDO $db) {
    $totalDepartments = Department::getTotalDepartments($db);
    $totalPages = ceil($totalDepartments / $perPage);

    echo '<div class="pagination">';
    if ($currentPage > 1) {
        echo '<a href="?page=' . ($currentPage - 1) . '">Previous</a>';
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a href="?page=' . $i . '"';
        if ($i === $currentPage) {
            echo ' class="active"';
        }
        echo '>' . $i . '</a>';
    }
    if ($currentPage < $totalPages) {
        echo '<a href="?page=' . ($currentPage + 1) . '">Next</a>';
    }
    echo '</div>';
  }

    static function searchDepartments(PDO $db, string $search, int $count) : array {
      $stmt = $db->prepare('SELECT id, name FROM Department WHERE name LIKE ? LIMIT ?');
      $stmt->execute(array($search . '%', $count));
  
      $departments = array();
      while ($department = $stmt->fetch()) {
        $departments[] = new Department(
          intval($department['id']),
          $department['name']
        );
      }
  
      return $departments;
    }

    static function getDepartment(PDO $db, int $id) : Department {
      $stmt = $db->prepare('SELECT id, name FROM Department WHERE id = ?');
      $stmt->execute(array($id));
  
      $department = $stmt->fetch();
  
      return new Department(
        intval($department['id']), 
        $department['name']
      );
    }  

    static function create(PDO $db, string $name) : int {

      $sql = "INSERT INTO Department (name) VALUES (:name)";
      $stmt= $db->prepare($sql);
      $stmt->bindValue('name', $name, PDO::PARAM_STR);
      $stmt->execute();
      
      //Return new Department id
      $sql = "SELECT id from Department ORDER BY ID DESC LIMIT 1";
      $stmt= $db->prepare($sql);
      $stmt->execute();
      $id = $stmt->fetch();
      return intval($id['id']);
    }

    static function getDepartName(PDO $db, $departmentId) {
          $stmt = $db->prepare('SELECT name FROM Department WHERE id = :id');
          $stmt->bindValue(':id', $departmentId, PDO::PARAM_INT);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return $result['name'];
      }

    static function getName($id) {
      global $dbh;
      try {
        $stmt = $dbh->prepare('SELECT name FROM Department WHERE id = ?');
        $stmt->execute(array($id));
        if($row = $stmt->fetch()){
          return $row['name'];
        }
      
      }catch(PDOException $e) {
        return -1;
      }
    }

    static function getAllAgentsDepartment(PDO $db, $departmentId) {
      $stmt = $db->prepare('
          SELECT *
          FROM User
          WHERE is_agent = true AND id_department = :departmentId
      ');
  
      $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
      $stmt->execute();
      $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $agents;
  }  

  }
  
?>