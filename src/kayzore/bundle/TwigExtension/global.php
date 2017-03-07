<?php
$this->twig->addGlobal('dev_mode', DEV_MODE);
if (isset($_SESSION['ls_utilisateur'])) {
    $this->twig->addGlobal('user', $_SESSION['ls_utilisateur']);
}