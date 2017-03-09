<?php
namespace jerome\CoreBundle\Model;


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
}