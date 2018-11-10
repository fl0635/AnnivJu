<main role="main" class="inner cover">

	<h1 class="cover-heading">Oups ! Il semblerait qu'il y ait eu une erreur.</h1>
	
	{if $logged}
		<p class="lead">Détails de l'erreur :</p>
		{foreach $attributes as $attribute}
			<p>{$attribute}</p>
		{/foreach}
	{else}
		<p class="lead"><a href="index">Cliquez ici</a> pour revenir à l'accueil.</p>
	{/if}

</main>