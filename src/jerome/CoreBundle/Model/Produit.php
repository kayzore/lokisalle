<?php
namespace jerome\CoreBundle\Model;


use kayzore\bundle\KBundle\Cnx;

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
     * @return $this
     */
    public function setIdProduit($id_produit)
    {
        $this->id_produit = $id_produit;

        return $this;
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
     * @return $this
     */
    public function setDateArrivee($date_arrivee)
    {
        $this->date_arrivee = $date_arrivee;

        return $this;
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
     * @return $this
     */
    public function setDateDepart($date_depart)
    {
        $this->date_depart = $date_depart;

        return $this;
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
     * @return $this
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
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
     * @return $this
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

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
     * @return array
     */
    public static function getListeEtats()
    {
        return self::$liste_etats;
    }

    /**
     * Récupère et retourne la liste de tout les produits au format objet
     * @param string $where
     * @param string|null $order_by_colum
     * @param string $order_by_style
     * @param int $limit
     * @param string $group_by
     * @return array
     */
    public static function fetchAll($where = null, $order_by_colum = null, $order_by_style = 'ASC', $limit = null, $group_by = null)
    {
        $query = 'SELECT * FROM produit p JOIN salle s USING(id_salle)';
        if (!is_null($where)) {
            $query .= ' ' . $where;
        }
        if (!is_null($group_by)) {
            $query .= ' GROUP BY ' . $group_by;
        }
        if (!is_null($order_by_colum)) {
            $query .= ' ORDER BY ' . $order_by_colum . ' ' . $order_by_style;
        }
        if (!is_null($limit)) {
            $query .= ' LIMIT ' . $limit;
        }
        $stmtProduit = Cnx::getInstance()->query($query);
        $produits = [];
        foreach ($stmtProduit->fetchAll(\PDO::FETCH_ASSOC) as $produit) {
            $produits[] = self::createProduit($produit, Avis::fetch(null, null, $produit['id_salle']));
        }

        return $produits;
    }

    /**
     * Récupère un produit, l'instancie et le retourne
     * @param int $id_produit
     * @return Produit
     */
    public static function fetch($id_produit)
    {
        $stmtProduit = Cnx::getInstance()->query('SELECT * FROM produit p JOIN salle s USING(id_salle) WHERE p.id_produit = ' . (int)$id_produit);
        $produit = $stmtProduit->fetch(\PDO::FETCH_ASSOC);
        $stmtAvis = Cnx::getInstance()->query('SELECT * FROM avis LEFT JOIN membre USING(id_membre) WHERE id_salle =' . (int)$produit['id_salle']);
        $liste_avis = $stmtAvis->fetchAll(\PDO::FETCH_ASSOC);
        return self::createProduit($produit, $liste_avis);
    }

    /**
     * Instancie et retourne un produit
     * @param array $produit
     * @param array $liste_avis
     * @return Produit
     */
    public static function createProduit($produit, $liste_avis)
    {
        $avis_objet = [];
        if (!is_null($liste_avis) && count($liste_avis) > 0) {
            $avis_objet = Avis::createAvis($liste_avis);
        }
        $produit = new self(array(
            'id_produit'    => $produit['id_produit'],
            'date_arrivee'  => $produit['date_arrivee'],
            'date_depart'   => $produit['date_depart'],
            'prix'          => $produit['prix'],
            'etat'          => $produit['etat'],
            'salle'         => new Salle(array(
                'id_salle'      => $produit['id_salle'],
                'titre'         => $produit['titre'],
                'description'   => $produit['description'],
                'photo'         => $produit['photo'],
                'pays'          => $produit['pays'],
                'ville'         => $produit['ville'],
                'adresse'       => $produit['adresse'],
                'cp'            => $produit['cp'],
                'capacite'      => $produit['capacite'],
                'categorie'     => $produit['categorie'],
                'avis'          => $avis_objet
            ))
        ));
        return $produit;
    }
}