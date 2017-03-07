<?php
namespace kayzore\bundle\KBundle;


interface Membre
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getPseudo();

    /**
     * @param string $pseudo
     * @return $this
     */
    public function setPseudo($pseudo);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getNom();

    /**
     * @param string $nom
     * @return $this
     */
    public function setNom($nom);

    /**
     * @return string
     */
    public function getPrenom();

    /**
     * @param string $prenom
     * @return $this
     */
    public function setPrenom($prenom);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * @return int
     */
    public function getStatut();

    /**
     * @param int $statut
     * @return $this
     */
    public function setStatut($statut);
}