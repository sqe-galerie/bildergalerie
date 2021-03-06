<?php /** @var LoginView $this */ ?>
<div class="container">

    <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Bitte anmelden</h2>
        <?php if($this->isFailure()): ?>
            <div class="alert alert-danger">Benutzername oder Passwort sind nicht korrekt.</div>
        <?php endif; ?>
        <label for="inputUser" class="sr-only">Benutzername</label>
        <input type="text" id="inputUser" name="inputUser" class="form-control" placeholder="Benutzername" required autofocus />
        <label for="inputPassword" class="sr-only">Passwort</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Passwort" required />
        <!--<div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Logindaten 4 Wochen merken
            </label>
        </div>-->
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit_login">Anmelden</button>
    </form>
    <div class="text-center"> <a href="<?php echo $this->url(); ?>">Abbrechen</a></div>

</div>
