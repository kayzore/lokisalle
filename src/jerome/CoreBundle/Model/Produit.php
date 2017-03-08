<?php
namespace jerome\CoreBundle\Model;


class Produit
{
    /**
     * @var int
     */
    private $id_produit;

    /**
     * @var \DateTime
     */
    private $date_arrivee;

    /**
     * @var \DateTime
     */
    private $date_depart;

    /**
     * @var int
     */
    private $prix;

    /**
     * @var string
     */
    private $etat;

    /**
     * @var \jerome\CoreBundle\Model\Salle
     */
    private $salle;

    /**
     * @var array
     */
    private static $liste_etats = array('Libre', 'Réservation');

    public function __construct(array $produit = null)
    {
        $this->setIdProduit($produit['id_produit']);
        $this->setDateArrivee($produit['date_arrivee']);
        $this->setDateDepart($produit['date_depart']);
        $this->setPrix($produit['prix']);
        $this->setEtat($produit['etat']);
        $this->setSalle($produit['salle']);
    }

    /**
     * @return int
     */
    public function getIdProduit()
    {
        return $this->id_produit;
    }

    /**
     * @param int $id_produit
     */
    public function setIdProduit($id_produit)
    {
        $this->id_produit = $id_produit;
    }

    /**
     * @return \DateTime
     */
    public function getDateArrivee()
    {
        return $this->date_arrivee;
    }

    /**
     * @param \DateTime $date_arrivee
     */
    public function setDateArrivee($date_arrivee)
    {
        $this->date_arrivee = $date_arrivee;
    }

    /**
     * @return \DateTime
     */
    public function getDateDepart()
    {
        return $this->date_depart;
    }

    /**
     * @param \DateTime $date_depart
     */
    public function setDateDepart($date_depart)
    {
        $this->date_depart = $date_depart;
    }

    /**
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param int $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
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

    /**
     * @return array
     */
    public static function getListeEtats()
    {
        return self::$liste_etats;
    }
}