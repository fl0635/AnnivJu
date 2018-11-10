<?php

class ExceptionsMap {

	/* Router */
	const ERR_ROUTER_READING_ROUTES_FILE =
		"Impossible d'accéder ou de parser le fichier de configuration des routes.";

	const ERR_ROUTER_UNKNOWN_ROUTE =
		"L'adresse demandée n'existe pas ou n'est pas configurée.";

	const ERR_PAGES_UNAUTHORIZED =
		"Vous n'avez pas la permission d'accéder à cette page.";

	/* Database */
	const ERR_DB_VISITOR_AUTHENTICATION =
		"Erreur lors du processus d'authentification de ce visiteur.";

	const ERR_DB_VISITOR_DELETE =
		"Erreur lors de la suppression des anciens logs de ce visiteur.";

	const ERR_DB_VISITOR_CREATE =
		"Erreur lors de la création d'un log de ce visiteur.";
	
}