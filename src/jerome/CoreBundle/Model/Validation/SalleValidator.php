<?php
namespace jerome\CoreBundle\Model\Validation;


class SalleValidator
{
    /**
     * Valide le post d'une salle
     * @param array $salle
     * @param string $photo
     * @return array
     */
    public static function validatePost(array $salle, $photo)
    {
        $errors = [];
        if (!self::validateTitre($salle['titreInput'], $msg)) {
            $errors['titreInput'] = [$msg];
        }
        if (!self::validateDescription($salle['descriptionTextarea'], $msg)) {
            $errors['descriptionTextarea'] = [$msg];
        }
        if (!self::validatePays($salle['paysSelect'], $msg)) {
            $errors['paysSelect'] = [$msg];
        }
        if (!self::validateVille($salle['villeSelect'], $msg)) {
            $errors['villeSelect'] = [$msg];
        }
        if (!self::validateAdresse($salle['adresseTextarea'], $msg)) {
            $errors['adresseTextarea'] = [$msg];
        }
        if (!self::validateCp($salle['cpInput'], $msg)) {
            $errors['cpInput'] = [$msg];
        }
        if (!self::validateCapacite($salle['capaciteSelect'], $msg)) {
            $errors['capaciteSelect'] = [$msg];
        }
        if (!self::validateCategorie($salle['categorieSelect'], $msg)) {
            $errors['categorieSelect'] = [$msg];
        }
        if (!self::validatePhoto($photo, $msg)) {
            $errors['photoInput'] = [$msg];
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
        var_dump($capacite);
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