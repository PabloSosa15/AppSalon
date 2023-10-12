<h1 class="page-name">New Service</h1>
<h1 class="page-description">Fill in all fields to add a new service</h1>

<?php
include_once __DIR__ . '/../templates/bar.php';
include_once __DIR__ . '/../templates/alerts.php';
?>

<form action="/services/create" method="POST" class="formulary" >
    <?php include_once __DIR__ . '/formulary.php';?>

    <input type="submit" class="button" value="Save Services" >
</form>