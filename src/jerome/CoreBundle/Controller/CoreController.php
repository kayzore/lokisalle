<?php
namespace src\jerome\CoreBundle\Controller;


use jerome\CoreBundle\Model\Avis;
use jerome\CoreBundle\Model\Commande;
use jerome\CoreBundle\Model\Membre;
use jerome\CoreBundle\Model\Produit;
use jerome\CoreBundle\Model\Salle;
use kayzore\bundle\KBundle\Controller;
use kayzore\bundle\Utils\FlashMessage;

class CoreController extends Controller
{
    public function homeAction()
    {
        echo $this->twig->render('front/accueil.html.twig', array(
            'produits' => Produit::fetchAll(null, 'id_produit', 'DESC')
        ));
    }

    public function inscriptionAction()
    {
        // Inscription
        echo $this->twig->render('front/inscription.html.twig');
    }

    public function executeInscriptionAction()
    {
        $membre = new Membre();
        $errors = [];
        if (!empty($_POST)) {
            $membre
                ->setPseudo($_POST['pseudoInput'])
                ->setNom($_POST['nomInput'])
                ->setPrenom($_POST['prenomInput'])
                ->setEmail($_POST['emailInput'])
                ->setCivilite($_POST['civiliteSelect'])
                ->setPassword($_POST['passwordInput'])
            ;

            if (!Membre::validatePseudo($_POST['pseudoInput'], $msg)) {
                $errors['pseudoInput'] = $msg;
            }

            if (!Membre::validateNom($_POST['nomInput'], $msg)) {
                $errors['nomInput'] = $msg;
            }

            if (!Membre::validatePrenom($_POST['prenomInput'], $msg)) {
                $errors['prenomInput'] = $msg;
            }

            if (!Membre::validateEmail($_POST['emailInput'], $msg)) {
                $errors['emailInput'] = $msg;
            }

            if (!Membre::validatePassword($_POST['passwordInput'], $msg)) {
                $errors['passwordInput'] = $msg;
            }

            if (empty($errors)) {
                $membre->save();
                FlashMessage::set("Inscription effectuée, vous pouvez maintenant vous connecter");
                $this->redirect('public.ls_connexion');
            } else {
                $errors['champValue'] = $_POST;
                FlashMessage::set('Le formulaire contient des erreurs', 'error', $errors);
                $this->redirect('public.ls_inscription');
            }
        }
    }

    public function connexionAction()
    {
        if (Membre::isConnected()) {
            $this->redirect('public.ls_homepage');
        }
        // Connexion
        echo $this->twig->render('front/connexion.html.twig');
    }

    public function executeConnexionAction()
    {
        // Execute Connexion
        $membre = new Membre();
        $errors = [];
        if (!empty($_POST)) {
            $membre
                ->setPseudo($_POST['pseudoInput'])
                ->setPassword($_POST['passwordInput'])
            ;

            if (!Membre::validatePseudo($_POST['pseudoInput'], $msg, true)) {
                $errors['pseudoInput'] = $msg;
            }

            if (!Membre::validatePassword($_POST['passwordInput'], $msg, true)) {
                $errors['passwordInput'] = $msg;
            }

            if (empty($errors)) {
                if (!$membre->connexion()) {
                    FlashMessage::set('Erreur lors de la connexion, vérifier vos identifiants', 'error');
                }
            } else {
                $errors['champValue'] = $_POST;
                FlashMessage::set('Le formulaire contient des erreurs', 'error', $errors);
            }
            $this->redirect('public.ls_connexion');
        }
    }

    public function deconnexionAction()
    {
        Membre::deconnexion();
        $this->redirect('public.ls_connexion');
    }

    public function voirProduitAction($id_produit)
    {
        echo $this->twig->render('front/produit.html.twig', array(
            'produit'           => Produit::fetch($id_produit),
            'autres_produits'   => Produit::fetchAll('WHERE NOT id_produit = ' . (int)$id_produit, 'id_produit', 'DESC', 4, 'p.id_produit')
        ));
    }

    public function adminHomeAction()
    {
        echo $this->twig->render('back/accueil.html.twig', array(
            'nb_avis'       => count(Avis::fetchAll()),
            'nb_membres'    => count(Membre::fetchAll()),
            'nb_commandes'  => count(Commande::fetchAll())
        ));
    }

    public function adminSallesAction()
    {
        echo $this->twig->render('back/salles.html.twig', array(
            'liste_salles' => Salle::fetchAll()
        ));
    }

    public function adminSallesAddAction()
    {
        if ($this->isXmlHttpRequest()) {
            echo 'ok';
        }
    }

    public function adminProduitsAction()
    {
        echo $this->twig->render('back/produits.html.twig', array(
            'liste_produits' => Produit::fetchAll()
        ));
    }

    public function adminMembresAction()
    {
        echo $this->twig->render('back/membres.html.twig', array(
            'liste_membres' => Membre::fetchAll()
        ));
    }
}