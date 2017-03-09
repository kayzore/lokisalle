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
     * @return $this
     */
    public function setIdAvis($id_avis)
    {
        $this->id_avis = $id_avis;

        return $this;
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
     * @return $this
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
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
     * @return $this
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
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
     * @return $this
     */
    public function setDateEnregistrement($date_enregistrement)
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
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
     * @return $this
     */
    public function setMembre($membre)
    {
        $this->membre = $membre;

        return $this;
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
     * @return $this
     */
    public function setSalle($salle)
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * Récupère la liste de tous les avis
     * @return array
     */
    public static function fetchAll()
    {
        $query = 'SELECT * FROM avis a JOIN membre m USING(id_membre) JOIN salle USING(id_salle)';
        $stmtAvis = Cnx::getInstance()->query($query);
        $liste_avis = self::createAvis($stmtAvis->fetchAll(\PDO::FETCH_ASSOC));

        return $liste_avis;
    }

    /**
     * Recupère les avis correspondant a un id_avis ou un id_membre ou un id_salle
     * @param null|int $id_avis
     * @param null|int $id_membre
     * @param null|int $id_salle
     * @return array
     */
    public static function fetch($id_avis = null, $id_membre = null, $id_salle = null)
    {
        $query = 'SELECT * FROM avis LEFT JOIN membre USING(id_membre)';
        if (!is_null($id_avis)) {
            $query .= 'WHERE id_salle =' . (int)$id_avis;
        } elseif (!is_null($id_membre)) {
            $query .= 'WHERE id_salle =' . (int)$id_membre;
        } elseif (!is_null($id_salle)) {
            $query .= 'WHERE id_salle =' . (int)$id_salle;
        }

        $stmtAvis = Cnx::getInstance()->query($query);

        return $stmtAvis->fetchAll(\PDO::FETCH_ASSOC);
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
            $membre_informations = array(
                'id_membre' => $avis['id_membre'],
                'pseudo'    => $avis['pseudo'],
                'nom'       => $avis['nom'],
                'prenom'    => $avis['prenom'],
                'email'     => $avis['email'],
                'civilite'  => $avis['civilite'],
                'statut'    => $avis['statut'],
            );
            $avis_objet[] = new Avis(array(
                'id_avis'               => $avis['id_avis'],
                'commentaire'           => $avis['commentaire'],
                'note'                  => $avis['note'],
                'date_enregistrement'   => $avis['date_enregistrement'],
                'salle'                 => $avis['id_salle'],
                'membre'                => Membre::createMembre($membre_informations)
                )
            );
        }
        return $avis_objet;
    }
}