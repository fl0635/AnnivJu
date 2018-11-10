<main role="main" class="inner cover">

  <h1 class="cover-heading">Accès administrateur</h1>

  {if $logState == "not-logged" or $logState == "wrong-pwd"}
    
    {if $logState == "wrong-pwd"}
    <p class="lead">Mauvais mot de passe.</p>
    {/if}

    <form action="log" method="post">
      <label for="pwd">Mot de passe : </label>
      <input type="password" name="pwd" id="pwd" required>
      <input type="submit" value="Envoyer">
    </form>

  {elseif $logState == "logged"}

    <p class="lead">Vous êtes maintenant connecté en tant qu'administrateur.</p>

  {/if}

</main>