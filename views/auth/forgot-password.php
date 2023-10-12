<h1 class="page-name">Forgot Password</h1>
<p class="page-description">Reset your password by entering your email below</p>
<?php 
   include_once __DIR__ . "/../templates/alerts.php"?>

<form class="formulary" method="POST" action="/forget">
    <div class="camp">
        <label for="email">Email</label>
        <input 
        type="email" 
        name="email" 
        id="email"
        placeholder="Your E-mail"
        >
    </div>

    <input type="submit" class="button" value="Send instructions">
</form>


<div class="actions">
        <a href="/create-account">You still don't have an account? Create one</a>
        <a href="/forget">Forgot your password?</a>
    </div>