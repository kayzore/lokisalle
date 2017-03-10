<?php
namespace jerome\CoreBundle\Model;


use kayzore\bundle\KBundle\Cnx;

class Commande
{
    /**
     * @var int
     */
    private $id_commande;

    /**
     * @var \DateTime
     */
    private $date_enregistrement;

    /**
     * @var Membre
     */
    private $membre;

    /**
     * @var Produit
     */
    private $produit;

    public function __construct(array $commande)
    {
        $this->setIdCommande($commande['id_commande']);
        $this->setDateEnregistrement($commande['date_enregistrement']);
        $this->setMembre($commande['membre']);
        $this->setProduit($commande['produit']);
    }

    /**
     * @return int
     */
    public function getIdCommande()
    {
        return $this->id_commande;
    }

    /**
     * @param int $id_commande
     * @return $this
     */
    public function setIdCommande($id_commande)
    {
        $this->id_commande = $id_commande;

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
     * @return Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param Produit $produit
     * @return $this
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Récupère et retourne la liste de toute les commandes au format objet
     * @return array
     */
    public static function fetchAll()
    {
        $query = 'SELECT * FROM commande c JOIN membre m USING(id_membre) JOIN produit p USING(id_produit) JOIN avis USING(id_salle)';
        $stmtCommande = Cnx::getInstance()->query($query);
        $liste_commandes = [];
        foreach ($stmtCommande->fetchAll(\PDO::FETCH_ASSOC) as $commande) {
            $membre_informations = array(
                'id_membre' => $commande['id_membre'],
                'pseudo'    => $commande['pseudo'],
                'nom'       => $commande['nom'],
                'prenom'    => $commande['prenom'],
                'email'     => $commande['email'],
                'civilite'  => $commande['civilite'],
                'statut'    => $commande['statut'],
            );
            $produit_informations = array(
                'id_produit'    => $commande['id_produit'],
                'date_arrivee'  => $commande['date_arrivee'],
                'date_depart'   => $commande['date_depart'],
                'prix'          => $commande['prix'],
                'etat'          => $commande['etat'],
                'salle'         => Salle::createSalle(Salle::fetch($commande['id_salle']), Avis::fetch(null, null, $commande['id_salle']))
            );
            $liste_commandes[] = new self(array(
                'id_commande'           => $commande['id_commande'],
                'date_enregistrement'   => $commande['date_enregistrement'],
                'membre'                => Membre::createMembre($membre_informations),
                'produit'               => Produit::createProduit($produit_informations, Avis::fetch(null, null, $commande['id_salle']))
            ));
        }

        return $liste_commandes;
    }

    /**
     * Recupère la commande correspondant a un id_commande ou un id_produit
     * @param null|int $id_commande
     * @return array
     */
    public static function fetch($id_commande = null)
    {
        $query = 'SELECT * FROM commande LEFT JOIN membre USING(id_membre)';
        if (!is_null($id_commande)) {
            $query .= 'WHERE id_commande =' . (int)$id_commande;
        }

        return Cnx::getInstance()->query($query)->fetch(\PDO::FETCH_ASSOC);
    }
}