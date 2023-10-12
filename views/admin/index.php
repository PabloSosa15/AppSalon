<h1 class="name-page">Administation Panel</h1>

<?php
include_once __DIR__ . '/../templates/bar.php';
?>

<h2>Search for appointments</h2>

<div class="Search">
    <form class="formulary">
        <div class="camp">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" value="<?php echo $date ?>"/>
        </div>
    </form>
</div>

<?php 
    if(count($appointments) === 0) {
    echo "<h2>No appointments on this date</h2>";
    }
?>

<div id="admin-appointment">
    <ul class="appointment">
        <?php 
        $idappointment = 0;
        foreach ($appointments as $key => $appointment) {

            if ($idappointment !== $appointment->id) {
                $total = 0;
        ?>
                <li>
                    <p>ID: <span><?php echo $appointment->id; ?></span></p>
                    <p>Hour: <span><?php echo $appointment->hour; ?></span></p>
                    <p>Client: <span><?php echo $appointment->client; ?></span></p>
                    <p>Email: <span><?php echo $appointment->email; ?></span></p>
                    <p>Phone: <span><?php echo $appointment->phone; ?></span></p>
                </li>

                <h3>Services</h3>
        <?php
        $idappointment = $appointment->id;
            } // End if
        
            $total += $appointment->price;
        ?>
                <p class="services"><?php echo $appointment->service . " " . $appointment->price; ?></p>

                <?php
                $current = $appointment->id;
                $next = $appointments[$key + 1]->id ?? 0;

                if (isLast($current, $next)) { ?>
                    <p class="total">Total: <span><?php echo $total; ?></span></p>


                    <form action="/api/delete" method="POST">
                        <input type="hidden" name="id" value="<?php echo $appointment->id;?>">
                        
                        <input type="submit" class="button-delete" value="Delete">
                    </form>
            <?php } 
        } // For each end ?>
    </ul>
</div>

<?php
    $script = "<script src='build/js/search.js'></script>";
?>