<?php
  declare(strict_types = 1);

  class Ticket {
    public int $id;
    public string $title;
    public string $description;
    public string $ticket_status;
    public datetime $created_at;
    public datetime $updated_at;
    public int $id_user;
    public int $id_agent;
    public int $id_department;
    public array $hashtags;
    
    public function __construct(int $id, string $title, string $description, string $ticket_status, datetime $created_at, datetime $updated_at, int $id_user, int $id_agent, int $id_department, array $hashtags)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->ticket_status = $ticket_status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->id_user = $id_user;
        $this->id_agent = $id_agent;
        $this->id_department = $id_department;
        $this->hashtags = $hashtags;
    }

    function edit($db) {
      $stmt = $db->prepare('
        UPDATE Ticket SET id_department = ?, title = ?, description = ?, ticket_status = ?, updated_at = ?
        WHERE id = ?
      ');

      $stmt->execute(array($this->id_department, $this->title, $this->description, $this->ticket_status, $this->updated_at, $this->id));
    }
    
    
    static function get(int $id) : Ticket {
      global $dbh;
      $stmt = $dbh->prepare('
        SELECT id, title, description, ticket_status, created_at, updated_at, id_user, id_agent, id_department
        FROM Ticket 
        WHERE id = ?
      ');

      $stmt->execute(array($id));
      $ticket = $stmt->fetch();
      
      return new Ticket(
        $ticket['id'],
        $ticket['title'],
        $ticket['description'],
        $ticket['ticket_status'],
        $ticket['created_at'],
        $ticket['udpated_at'],
        $ticket['id_user'],
        $ticket['id_agent'],
        $ticket['id_department'],
        $ticket['hashtags']
      );
    }

    public static function filterByStatus($dbh, $departmentId, $status) {
      $stmt = $dbh->prepare("SELECT * FROM Ticket WHERE id_department = :departmentId AND ticket_status = :status");
      $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
      $stmt->bindParam(':status', $status, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  

    static function getAll(PDO $db){
      $stmt = $db->prepare('
        SELECT id, title, description, id_department, ticket_status
        FROM Ticket 
        ORDER by updated_at desc
      ');

      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }

    static function getTicketsbyUser(PDO $db, int $id_user){
      $stmt = $db->prepare('
        SELECT id, title, description, id_department, ticket_status
        FROM Ticket 
        WHERE id_user = ?
        ORDER by updated_at desc
      ');

      $stmt->execute(array($id_user));
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }

    static function getTicketsbyDepartment(PDO $db, int $id_department) {
      $stmt = $db->prepare('
        SELECT id, title, description, ticket_status
        FROM Ticket 
        WHERE id_department = ?
        ORDER by updated_at desc
      ');

      $stmt->execute(array($id_department));
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $row;
    }

    static function delete(PDO $db, int $id) {
      $stmt = $db->prepare('
        DELETE 
        FROM Ticket 
        WHERE id = ?
      ');

      $stmt->execute(array($id));
    }

    static function create(PDO $db, string $id_department, string $title, string $description, int $id_user, array $hashtags) : int {
      // Insert the ticket into the Ticket table
      $sql = "INSERT INTO Ticket (title, description, id_department, id_user) VALUES (:title, :description, :id_department, :id_user)";
      $stmt= $db->prepare($sql);
      $stmt->bindValue('title', $title, PDO::PARAM_STR);
      $stmt->bindValue('description', $description, PDO::PARAM_STR);
      $stmt->bindValue('id_department', $id_department, PDO::PARAM_INT);
      $stmt->bindValue('id_user', $id_user, PDO::PARAM_INT);
      $stmt->execute();
    
      // Get the newly inserted ticket id
      $ticketId = (int)$db->lastInsertId();
    
      // Insert the hashtags into the Ticket_Hashtag table
      $sql = "INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (:ticketId, :hashtagId)";
      $stmt = $db->prepare($sql);
      foreach ($hashtags as $hashtag) {
        $hashtagId = self::getHashtagId($db, $hashtag); // Get the hashtag id from the Hashtag table
        $stmt->bindValue('ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->bindValue('hashtagId', $hashtagId, PDO::PARAM_INT);
        $stmt->execute();
      }
    
      return $ticketId;
    }
    
    static function getHashtagId(PDO $db, string $hashtag): int {
      // Check if the hashtag already exists in the Hashtag table
      $sql = "SELECT id FROM Hashtag WHERE tag = :hashtag";
      $stmt = $db->prepare($sql);
      $stmt->bindValue('hashtag', $hashtag, PDO::PARAM_STR);
      $stmt->execute();
    
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        // Hashtag exists, return the existing id
        return intval($result['id']);
      } else {
        // Hashtag does not exist, insert it into the Hashtag table and return the new id
        $sql = "INSERT INTO Hashtag (tag) VALUES (:hashtag)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue('hashtag', $hashtag, PDO::PARAM_STR);
        $stmt->execute();
    
        return intval($db->lastInsertId());
      }
    }
    

    static function getTicket(int $id) {
      global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT id, title, description, ticket_status, id_department, id_agent, id_user, created_at FROM Ticket WHERE id = ?');
      $stmt->execute(array($id));
      return $stmt->fetch();
    
    }catch(PDOException $e) {
      return null;
    }
    }  
  
  static function updateTicketAgent($ticketId, $agentId, $assig) {
    $userAgent = isAgent(getUserID());

    if ($userAgent) {
        try {
            global $dbh;

            // Check if the agent ID exists in the User table
            $agentExistsStmt = $dbh->prepare('SELECT COUNT(*) FROM User WHERE id = :agentId');
            $agentExistsStmt->bindParam(':agentId', $agentId, PDO::PARAM_INT);
            $agentExistsStmt->execute();
            $agentExists = $agentExistsStmt->fetchColumn();

            if ($agentExists) {
                // Prepare and execute the update statement
                $stmt = $dbh->prepare('UPDATE Ticket SET id_agent = :agentId, ticket_status = :assig WHERE id = :ticketId');
                $stmt->bindParam(':agentId', $agentId, PDO::PARAM_INT);
                $stmt->bindParam(':assig', $assig, PDO::PARAM_STR);
                $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
                $stmt->execute();

                // Check if the update was successful
                if ($stmt->rowCount() > 0) {
                    return true; // Ticket agent updated successfully
                } else {
                    return false; // No ticket found with the given ID
                }
            } else {
                return false; // Agent ID does not exist in the User table
            }
        } catch (PDOException $e) {
            echo 'Error updating ticket agent: ' . $e->getMessage();
            return false; // An error occurred while updating the ticket agent
        }
    } else {
        echo 'Only agents can update ticket agents.';
        return false; // User is not an agent
    }
}

static function updateTicketDepartment($ticketId, $newDepartmentId) {
  $userAgent = isAgent(getUserID());

  if ($userAgent) {
      try {
          global $dbh;

          // Prepare and execute the update statement
          $stmt = $dbh->prepare('UPDATE Ticket SET id_department = :newDepartmentId, id_agent = NULL WHERE id = :ticketId');
          $stmt->bindParam(':newDepartmentId', $newDepartmentId, PDO::PARAM_INT);
          $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
          $stmt->execute();

          // Check if the update was successful
          if ($stmt->rowCount() > 0) {
              return true; // Ticket department updated successfully
          } else {
              return false; // No ticket found with the given ID
          }
      } catch (PDOException $e) {
          echo 'Error updating ticket department: ' . $e->getMessage();
          return false; // An error occurred while updating the ticket department
      }
  } else {
      echo 'Only agents can update ticket departments.';
      return false; // User is not an agent
  }
}

static function closeTicket($ticketId, $assig) {
  $userAgent = isAgent(getUserID());

  if ($userAgent) {
      try {
          global $dbh;
          // Prepare and execute the update statement
          $stmt = $dbh->prepare('UPDATE Ticket SET ticket_status = :assig WHERE id = :ticketId');
          $stmt->bindParam(':assig', $assig, PDO::PARAM_STR);
          $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
          $stmt->execute();

          // Check if the update was successful
          if ($stmt->rowCount() > 0) {
              return true; // Ticket agent updated successfully
          } else {
              return false; // No ticket found with the given ID
          }
        
      } catch (PDOException $e) {
          echo 'Error updating ticket status: ' . $e->getMessage();
          return false; // An error occurred while updating the ticket agent
      }
  } else {
      echo 'Only agents can update ticket agents.';
      return false; // User is not an agent
  }
}

static function reopenTicket($ticketId, $assig) {
  $userAgent = isAgent(getUserID());

  if ($userAgent) {
      try {
          global $dbh;
          // Prepare and execute the update statement
          $stmt = $dbh->prepare('UPDATE Ticket SET ticket_status = :assig WHERE id = :ticketId');
          $stmt->bindParam(':assig', $assig, PDO::PARAM_STR);
          $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
          $stmt->execute();

          // Check if the update was successful
          if ($stmt->rowCount() > 0) {
              return true; // Ticket agent updated successfully
          } else {
              return false; // No ticket found with the given ID
          }
        
      } catch (PDOException $e) {
          echo 'Error updating ticket status: ' . $e->getMessage();
          return false; // An error occurred while updating the ticket agent
      }
  } else {
      echo 'Only agents can update ticket agents.';
      return false; // User is not an agent
  }
}

public static function filterByHashtag($dbh, $id, $hashtagId) {
  // Prepare the SQL statement to retrieve tickets based on hashtag ID
  $stmt = $dbh->prepare("
    SELECT t.*
    FROM Ticket t
    INNER JOIN Ticket_Hashtag th ON t.id = th.id_ticket
    WHERE t.id_department = :id AND th.id_hashtag = :hashtag_id
  ");

  // Bind the parameters
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->bindParam(':hashtag_id', $hashtagId, PDO::PARAM_INT);

  // Execute the query
  $stmt->execute();

  // Fetch the matching tickets as an associative array
  $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Return the tickets
  return $tickets;
}

static function getTicketsWithoutAgent(PDO $db, int $id_department){
  $stmt = $db->prepare('
    SELECT id, title, description, id_department, id_agent
    FROM Ticket
    WHERE id_department = ? AND id_agent IS NULL
    ORDER by updated_at desc
  ');

  $stmt->execute(array($id_department));
  $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $row;
}

static function getTicketsAgent(PDO $db, int $id_agent){
  $stmt = $db->prepare('
    SELECT id, title, description, id_department, ticket_status
    FROM Ticket
    WHERE id_agent = ?
    ORDER by updated_at desc
  ');

  $stmt->execute(array($id_agent));
  $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $row;
}

static function getTicketHashtags(PDO $db, int $ticketId) {
  $query = "SELECT h.tag
            FROM Ticket_Hashtag th
            JOIN Hashtag h ON th.id_hashtag = h.id
            WHERE th.id_ticket = :ticketId";
            
  $stmt = $db->prepare($query);
  $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
  $stmt->execute();
  
  $hashtags = $stmt->fetchAll(PDO::FETCH_COLUMN);
  
  return $hashtags;
}

  }
?>