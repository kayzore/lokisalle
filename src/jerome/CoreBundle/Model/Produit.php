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
     * @return array
     */
    public static function fetchAll()
    {
        $stmtProduit = Cnx::getInstance()->query('SELECT * FROM produit p JOIN salle s USING(id_salle)');
        $produits = [];
        foreach ($stmtProduit->fetchAll(\PDO::FETCH_ASSOC) as $produit) {
            $stmtAvis = Cnx::getInstance()->query('SELECT * FROM avis LEFT JOIN membre USING(id_membre) WHERE id_salle =' . (int)$produit['id_salle']);
            $liste_avis = $stmtAvis->fetchAll(\PDO::FETCH_ASSOC);
            $avis_objet = [];
            if (!is_null($liste_avis) && count($liste_avis) > 0) {
                foreach ($liste_avis as $avis) {
                    $avis_objet[] = new Avis(array(
                        'id_avis'               => $avis['id_avis'],
                        'commentaire'           => $avis['commentaire'],
                        'note'                  => $avis['note'],
                        'date_enregistrement'   => $avis['date_enregistrement'],
                        'membre'                => new Membre(array(
                            'id'        => $avis['id_membre'],
                            'pseudo'    => $avis['pseudo'],
                            'nom'       => $avis['nom'],
                            'prenom'    => $avis['prenom'],
                            'email'     => $avis['email'],
                            'civilite'  => $avis['civilite'],
                            'statut'    => $avis['statut']
                        )),
                        'salle'                 => $avis['id_salle'],
                    ));
                }
            }

            $produits[] = new self(array(
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
        }

        return $produits;
    }
}