<?php
namespace kayzore\bundle\Utils;


use kayzore\bundle\KBundle\KFramework;

class FlashMessage
{
    /**
     * Set un message flash, par défaut de type success
     * @param string $message
     * @param string $type
     * @param array|null $errors
     */
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

    /**
     * Affiche un message flash et l'unset ensuite
     */
    public static function display()
    {
        if (isset($_SESSION[kFramework::getProjectAlias() . '_flashMessage'])) {
            $type = $_SESSION[kFramework::getProjectAlias() . '_flashMessage']['type'] == 'error'
                ? 'danger' // class alert-danger du bootstrap
                : $_SESSION[kFramework::getProjectAlias() . '_flashMessage']['type']
            ;

            echo '<div class="alert alert-' . $type . ' text-center" role="alert">'
                . '<strong>' . $_SESSION[kFramework::getProjectAlias() . '_flashMessage']['message'] . '</strong>'
                . '</div>'
            ;

            // suppression du msg de la session pour affichage "one shot"
            unset($_SESSION[kFramework::getProjectAlias() . '_flashMessage']);
        }
    }

    /**
     * Affiche la class bootstrap error si le champ contient des erreur
     * @param string $inputName
     */
    public static function displayFormClassError($inputName)
    {
        if (isset($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors']) && !empty($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'])) {
            foreach ($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'] as $champ => $message) {
                if ($champ == $inputName) {
                    echo 'has-error';
                    break;
                }
            }
        }
    }

    /**
     * Affiche la valeur d'un champ input ou d'un select
     * @param string $inputName
     * @param bool $select
     * @param int $optionSelect
     */
    public static function displayChampValue($inputName, $select, $optionSelect)
    {
        if (isset($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors']) && !empty($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'])) {
            foreach ($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors']['champValue'] as $champ => $champValue) {
                if ($champ == $inputName) {
                    if ($select && $optionSelect == $champValue) {
                        echo 'selected="selected"';
                        unset($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors']['champValue'][$inputName]);
                        break;
                    } elseif (!$select) {
                        echo $champValue;
                        unset($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors']['champValue'][$inputName]);
                        break;
                    }
                }
            }
        }
    }

    /**
     * Affiche le message d'erreur d'un champ s'il y a des erreurs sur celui-ci
     * @param string $inputName
     */
    public static function displayFormMessageError($inputName)
    {
        if (isset($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors']) && !empty($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'])) {
            foreach ($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'] as $champ => $message) {
                if ($champ == $inputName) {
                    echo '<p class="help-block">' . $message . '</p>';
                    unset($_SESSION[kFramework::getProjectAlias() . '_flashMessage_errors'][$inputName]);
                    break;
                }
            }
        }
    }
}