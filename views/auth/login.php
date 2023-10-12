<body>

<h1 class="page-name">Login</h1>
<p class="page-description">Log in with your details</p>

<?php
include_once __DIR__ . "/../templates/alerts.php";
   ?>

<form class="formulary" method="POST" action="/">
    <div class="camp">
    <label for="email">Email</label>
    <input
        type="email"
        id="email"
        placeholder="Your Email"
        name="email"
        />
    </div>

    <div class="camp">
        <label for="password">Password</label>
        <input 
        type="password"
        id="password"
        placeholder="Your Password"
        name="password"
        />
    </div>

    <input type="submit" class="button" value="Log In">
</form>

<div class="actions">
        <a href="/create-account">You still don't have an account? Create one</a>
        <a href="/forget">Forgot your password?</a>
    </div>
</body>