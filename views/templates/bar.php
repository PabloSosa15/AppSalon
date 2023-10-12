<div class="bar">
    <p>Hi:
        <?php echo $name ?? ''; ?>
    </p>
    <a class="button" href="/logout"> Close Sesion</a>
</div>

<?php

if (isset($_SESSION['admin'])) { ?>
    <div class="bar-service">
        <a class="button" href="/admin">View Appointments</a>
        <a class="button" href="/services">View Services</a>
        <a class="button" href="/services/create">Create Services</a>
    </div>

<?php } ?>