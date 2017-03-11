<?php
namespace jerome\CoreBundle\Model;


use kayzore\bundle\KBundle\Cnx;
use kayzore\bundle\KBundle\KFramework;
use PDO;

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
     * @var \jerome\CoreBundle\Model\Avis
     */
    private $avis;

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
        if (isset($salle['avis'])) {
            $this->setAvis($salle['avis']);
        }
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
        if ($pays != 'France') {
            $pays = 'France';
        }
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
        if ($ville != 'Paris' || $ville != 'Lyon' || $ville != 'Marseille') {
            switch ($ville) {
                case 0:
                    $ville = 'Paris';
                    break;
                case 1:
                    $ville = 'Lyon';
                    break;
                case 2:
                    $ville = 'Marseille';
                    break;
                default:
                    $ville = 'Paris';
                    break;
            }
        }
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
     * @param string|int $categorie
     * @return $this
     */
    public function setCategorie($categorie)
    {
        if ($categorie != 'Réunion' || $categorie != 'Bureau' || $categorie != 'Formation') {
            switch ($categorie) {
                case 0:
                    $categorie = 'Réunion';
                    break;
                case 1:
                    $categorie = 'Bureau';
                    break;
                case 2:
                    $categorie = 'Formation';
                    break;
                default:
                    $categorie = 'Réunion';
                    break;
            }
        }
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Avis
     */
    public function getAvis()
    {
        return $this->avis;
    }

    /**
     * @param Avis $avis
     * @return $this
     */
    public function setAvis($avis)
    {
        $this->avis = $avis;

        return $this;
    }

    public function getAllAttributes()
    {
        return array(
            'titreInput'            => $this->getTitre(),
            'descriptionTextarea'   => $this->getDescription(),
            'paysSelect'            => $this->getPays(),
            'villeSelect'           => $this->getVille(),
            'adresseTextarea'       => $this->getAdresse(),
            'cpInput'               => $this->getCp(),
            'capaciteSelect'        => $this->getCapacite(),
            'categorieSelect'       => $this->getCategorie(),
            'photoInput'            => $this->getPhoto()
        );
    }

    /**
     *  Fonction qui gère l'insertion ou la modification d'une salle
     */
    public function save()
    {
        if (!empty($this->id)) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    /**
     * Insert une nouvelle salle dans la BDD
     */
    private function insert()
    {
        $this->setPhoto(self::uploadPhoto($_FILES['photoInput']));
        $pdo = Cnx::getInstance();
        $query = 'INSERT INTO salle (titre, description, photo, pays, ville, adresse, cp, capacite, categorie) '
            . 'VALUES(:titre, :description, :photo, :pays, :ville, :adresse, :cp, :capacite, :categorie)'
        ;
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':titre', $this->getTitre(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $this->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':photo', $this->getPhoto(), PDO::PARAM_STR);
        $stmt->bindValue(':pays', $this->getPays(), PDO::PARAM_STR);
        $stmt->bindValue(':ville', $this->getVille(), PDO::PARAM_STR);
        $stmt->bindValue(':adresse', $this->getAdresse(), PDO::PARAM_STR);
        $stmt->bindValue(':cp', $this->getCp(), PDO::PARAM_STR);
        $stmt->bindValue(':capacite', $this->getCapacite(), PDO::PARAM_STR);
        $stmt->bindValue(':categorie', $this->getCategorie(), PDO::PARAM_STR);
        $stmt->execute();
        $this->setIdSalle($pdo->lastInsertId());
    }

    /**
     * Met à jour un membre dans la BDD
     */
    private function update()
    {
        $pdo = Cnx::getInstance();
        $query = 'UPDATE membre SET '
            . 'nom = :nom, prenom = :prenom, email = :email, pseudo = :pseudo'
            . (!empty($this->password) ? ', mdp = :mdp' : '') . ', civilite = :civilite, statut = :statut'
            . ' WHERE id_membre = ' . $this->id;

        $pdo->exec($query);
    }

    /**
     * Génère le nom et upload la photo
     * @param $photo
     * @return string
     */
    private static function uploadPhoto($photo)
    {
        $extension = substr($photo['name'], strrpos($photo['name'], '.'));
        $nomPhoto = md5(time()) . $extension;
        move_uploaded_file($photo['tmp_name'], kFramework::getRacineWeb() . 'web/uploads/' . $nomPhoto);
        return $nomPhoto;
    }

    /**
     * Retourne la liste des catégories
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
    public static function fetchAll($array = false)
    {
        $stmt = Cnx::getInstance()->query('SELECT * FROM salle');

        if ($array) {
            $salles = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
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
        }


        return $salles;
    }

    /**
     * Recupère la salle correspondant a un id_salle
     * @param null|int $id_salle
     * @return array
     */
    public static function fetch($id_salle = null)
    {
        $salle = Cnx::getInstance()
            ->query('SELECT * FROM salle WHERE id_salle =' . (int)$id_salle)
            ->fetch(\PDO::FETCH_ASSOC)
        ;
        return $salle;
    }

    /**
     * Instancie et retourne une salle
     * @param array $salle
     * @param array $liste_avis
     * @return Salle
     */
    public static function createSalle($salle, $liste_avis)
    {

        $salle = new self(array(
            'id_salle'      => $salle['id_salle'],
            'titre'         => $salle['titre'],
            'description'   => $salle['description'],
            'photo'         => $salle['photo'],
            'pays'          => $salle['pays'],
            'ville'         => $salle['ville'],
            'adresse'       => $salle['adresse'],
            'cp'            => $salle['cp'],
            'capacite'      => $salle['capacite'],
            'categorie'     => $salle['categorie'],
            'avis'          => $liste_avis
        ));
        return $salle;
    }
}