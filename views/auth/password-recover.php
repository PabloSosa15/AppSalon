<h1 class="page-name"> Recover Password</h1>
<p class="page-description">Insert your new Password</p>
 
<?php include_once __DIR__ . '/../templates/alerts.php'; ?>

<?php 
if($fixs) return; 
?>

<form class="formulary" method="POST" >
    <div class="camp">
        <label for="password">Password</label>
        <input
        type="password"
        id="password"
        name="password"
        placeholder="Your new Password"
        />
    </div>

    <input type="submit" class="button" value="Save new password">


</form>

<div class="actions">
    <a href="/">Already have an account? Sign in</a>
    <a href="create-account">Don't have an account yet? Create an account</a>
</div>