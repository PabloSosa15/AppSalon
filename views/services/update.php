<h1 class="page-name">Service Update</h1>
<h1 class="page-description">Modifies the values of the form</h1>

<?php
include_once __DIR__ . '/../templates/bar.php';
include_once __DIR__ . '/../templates/alerts.php';
?>

<form method="POST" class="formulary" >
    <?php include_once __DIR__ . '/formulary.php';?>

    <input type="submit" class="button" value="Update Services" >
</form>