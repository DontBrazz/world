<?php
require_once('../../mysql/MySQLController.php');
class Profiles {

    private $mysql = null;
    public function __construct() {
        $sql = new MySQL();
        $mysql = $sql;
    }

    public function getNome() {
        return "JACINTO";
    }
}

?>