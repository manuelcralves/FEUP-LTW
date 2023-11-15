<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/init.php');

if (!isset($_SESSION['username'])) {
    header("Location:/index.php");
}

require_once(__DIR__ . '/../templates/header.tpl.php');
require_once(__DIR__ . '/../templates/footer.tpl.php');

drawHeader();
?>

<div class="ticket-form">
    <h2>Create new ticket</h2>
    <form action="/actions/processar_ticket.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <label for="department">Choose a department:</label>
        <select name="department" id="department" required>
            <?php
            require_once(__DIR__ . '/../actions/getAll_departments.php');
            for ($i = 0; $i < count($departments); $i++) {
                ?>
                <option value="<?= $departments[$i]['id'] ?>"><?= $departments[$i]['name'] ?></option>
                <?php
            }
            ?>
        </select>
        <label for="hashtags">Hashtags:</label>
        <div id="hashtag-container">
            <?php
            require_once(__DIR__ . '/../actions/getAll_hashtags.php');
            for ($i = 0; $i < count($hashtags); $i++) {
                ?>
                <input type="checkbox" name="hashtags[]" value="<?= $hashtags[$i]['tag'] ?>" id="hashtag<?= $i ?>">
                <label for="hashtag<?= $i ?>" class="hashtag-label"><?= $hashtags[$i]['tag'] ?></label>
                <?php
            }
            ?>
        </div>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <input type="submit" value="Submit">
    </form>
</div>

<script>
    const hashtagLabels = document.querySelectorAll('.ticket-form .hashtag-label');

    hashtagLabels.forEach(label => {
        label.addEventListener('click', () => {
            label.classList.toggle('selected');
        });
    });
</script>

<?php
drawFooter();
?>
