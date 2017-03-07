<?php
namespace jerome\CoreBundle\Model;


use kayzore\bundle\KBundle\Cnx;
use kayzore\bundle\KBundle\KFramework;
use kayzore\bundle\KBundle\Membre as MembreInterface;

class Membre implements MembreInterface
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $pseudo
     */
    private $pseudo;
    /**
     * @var string $password
     */
    private $password;
    /**
     * @var string $nom
     */
    private $nom;
    /**
     * @var string $prenom
     */
    private $prenom;
    /**
     * @var string $email
     */
    private $email;
    /**
     * @var string $civilite
     */
    private $civilite;
    /**
     * @var int $statut
     */
    private $statut;

    /**
     * Membre constructor.
     * @param array|null $membre
     */
    public function __construct(array $membre = null)
    {
        $this->setId($membre['id']);
        $this->setPseudo($membre['pseudo']);
        $this->setNom($membre['nom']);
        $this->setPrenom($membre['prenom']);
        $this->setEmail($membre['email']);
        $this->setCivilite($membre['civilite']);
        $this->setId($membre['id']);
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

    /**
     * Effectue les validations du pseudo
     * @param string $pseudo
     * @param string $msg
     * @return bool
     */
    public static function validatePseudo($pseudo, &$msg)
    {
        if (empty($pseudo)) {
            $msg = 'Le pseudo est obligatoire.';
            return false;
        } elseif (!preg_match('/^[[:alnum:]_-]{6,20}$/', $pseudo)) {
            $msg = 'Le pseudo doit faire entre 6 et 20 caractères et ne contenir que des lettres, des chiffres, _ ou -.';
            return false;
        } else {
            $pdo = Cnx::getInstance();
            $stmt = $pdo->query('SELECT COUNT(*) FROM membre WHERE pseudo = ' . $pdo->quote($pseudo));

            if ($stmt->fetchColumn() != 0) {
                $msg = 'Ce pseudo éxiste déjà.';
                return false;
            }
        }

        return true;
    }

    /**
     * Effectue les validations du nom
     * @param string $nom
     * @param string $msg
     * @return bool
     */
    public static function validateNom($nom, &$msg)
    {
        if (empty($nom)) {
            $msg = 'Le nom est obligatoire.';
            return false;
        } elseif (strlen($nom) > 20) {
            $msg = 'Le nom ne doit pas faire plus de 20 charactères.';
            return false;
        }

        return true;
    }

    /**
     * Effectue les validations du prénom
     * @param string $prenom
     * @param string $msg
     * @return bool
     */
    public static function validatePrenom($prenom, &$msg)
    {
        if (empty($prenom)) {
            $msg = 'Le prénom est obligatoire.';
            return false;
        } elseif (strlen($prenom) > 20) {
            $msg = 'Le prénom ne doit pas faire plus de 20 charactères.';
            return false;
        }

        return true;
    }

    /**
     * Effectue les validations de l'email
     * @param string $email
     * @param string $msg
     * @return bool
     */
    public static function validateEmail($email, &$msg)
    {
        if (empty($email)) {
            $msg = "L'email est obligatoire.";
            return false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "L'email n'est pas valide";
            return false;
        } elseif (strlen($email) > 50) {
            $msg = "L'email ne doit pas faire plus de 50 charactères";
            return false;
        } else {
            $pdo = Cnx::getInstance();
            $stmt = $pdo->query('SELECT COUNT(*) FROM membre WHERE email = ' . $pdo->quote($email));

            if ($stmt->fetchColumn() != 0) {
                $msg = 'Cet email éxiste déjà.';
                return false;
            }
        }

        return true;
    }

    /**
     * Effectue les validations du mot de passe
     * @param string $password
     * @param string $msg
     * @return bool
     */
    public static function validatePassword($password, &$msg)
    {
        if (empty($password)) {
            $msg = "Le mot de passe est obligatoire.";
            return false;
        } elseif (strlen($password) < 6 || strlen($password) > 60) {
            $msg = "Le mot de passe doit être supérieure à 6 caractères et inférieure à 60";
            return false;
        }

        return true;
    }

    /**
     * Tente de connecter un utilisateur et retourne soit un membre soit null
     * @param $pseudo
     * @param $password
     * @return Membre|null
     */
    public static function connexion($pseudo, $password)
    {
        if (is_null($_SESSION[kFramework::getProjectAlias() . '_utilisateur'])) {
            $stmt = Cnx::getInstance()->prepare('SELECT *, count(id_membre) as nb_membre FROM membre WHERE pseudo = :pseudo AND mdp = :mdp');
            $stmt->bindParam('pseudo', $pseudo, \PDO::PARAM_STR);
            $stmt->bindValue('mdp', md5($password), \PDO::PARAM_STR);
            $stmt->execute();
            $membre = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($membre['nb_membre'] == '1') {
                unset($membre['mdp']);
                unset($membre['nb_membre']);
                $_SESSION[kFramework::getProjectAlias() . '_utilisateur'] = $membre;
                return new self(array(
                    'id'        => $membre['id_membre'],
                    'pseudo'    => $membre['pseudo'],
                    'nom'       => $membre['nom'],
                    'prenom'    => $membre['prenom'],
                    'email'     => $membre['email'],
                    'civilite'  => $membre['civilite'],
                    'statut'    => $membre['statut']
                ));
            }
            return null;
        }
        return $_SESSION[kFramework::getProjectAlias() . '_utilisateur'];
    }

    /**
     * Deconnecte un utilisateur s'il est déjà connecté
     */
    public static function deconnexion()
    {
        if (!is_null($_SESSION['ls_utilisateur'])) {
            $_SESSION['ls_utilisateur'] = null;
        }
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