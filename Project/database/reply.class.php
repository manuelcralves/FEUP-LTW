<?php
  declare(strict_types = 1);

  class Reply {
    public int $id;
    public int $id_ticket;
    public datetime $created_at;
    public string $content;
    public int $id_user;

    public function __construct(int $id, int $id_ticket, datetime $created_at, string $content, int $id_user)
    {

        $this->id = $id;
        $this->id_ticket = $id_ticket;
        $this->created_at = $created_at;
        $this->content = $content;
        $this->id_user = $id_user;
    }

    static function get(int $id) : Reply {
        global $dbh;
        $stmt = $dbh->prepare('
          SELECT id, id_ticket, created_at, content, id_user
          FROM Reply 
          WHERE id = ?
        ');
  
        $stmt->execute(array($id));
        $reply = $stmt->fetch();
        
        return new Reply(
          $reply['id'],
          $reply['id_ticket'],
          $reply['created_at'],
          $reply['content'],
          $reply['id_user'],
        );
    }

    static function getRepliesByTicket(PDO $db, int $id_ticket) {
        $stmt = $db->prepare('
          SELECT id, created_at, content, id_user
          FROM Reply 
          WHERE id_ticket = ?
          ORDER by created_at asc
        ');
  
        $stmt->execute(array($id_ticket));
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
      }

      static function create(PDO $db, int $id_ticket, string $content, int $id_user) : int {

        $sql = "INSERT INTO Reply (id_ticket, id_user) VALUES (:id_ticket, :id_user)";
        $stmt= $db->prepare($sql);
        $stmt->bindValue('id_ticket', $id_ticket, PDO::PARAM_STR);
        $stmt->bindValue('content', $content, PDO::PARAM_INT);
        $stmt->bindValue('id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
                
        //Return new reply id
        $sql = "SELECT id from Reply ORDER BY ID DESC LIMIT 1";
        $stmt= $db->prepare($sql);
        $stmt->execute();
        $id = $stmt->fetch();
        return intval($id['id']);
      }

      static function replyClient($ticketId, $userId, $replyText) {
    
            try {
                global $dbh;
                // Prepare and execute the update statement
                $stmt = $dbh->prepare('INSERT INTO Reply (id_ticket, id_user, content) VALUES (:ticketId, :userId, :replyText)');
                $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':replyText', $replyText, PDO::PARAM_STR);
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
      }
    }
?>