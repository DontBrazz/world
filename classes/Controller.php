<?php
require_once("mysql/MySQLController.php");
class Controller {

    public function loadHTML($page) {
        switch ($page) {
            case 'activity':
                $this->load('htmls/inicio.php');
                break;
            case 'error':
                $this->load('htmls/error.php');
                break;
            default:
                $this->load('htmls/error.php');
                break;
        }
    }

    public function getStats() {
        if (isset($_SESSION['admin'])) {
            return "Administrador";
        } else {
            return "Bem-Vindo";
        }
    }
    public function getUser() {
        if (isset($_SESSION['admin'])) {
            return "Professor";
        } else {
            return "Aluno";
        }
    }


    public function getProfile() {
        $mysql = new MySQL();
        if ($mysql->isConnection()) {
            return "REFLEXO AMA PICA e CHUPA PICA COM FORÇA";
        } else {
            return "REFLEXO CHUPA PICA";
        }
    }

    public function loadNav() {
        $this->load("navbar/navbar.php");
    }
    private function load($filename) {
        include($filename);
    }
}

?>