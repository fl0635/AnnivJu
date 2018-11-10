<main role="main" class="inner cover">

	<h1 class="cover-heading">Gestion du site</h1>

	<h3>Gestion des routes</h3>

	<form action="admin/" method="post">
		<label for="add">Ajouter une route : </label>
		<input type="text" name="add" id="add"><br>
		
		<ul>
		{foreach $routes as $route}
			<li>{$route}</li>
		{/foreach}
		</ul>
		
		<label for="remove">Supprimer une route : </label>
		<input type="text" name="remove"><br>

		<input type="submit" value="Envoyer">
	</form>

	<h3><a href="info">Vers configuration PHP ></a></h3>

</main>