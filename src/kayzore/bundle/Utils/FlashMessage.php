<?php
namespace kayzore\bundle\Utils;


use kayzore\bundle\KBundle\KFramework;

class FlashMessage
{
    public static function set($message, $type = 'success', array $errors = null)
    {
        $_SESSION[kFramework::getProjectAlias() . '_flashMessage'] = [
            'message' => $message,
            'type' => $type,
        ];
        if (!is_null($errors)) {
            $_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'] = $errors;
        }
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

    public static function displayFormClassError($inputName)
    {
        if (isset($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors']) && !empty($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'])) {
            foreach ($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'] as $champ => $message) {
                if ($champ == $inputName) {
                    echo 'has-error';
                }
            }
        }
    }

    public static function displayFormMessageError($inputName)
    {
        if (isset($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors']) && !empty($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'])) {
            foreach ($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'] as $champ => $message) {
                if ($champ == $inputName) {
                    echo $message;
                    unset($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'][$inputName]);
                }
            }
        }
    }
}