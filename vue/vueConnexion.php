<section class="row connexion">
    <form method="post">
        <label for="login">Votre login : </label><input id="login" type="text" name="login" /><br />
        <label for="mdp">Votre mot de passe : </label><input id="mdp" type="password" name="mdp" /><br />
        <input type="submit" value="Valider" />
    </form>
</section>
<?php
    function erreurConnexion()
    {
?>
<section class="row connexion">
    <p>Erreur de connexion, le login ou le mot de passe est erroné. Merci de réessayer.</p>
</section>
<?php
    }
?>