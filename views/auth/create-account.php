<h1 class="page-name"> Create Account </h1>
<p class="page-description">Fill out the following form to create an account</p>

<?php 
   include_once __DIR__ . "/../templates/alerts.php"?>
<form class="formulary" method="POST" action="/create-account">

     <div class="camp">
        <label for="name">Name</label>
        <input 
        type="text"
        id="name"
        placeholder="Your Name"
        name="name"
        value="<?php echo s($user->name)?>"
        />

     <div class="camp">
        <label for="lastname">Last Name</label>
        <input 
        type="text"
        id="lastname"
        name="lastname"
        placeholder="Your Last Name"
        value="<?php echo s($user->lastname)?>"
        />
     </div>

     <div class="camp">
        <label for="phone">Phone Number</label>
        <input 
        type="tel"
        id="phone"
        name="phone"
        placeholder="Your Phone Number"
        value="<?php echo s($user->phone)?>"
        />

     </div>
     <div class="camp">
        <label for="email">E-mail</label>
        <input 
        type="email"
        id="email"
        name="email"
        placeholder="Your E-mail"
        value="<?php echo s($user->email)?>"
        />
     </div>

     <div class="camp">
        <label for="password">Psssword</label>
        <input 
        type="password"
        id="password"
        name="password"
        placeholder="Your Password"
        />
     </div>

     <input type="submit" value="Create Account" class="button">

     </form>


<div class="actions">
        <a href="/">Do you already have an account? Log in</a>
        <a href="/forget">Forgot your password?</a>
    </div>