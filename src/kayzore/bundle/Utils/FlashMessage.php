<?php
namespace kayzore\bundle\Utils;


use kayzore\bundle\KBundle\KFramework;

class FlashMessage
{
    public static function set($message, $type = 'success')
    {
        $_SESSION[kFramework::getProjectAlias() . '_flashMessage'] = [
            'message' => $message,
            'type' => $type,
        ];
    }

    public static function display()
    {
        if (isset($_SESSION[kFramework::getProjectAlias() . '_flashMessage'])) {
            $type = $_SESSION[kFramework::getProjectAlias() . '_flashMessage']['type'] == 'error'
                ? 'danger' // class alert-danger du bootstrap
                : $_SESSION[kFramework::getProjectAlias() . '_flashMessage']['type']
            ;

            echo '<div class="alert alert-' . $type . '" role="alert">'
                . '<strong>' . $_SESSION[kFramework::getProjectAlias() . '_flashMessage']['message'] . '</strong>'
                . '</div>'
            ;

            // suppression du msg de la session pour affichage "one shot"
            unset($_SESSION[kFramework::getProjectAlias() . '_flashMessage']);
        }
    }
}