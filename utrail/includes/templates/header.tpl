<!DOCTYPE html>
<html>

<head>
	<base href="{$globals['utrailPath']}">
	<meta charset="utf-8">
	<link rel="icon" href="includes/images/icon.svg">

	<title>UniverCity Trail</title>
	<link href="{$globals['libsPath']}bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="{$globals['libsPath']}bootstrap/dist/css/indexCover/cover.css" rel="stylesheet" type="text/css">
	<link href="includes/styles/style.css" rel="stylesheet" type="text/css">
</head>

<body>

	<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
		<header class="masthead mb-auto">
			<div class="inner">
				<h3 class="masthead-brand">Univer'City Trail #1</h3>
				<nav class="nav nav-masthead justify-content-center">

					<a class="nav-link" href="/udev/">
						Notre entreprise</a>
					<a class="nav-link {if $activePage == "index"}active{/if}" href="index">
						Accueil</a>
					<a class="nav-link {if $activePage == "log"}active{/if}" href="log">
						{if $logged}Déconnexion{else}Connexion{/if}</a>
					{if $logged}
					<a class="nav-link {if $activePage == "admin"}active{/if}" href="admin">
						Gestion du site</a>
					<a class="nav-link {if $activePage == "data"}active{/if}" href="data">
						Gestion des données</a>
					<a class="nav-link {if $activePage == "race"}active{/if}" href="race">
						Gestion de la course</a>
					{/if}

				</nav>
			</div>
		</header>