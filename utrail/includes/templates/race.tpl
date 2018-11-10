<main role="main" class="inner cover">

	<h1 class="cover-heading">Gestion de la course</h1>

	{if $raceState == "upload-init-not-ok"}
	<p class="lead">
		L'initialisation n'a pas pu aboutir, un problème est survenu.
	</p>
	{elseif $raceState == "upload-update-not-ok"}
	<p class="lead">
		La réception du fichier n'a pas pu aboutir, un problème est survenu.
	</p>
	{/if}

	{if $status == -1}
	<p class="lead">
		La course utrail n'a pas encore été créé dans la base de données.
	</p>
	{else}

	<h3>Status de la course</h3>
	
	{if $status == 0}
		<p class="lead">
			La course utrail n'est pas commencée.<br>
			Vous pouvez l'initialiser en donnant un fichier .csv quelconque correspondant à cette course : 
			<form action="race/init" method="post" enctype="multipart/form-data">
				<input type="hidden" name="MAX_FILE_SIZE" value="10485760">
				<input type="file" name="file-init" id="file-init" accept=".csv">
				<input type="submit" value="Initialiser">
			</form>
		</p>
		<p class="lead">
			Démarrer la course ne permettra plus de l'initialiser, mais la réception en temps réel des fichiers .csv, la mise à jour automatique et la mise à jour manuelle du cache de la course démarreront.<br>
			Souhaitez-vous démarrer la course ?
			<a href="race/status-change"><button type="button">Démarrer</button></a>
		</p>
	{elseif $status == 1}
		<p class="lead">
			La course utrail est en cours.
		</p>
		<p class="lead">
			Interrompre la course désactivera la réception en temps réel des fichiers .csv et la mise à jour automatique du cache de la course, mais la mise à jour manuelle du cache de la course restera disponible.<br>
			Souhaitez-vous interrompre la course ?
			<a href="race/status-change"><button type="button">Interrompre</button></a>
		</p>
	{else}
		<p class="lead">
			La course utrail est interrompue.
		</p>
		<p class="lead">
			Reprendre la course réactivera la réception en temps réel des fichiers .csv et la mise à jour automatique du cache de la course.<br>
			Souhaitez-vous reprendre la course ?
			<a href="race/status-change"><button type="button">Reprendre</button></a>
		</p>
	{/if}
	
	<h3>Détails et options</h3>

	<p class="lead">
		Il y a {$numberParticipants} participants à la course.
	</p>

	<p class="lead">
		<ul>
			<li>Dernier fichier .csv reçu le : {$datetimeLastCSV}</li>
			<li>Dernière mise à jour du cache de la course le : {$datetimeLastDump}</li>
			<li>Taille du cache de la course : {$sizeDump}</li>
		</ul>
	</p>

	{if $status != 0}
		<p class="lead">
			<a href="race/dump"><button type="button">Mettre à jour le cache</button></a>
		</p>
	{/if}

	{if $status == 1}
		<h3>Simuler l'envoi d'un fichier .csv</h3>

		<p class="lead">
			<form action="race/update" method="post" enctype="multipart/form-data">
				<input type="hidden" name="MAX_FILE_SIZE" value="10485760">
				<input type="file" name="file-update" id="file-update" accept=".csv">
				<input type="submit" value="Initialiser">
			</form>
		</p>
	{/if}

	{/if}

</main>