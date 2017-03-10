<?php
namespace jerome\CoreBundle\Model\Validation;


class SalleValidator
{
    /**
     * Valide le post d'une salle
     * @return array
     */
    public static function validatePost()
    {
        $errors = [];
        if (!self::validateTitre($_POST['titreInput'], $msg)) {
            $errors['titreInput'] = $msg;
        }
        if (!self::validateDescription($_POST['descriptionTextarea'], $msg)) {
            $errors['descriptionTextarea'] = $msg;
        }
        if (!self::validatePays($_POST['paysSelect'], $msg)) {
            $errors['paysSelect'] = $msg;
        }
        if (!self::validateVille($_POST['villeSelect'], $msg)) {
            $errors['villeSelect'] = $msg;
        }
        if (!self::validateAdresse($_POST['adresseTextarea'], $msg)) {
            $errors['adresseTextarea'] = $msg;
        }
        if (!self::validateCp($_POST['cpInput'], $msg)) {
            $errors['cpInput'] = $msg;
        }
        if (!self::validateCapacite($_POST['capaciteSelect'], $msg)) {
            $errors['capaciteSelect'] = $msg;
        }
        if (!self::validateCategorie($_POST['categorieSelect'], $msg)) {
            $errors['categorieSelect'] = $msg;
        }
        if (!self::validatePhoto($_FILES['photoInput'], $msg)) {
            $errors['categorieSelect'] = $msg;
        }

        return $errors;
    }

    /**
     * Effectue les validations du titre
     * @param $titre
     * @param $msg
     * @return bool
     */
    private static function validateTitre($titre, &$msg)
    {
        if (empty($titre)) {
            $msg = 'Le titre est obligatoire.';
            return false;
        }

        return true;
    }

    /**
     * Effectue les validations de la description
     * @param $description
     * @param $msg
     * @return bool
     */
    private static function validateDescription($description, &$msg)
    {
        if (empty($description)) {
            $msg = 'La description est obligatoire.';
            return false;
        }

        return true;
    }

    /**
     * Effectue les validations du pays
     * @param $pays
     * @param $msg
     * @return bool
     */
    private static function validatePays($pays, &$msg)
    {
        if (empty($pays)) {
            $msg = 'Le pays est obligatoire.';
            return false;
        }

        return true;
    }

    /**
     * Effectue les validations de la ville
     * @param $ville
     * @param $msg
     * @return bool
     */
    private static function validateVille($ville, &$msg)
    {
        if (empty($ville)) {
            $msg = 'La ville est obligatoire.';
            return false;
        }

        return true;
    }

    /**
     * Effectue les validations de l'adresse
     * @param $adresse
     * @param $msg
     * @return bool
     */
    private static function validateAdresse($adresse, &$msg)
    {
        if (empty($adresse)) {
            $msg = "L'adresse est obligatoire.";
            return false;
        }

        return true;
    }

    /**
     * Effectue les validations du code postal
     * @param $cp
     * @param $msg
     * @return bool
     */
    private static function validateCp($cp, &$msg)
    {
        if (empty($cp)) {
            $msg = 'Le code postal est obligatoire.';
            return false;
        }

        return true;
    }

    /**
     * Effectue les validations de la capacite
     * @param $capacite
     * @param $msg
     * @return bool
     */
    private static function validateCapacite($capacite, &$msg)
    {
        if (empty($capacite)) {
            $msg = 'La capacite est obligatoire.';
            return false;
        }

        return true;
    }

    /**
     * Effectue les validations de la categorie
     * @param $categorie
     * @param $msg
     * @return bool
     */
    private static function validateCategorie($categorie, &$msg)
    {
        if (empty($categorie)) {
            $msg = 'La catégorie est obligatoire.';
            return false;
        }

        return true;
    }

    /**
     * Effectue les validations de la photo
     * @param $photo
     * @param $msg
     * @return bool
     */
    private static function validatePhoto($photo, &$msg)
    {
        if (!empty($photo['tmp_name'])) {
            if ($photo['size'] > 1000000) {
                $msg = 'La photo ne doit pas faire plus de 1Mo';
                return false;
            }
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            if (!in_array($photo['type'], $allowedMimeTypes)) {
                $msg = 'La photo doit être un JPG, un GIF ou un PNG';
                return false;
            }
            if ($photo['size'] != 0 && $photo['error'] != 0) {
                $msg = ['Vous devez choisir une image'];
                return false;
            }
        } else {
            $msg = ['Vous devez choisir une image'];
            return false;
        }
        return true;
    }
}