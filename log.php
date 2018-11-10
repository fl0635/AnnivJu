<?php

/* Change class name here */
class log {

    use TraitForPages;

    private static function initialize () : void {
        /* Configure your page settings here */
        self::setName('log');
        self::setRequiresAuth(false);
        self::setEmbedded(true);
    }

    private static function modelize () : void {
        $executeStatement = function(PDOStatement $statement) { $statement->execute(); };
        $statements = array(
            /* What you want to retrieve from the database here */
        );
        array_walk($statements, $executeStatement);

        self::setModels(array(
            /* How you want the data here */
        ));
    }

    private static function controler () : void {

        /* Code here */

        $GLOBALS['visitor']->logout();
        $logState = "not-logged";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pwd'])) {
            if ($_POST['pwd'] == 'citytrail') {
                $GLOBALS['visitor']->login();
                $logState = "logged";
            } else {
                $logState = "wrong-pwd";
            }
        }


    }

}