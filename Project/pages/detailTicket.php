<?php


require_once(__DIR__ . '/../utils/init.php');

  if(!isset($_SESSION['username'])){
    header("Location:/index.php");
  }
require_once(__DIR__ . '/../templates/header.tpl.php');
require_once(__DIR__ . '/../templates/footer.tpl.php');
include_once("../database/ticket.class.php");
include_once("../database/department.class.php");
include_once("../database/user.class.php");
include_once("../database/reply.class.php");

$_SESSION['ticketinfo'] = Ticket::getTicket(intval($_GET['id']));
$depart = Department::getName($_SESSION['ticketinfo']['id_department']);
$replies = Reply::getRepliesByTicket($dbh, intval($_SESSION['ticketinfo']['id']));
$us = getUserna($_SESSION['ticketinfo']['id_user']);
$ag = getUserna($_SESSION['ticketinfo']['id_agent']);
$_SESSION['userinfo'] = getUser($_SESSION['username']);

$ticketId = $_SESSION['ticketinfo']['id'];
$hashtags = Ticket::getTicketHashtags($dbh, intval($ticketId));


drawHeader();

?>

<h1><?php echo htmlentities($_SESSION['ticketinfo']['title']) ?></h1>

<h2>Ticket Information</h2>

<ul>
    <li>Client: <?php echo htmlentities($us) ?></li>
    <li>Status: <?php echo htmlentities($_SESSION['ticketinfo']['ticket_status']) ?></li>
    <li>Department: <?php echo htmlentities($depart) ?></li>
    <li>Assigned to: <?php echo ($ag == null) ? htmlentities("This ticket has no agent working on it") : htmlentities($ag); ?></li>
    <li>Created at: <?php echo htmlentities($_SESSION['ticketinfo']['created_at']) ?></li>
    <li>Hashtags: <?php foreach ($hashtags as $hashtag): ?>
    <span class="hashtag"><?php echo htmlentities($hashtag); ?>&nbsp;</span>
    
    <?php endforeach; ?></li>
</ul>
<br>
<hr>
<br>

<?php

if (($_SESSION['ticketinfo']['id_agent'] == getUserID() || isAdmin(getUserID())) && $_SESSION['ticketinfo']['ticket_status'] != 'Closed') {
    // Display the dropdown list of departments
    $departments = Department::getAll($dbh);

    echo '<label>Change ticket department:</label>';
    echo '<select id="departmentSelect">';
    foreach ($departments as $department) {
        echo '<option value="' . $department['id'] . '" ' . ($department['name'] == $depart ? 'selected' : ''). '>';
        echo $department['name'];
        echo '</option>';
    }
    echo '</select>';
    echo '<button onclick=updateDepartment()>Change Department</button><br><br>';
}

// Check if the ticket has no assigned agent and the user is an agent
if ((($_SESSION['ticketinfo']['id_department'] == $_SESSION['userinfo']['id_department'] && isAgent(getUserID())) || isAdmin(getUserID())) && $_SESSION['ticketinfo']['ticket_status'] != 'Closed') {
    echo '<label>Assign Ticket to:</label>';
    echo '<select id="agentDropdown">';
    
    // Assuming you have a PDO database connection established ($db)
    $agents = Department::getAllAgentsDepartment($dbh, $_SESSION['ticketinfo']['id_department']);
    
    foreach ($agents as $agent) {
        echo '<option value="' . $agent['id'] . '">' . $agent['username'] . '</option>';
    }
    
    echo '</select>';
    echo '<button onclick="assignTicket()">Assign Ticket</button><hr><br>';
}

?>

<br>
<?php
if (($_SESSION['ticketinfo']['id_agent'] == getUserID() || isAdmin(getUserID())) && $_SESSION['ticketinfo']['ticket_status'] != 'Closed') {
    echo '<button onclick="closeTicket()">Close this Ticket</button><hr />';
}else if (($_SESSION['ticketinfo']['id_agent'] == getUserID() || isAdmin(getUserID())) && $_SESSION['ticketinfo']['ticket_status'] == 'Closed'){
    echo '<button onclick="reopenTicket()">Reopen this Ticket</button><hr />';
}
?>

<br>

<h2>Ticket Details</h2>

<div style="padding: 20px; background: #eee; border: 1px solid #ccc; margin-bottom:10px;">
<h3 style="margin-top: 0"><?php echo htmlentities($us); ?> <span style="font-style: italic; font-size: 10px; display:inline-block"><?php echo htmlentities($_SESSION['ticketinfo']['created_at']) ?></span></h3>
<?php echo htmlentities($_SESSION['ticketinfo']['description']) ?>
</div>

<?php

if($replies) {
    foreach($replies as $reply) {
        ?>

        <div style="padding: 20px; background: <?php echo (getUserna($reply['id_user']) == $ag) ? '#fff' : '#eee'; ?>; border: 1px solid #ccc; margin-bottom:10px;">
        <h3 style="margin-top: 0"><?php echo getUserna($reply['id_user']); ?> <span style="font-style: italic; font-size: 10px; display:inline-block"><?php echo htmlentities($reply['created_at']) ?>
</span></h3>
        <?php echo htmlentities($reply['content']) ?>
        </div>

        <?php
    }
} else {
    ?>
    <h4>No replies yet.</h4c>
    <?php
}

?>



<?php
if((getUserID() == $_SESSION['ticketinfo']['id_agent'] || getUserID() == $_SESSION['ticketinfo']['id_user']) && $_SESSION['ticketinfo']['ticket_status'] != 'Closed'){
?>
    <h2>Reply to Ticket</h2>
    <textarea id="reply" style="width: 100%; height: 100px"></textarea>
    
    <?php
    echo '<button onclick="replyClientTicket()">Reply</button><hr />';
    ?>

<?php
    }
?>


<script>
    function assignTicket() {
    var agentDropdown = document.getElementById('agentDropdown');
    var selectedAgentId = agentDropdown.value;

    // Call the updateTicketAgent function via an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../actions/action_update_ticket_agent.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            if (response === 'success') {
                // Reload the page without changing the URL
                window.location.reload(false);
            } else {
                alert('Failed to assign ticket.');
            }
        }
    };

    xhr.send('ticketId=<?php echo $_GET['id']; ?>&agentId=' + selectedAgentId);
}


    function replyClientTicket() {
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_replyClient.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                if (response === 'success') {
                    // Reload the page without changing the URL
                    window.location.reload(false);
                } else {
                    alert('Failed to reply ticket.');
                }
            }
        };
        var replyValue = encodeURIComponent(document.getElementById('reply').value);
        xhr.send('ticketId=<?php echo $_GET['id']; ?>&reply=' + replyValue);
    }

    function closeTicket() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_close_ticket_status.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                if (response === 'success') {
                    // Reload the page without changing the URL
                    window.location.reload(false);
                } else {
                    alert('Failed to update ticket status.');
                }
            }
        };
        xhr.send('ticketId=<?php echo $_GET['id']; ?>');
    }

    function reopenTicket() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_reopen_ticket_status.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                if (response === 'success') {
                    // Reload the page without changing the URL
                    window.location.reload(false);
                } else {
                    alert('Failed to update ticket status.');
                }
            }
        };
        xhr.send('ticketId=<?php echo $_GET['id']; ?>');
    }
    
    function updateDepartment() {
        var departmentId = document.getElementById('departmentSelect').value;
        var ticketId = <?php echo $_GET['id']; ?>;

        // Call the updateTicketDepartment function via an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_update_ticket_department.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                window.location.reload(false);
            }
        };
        xhr.send('ticketId=' + ticketId + '&newDepartmentId=' + departmentId);
    }

</script>


<?php
drawFooter();
?>
