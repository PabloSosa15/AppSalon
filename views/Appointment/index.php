<h1 class="page-name">Create new Appointment</h1>
<p class="page-description">Choose your service and enter your data</p>

<?php
include_once __DIR__ . '/../templates/bar.php';
?>

<div class="app">
    <nav class="tabs">
        <button class="current" type="button" data-step="1">Services</button>
        <button type="button" data-step="2">Appointment information</button>
        <button type="button" data-step="3">Appointment preview</button>
    </nav>


    <div id="step-1" class="section">
        <h2>Services</h2>
        <p class="text-center">Choose your services below</p>
        <div id="services" class="list-services"></div>
    </div>

    <div id="step-2" class="section">
    <h2>Your data and appointment</h2>
        <p class="text-center">Enter your data and date of your appointment</p>

        <form class="formulary">
            <div class="camp">
                <label for="name">Name</label>
                <input
                id="name"
                type="text"
                placeholder="Your Name"
                value="<?php echo $name;?>"
                disabled
                >
            </div>
            <div class="camp">
                <label for="date">Date</label>
                <input
                id="date"
                type="date"
                min="<?php echo date('Y-m-d', strtotime('+1 day'))?>"
                >
            </div>

            <div class="camp">
                <label for="hour">Hour</label>
                <input
                id="hour"
                type="time"
                >
            </div>

            <input type="hidden" id="id" value="<?php echo $id ?>">


        </form>
    </div>
    <div id="step-3" class="section content-preview">
    <h2>Appointment preview</h2>
        <p class="text-center">Verify that the information is correct</p>
    </div>

    <div class="pager">
    <button
    id="previous"
    class="button"
    >&laquo; Previous</button>

    <button
    id="next"
    class="button"
    >Next &raquo;</button>
    </div>

<?php
$script = "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>;

    <script src='build/js/app.js'></script>
    ";
?>
</div>