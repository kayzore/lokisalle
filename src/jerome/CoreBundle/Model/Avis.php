<?php
namespace jerome\CoreBundle\Model;


use kayzore\bundle\KBundle\Cnx;

class Avis
{
    /**
     * @var int
     */
    private $id_avis;

    /**
     * @var string
     */
    private $commentaire;

    /**
     * @var int
     */
    private $note;

    /**
     * @var \DateTime
     */
    private $date_enregistrement;

    /**
     * @var \jerome\CoreBundle\Model\Membre
     */
    private $membre;

    /**
     * @var \jerome\CoreBundle\Model\Salle
     */
    private $salle;

    public function __construct(array $avis = null)
    {
        $this->setIdAvis($avis['id_avis']);
        $this->setCommentaire($avis['commentaire']);
        $this->setNote($avis['note']);
        $this->setDateEnregistrement($avis['date_enregistrement']);
        $this->setMembre($avis['membre']);
        $this->setSalle($avis['salle']);
    }

    /**
     * @return int
     */
    public function getIdAvis()
    {
        return $this->id_avis;
    }

    /**
     * @param int $id_avis
     */
    public function setIdAvis($id_avis)
    {
        $this->id_avis = $id_avis;
    }

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnregistrement()
    {
        return $this->date_enregistrement;
    }

    /**
     * @param \DateTime $date_enregistrement
     */
    public function setDateEnregistrement($date_enregistrement)
    {
        $this->date_enregistrement = $date_enregistrement;
    }

    /**
     * @return Membre
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * @param Membre $membre
     */
    public function setMembre($membre)
    {
        $this->membre = $membre;
    }

    /**
     * @return Salle
     */
    public function getSalle()
    {
        return $this->salle;
    }

    /**
     * @param Salle $salle
     */
    public function setSalle($salle)
    {
        $this->salle = $salle;
    }

    public static function fetchAll()
    {
        $query = 'SELECT * FROM avis a JOIN membre m USING(id_membre) JOIN salle USING(id_salle)';
        $stmtAvis = Cnx::getInstance()->query($query);
        $liste_avis = self::createAvis($stmtAvis->fetchAll(\PDO::FETCH_ASSOC));

        return $liste_avis;
    }

    /**
     * Retourne un tableau contenant une liste d'avis instancié
     * @param array $liste_avis
     * @return array
     */
    public static function createAvis($liste_avis)
    {
        $avis_objet = [];
        foreach ($liste_avis as $avis) {
            $avis_objet[] = new Avis(array(
                'id_avis'               => $avis['id_avis'],
                'commentaire'           => $avis['commentaire'],
                'note'                  => $avis['note'],
                'date_enregistrement'   => $avis['date_enregistrement'],
                'salle'                 => $avis['id_salle'],
                'membre'                => new Membre(array(
                    'id'        => $avis['id_membre'],
                    'pseudo'    => $avis['pseudo'],
                    'nom'       => $avis['nom'],
                    'prenom'    => $avis['prenom'],
                    'email'     => $avis['email'],
                    'civilite'  => $avis['civilite'],
                    'statut'    => $avis['statut']
                )),
            ));
        }
        return $avis_objet;
    }
}