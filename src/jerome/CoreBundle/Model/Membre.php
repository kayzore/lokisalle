<?php
namespace jerome\CoreBundle\Model;


use kayzore\bundle\KBundle\Cnx;
use kayzore\bundle\KBundle\Membre as MembreInterface;

class Membre implements MembreInterface
{
    private $id;
    private $pseudo;
    private $password;
    private $nom;
    private $prenom;
    private $email;
    private $civilite;
    private $statut;

    public function __construct(array $membre)
    {
        $this->setId($membre['id']);
        $this->setPseudo($membre['pseudo']);
        $this->setNom($membre['nom']);
        $this->setPrenom($membre['prenom']);
        $this->setEmail($membre['email']);
        $this->setCivilite($membre['civilite']);
        $this->setStatut($membre['statut']);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param string $pseudo
     * @return $this
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return $this
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     * @return $this
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @param string $civilite
     * @return $this
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param int $statut
     * @return $this
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    public function connectAccount()
    {
        
    }

    /**
     * Récupère et retourne la liste de tout les membres au format objet
     * @return array
     */
    public static function fetchAll()
    {
        $stmt = Cnx::getInstance()->query('SELECT * FROM membre');
        $membres = [];

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $membre) {
            $membres[] = new self(array(
                'id'        => $membre['id_membre'],
                'pseudo'    => $membre['pseudo'],
                'nom'       => $membre['nom'],
                'prenom'    => $membre['prenom'],
                'email'     => $membre['email'],
                'civilite'  => $membre['civilite'],
                'statut'    => $membre['statut']
            ));
        }

        return $membres;
    }
}