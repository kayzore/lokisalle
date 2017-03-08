<?php
namespace jerome\CoreBundle\Model;


use kayzore\bundle\KBundle\Cnx;

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
     * @return $this
     */
    public function setIdSalle($id_salle)
    {
        $this->id_salle = $id_salle;

        return $this;
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
     * @return $this
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
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
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * @return $this
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
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
     * @return $this
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
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
     * @return $this
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
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
     * @return $this
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
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
     * @return $this
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
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
     * @return $this
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;

        return $this;
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
     * @return $this
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return array
     */
    public static function getListeCategories()
    {
        return self::$liste_categories;
    }

    /**
     * Récupère et retourne la liste de toute les salles au format objet
     * @return array
     */
    public static function fetchAll()
    {
        $stmt = Cnx::getInstance()->query('SELECT * FROM salle');
        $salles = [];

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $salle) {
            $salles[] = new self(array(
                'id_salle'      => $salle['id_salle'],
                'titre'         => $salle['titre'],
                'description'   => $salle['description'],
                'photo'         => $salle['photo'],
                'pays'          => $salle['pays'],
                'ville'         => $salle['ville'],
                'adresse'       => $salle['adresse'],
                'cp'            => $salle['cp'],
                'capacite'      => $salle['capacite'],
                'categorie'     => $salle['categorie']
            ));
        }

        return $salles;
    }
}