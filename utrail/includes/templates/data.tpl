<main role="main" class="inner cover">

	<h1 class="cover-heading">Gestion des données</h1>

	<p class="lead">
	{if $dbState == "upload-ok"}
		Le fichier SQL a été lu et exécuté avec succès.
	{elseif $dbState == "exec-ok"}
		La commande a été exécutée avec succès, et a retourné :
		<br>{$successReturn}
	{elseif $dbState == "upload-not-ok" || $dbState == "exec-not-ok"}
		L'exécution n'a pas pu aboutir, un problème est survenu.
	{/if}
	</p>

	<h3>Charger un fichier SQL à exécuter</h3>

	<form action="data/" method="post" enctype="multipart/form-data">
		<label for="file">Fichier SQL : </label>
		<input type="hidden" name="MAX_FILE_SIZE" value="1048576">
		<input type="file" name="file" id="file" accept=".sql"><br>
		<input type="submit" value="Envoyer">
	</form>

	<h3>Exécuter une requête non-paramétrée pré-définie</h3>

	<form action="data/" method="post" id="cmd">
		<label for="req">Requête : </label><br>
		<select name="req" id="req" form="cmd">
			{foreach from=$possibleRequests key=requestKey item=requestValue}
				<option value="{$requestValue}">{$requestKey}</option>
			{/foreach}
		</select><br>
		<input type="submit" value="Envoyer">
	</form>

	<h3><a href="/phpmyadmin">Vers PhpMyAdmin ></a></h3>

</main>