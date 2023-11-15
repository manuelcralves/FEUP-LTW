<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/department.class.php');
  require_once(__DIR__ . '/../actions/getAll_hashtags.php');

?>

<?php function drawdepartments(array $departments, bool $isADMIN) { ?>
  <section id="department">
    <header>
      <h2>Departments</h2>
      <div class="add-department-container">
        <?php if ($isADMIN == true) { ?>
          <a href="/pages/novo_department.php" class="buttondepar">Add Department</a>
        <?php } ?>
      </div>
      <input id="searchdepartment" type="text" placeholder="search" onchange> 
    </header>
  </section>
  <section id="departments">
    <?php foreach ($departments as $department) { ?> 
      <article class="fade-box">
        <a href="../pages/departmentTicket.php?id=<?=$department->id?>"><?=$department->name?></a>
      </article>
    <?php } ?>
  </section>
<?php } ?>

<?php
function drawDepartment(Department $department, array $tickets, array $hashtags) {
?>
  <h2><?= $department->name ?></h2>

  <form method="POST" action="">
    <label for="status">Filter by Status:</label>
    <select name="status" id="status">
      <option value="all">All</option>
      <option value="Open">Open</option>
      <option value="Assigned">Assigned</option>
      <option value="Closed">Closed</option>
    </select>
  
    <label for="hashtags">Filter by Hashtags:</label>
    <div class="hashtag-container">
      <?php
      require_once(__DIR__ . '/../actions/getAll_hashtags.php');
      for ($i = 0; $i < count($hashtags); $i++) {
        ?>
        <input type="checkbox" name="hashtags[]" value="<?= $hashtags[$i]['id'] ?>">
        <label class="hashtag-label"><?= $hashtags[$i]['tag'] ?></label>
        <?php
      }
      ?>
    </div>
  
    <div class="button-container">
      <input type="submit" value="Apply Filter" class="apply-button">
      <input type="button" value="Reset Filter" onclick="location.href='departmentTicket.php?id=<?= $_GET['id'] ?>'" class="reset-button">
    </div>
  </form>
  

  <section id="tickets">
    <?php 
    if (count($tickets) == 0) {
      echo "<h3>No tickets from this Department</h3>";
    }
    
    foreach ($tickets as $ticket) { 
      $id_t = $ticket['id'];
      $title_t = $ticket['title'];
      $description_t = $ticket['description'];
      $status_t = $ticket['ticket_status'];
    ?>
    <div class="ticket" id="<?= $id_t ?>">
      <h3><?= $title_t ?></h3>
      <p><?= $description_t ?></p>
      <p>-- <?= $status_t ?> --</p>
      <a href="../pages/detailTicket.php?id=<?= $ticket['id'] ?>" class="button">Details</a>
    </div>
    <?php } ?>
  </section>
<?php
}
?>



<script>
  document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[name="hashtags[]"]');
    const labels = document.querySelectorAll('.hashtag-label');

    checkboxes.forEach(function(checkbox, index) {
      checkbox.style.display = 'none'; // Hide the checkboxes

      checkbox.addEventListener('change', function() {
        labels[index].classList.toggle('selected'); // Toggle the 'selected' class on label click
      });

      labels[index].addEventListener('click', function() {
        checkbox.checked = !checkbox.checked; // Toggle checkbox state on label click
        labels[index].classList.toggle('selected'); // Toggle the 'selected' class on label click
      });
    });
  });
</script>