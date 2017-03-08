<?php
namespace jerome\CoreBundle\Model;


class Salle
{
    /**
     * @var int
     */
    private $id_salle;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $photo;

    /**
     * @var string
     */
    private $pays;

    /**
     * @var string
     */
    private $ville;

    /**
     * @var string
     */
    private $adresse;

    /**
     * @var int
     */
    private $cp;

    /**
     * @var int
     */
    private $capacite;

    /**
     * @var string
     */
    private $categorie;

    /**
     * @var array
     */
    private static $liste_categories = array('Réunion', 'Bureau', 'Formation');

    public function __construct(array $salle = null)
    {
        $this->setIdSalle($salle['id_salle']);
        $this->setTitre($salle['titre']);
        $this->setDescription($salle['description']);
        $this->setPhoto($salle['photo']);
        $this->setPays($salle['pays']);
        $this->setVille($salle['ville']);
        $this->setAdresse($salle['adresse']);
        $this->setCp($salle['cp']);
        $this->setCapacite($salle['capacite']);
        $this->setCategorie($salle['categorie']);
    }

    /**
     * @return int
     */
    public function getIdSalle()
    {
        return $this->id_salle;
    }

    /**
     * @param int $id_salle
     */
    public function setIdSalle($id_salle)
    {
        $this->id_salle = $id_salle;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return int
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * @param int $cp
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
    }

    /**
     * @return int
     */
    public function getCapacite()
    {
        return $this->capacite;
    }

    /**
     * @param int $capacite
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return array
     */
    public static function getListeCategories()
    {
        return self::$liste_categories;
    }
}