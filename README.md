Projet UniverCity Trail
===

Utilisation
---
**Hébergement :** _http://148.60.11.114/u-trail/dev/_
L'HTTPS n'est pas supporté.
Le dossier _/dev_ est push sur le serveur à peu près **toutes les 2 minutes**.

**GUI BDD :** _http://148.60.11.114/phpmyadmin/_
Les identifiants sont partagés sur Discord.

Comment créer une nouvelle page
---


Conventions adoptées
---
- L'anglais est la langue utilisée dans le code
- La seule exception est faite pour le nom des contrôleurs, car leur nom correspond à l'URL appelée, or celle-ci sera en français
- Les classes sont documentées par PhpDoc
- Les commentaires autres que PhpDoc sont en français
- La notation pour les variables et fonctions pour le code PHP __et__ SQL est la suivante : myAwesomeVariable
- Les tabulations correspondent à un caractère Tab (\t) et non 2 ou 4 espaces
- Les noms de toutes les variables doivent être significatifs

# Le coup des droits à www-data chown chgrp pour smarty et upload dir
# upload_tmp_dir changé dans php.ini
	# php_flag file_uploads on
	# php_value upload_tmp_dir "/var/www/html/udev/utrail/uploads/"
	# php_value upload_max_filesize 10M
# bidouille résoudre bug sql
	# sudo sed -i "s/|\s*\((count(\$analyzed_sql_results\['select_expr'\]\)/| (\1)/g" /usr/share/phpmyadmin/libraries/sql.lib.php
