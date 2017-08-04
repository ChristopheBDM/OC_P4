<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Billet
 *
 * @ORM\Table(name="billet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BilletRepository")
 */
class Billet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_client", type="string", length=255)
     */
    private $nomClient;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_client", type="string", length=255)
     */
    private $prenomClient;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255)
     */
    private $pays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reza", type="date")
     */
    private $dateReza;

    /**
     * @var string
     *
     * @ORM\Column(name="type_billet", type="string", length=255)
     */
    private $typeBillet;

    /**
     * @var string
     *
     * @ORM\Column(name="type_tarif", type="string", length=255)
     */
    private $typeTarif;

    /**
     * @var bool
     *
     * @ORM\Column(name="tarif_reduit", type="boolean")
     */
    private $tarifReduit;

    /**
     * @var int
     *
     * @ORM\Column(name="prix_total", type="integer")
     */
    private $prixTotal;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomClient
     *
     * @param string $nomClient
     *
     * @return Billet
     */
    public function setNomClient($nomClient)
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    /**
     * Get nomClient
     *
     * @return string
     */
    public function getNomClient()
    {
        return $this->nomClient;
    }

    /**
     * Set prenomClient
     *
     * @param string $prenomClient
     *
     * @return Billet
     */
    public function setPrenomClient($prenomClient)
    {
        $this->prenomClient = $prenomClient;

        return $this;
    }

    /**
     * Get prenomClient
     *
     * @return string
     */
    public function getPrenomClient()
    {
        return $this->prenomClient;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Billet
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Billet
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Billet
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set dateReza
     *
     * @param \DateTime $dateReza
     *
     * @return Billet
     */
    public function setDateReza($dateReza)
    {
        $this->dateReza = $dateReza;

        return $this;
    }

    /**
     * Get dateReza
     *
     * @return \DateTime
     */
    public function getDateReza()
    {
        return $this->dateReza;
    }

    /**
     * Set typeBillet
     *
     * @param string $typeBillet
     *
     * @return Billet
     */
    public function setTypeBillet($typeBillet)
    {
        $this->typeBillet = $typeBillet;

        return $this;
    }

    /**
     * Get typeBillet
     *
     * @return string
     */
    public function getTypeBillet()
    {
        return $this->typeBillet;
    }

    /**
     * Set typeTarif
     *
     * @param string $typeTarif
     *
     * @return Billet
     */
    public function setTypeTarif($typeTarif)
    {
        $this->typeTarif = $typeTarif;

        return $this;
    }

    /**
     * Get typeTarif
     *
     * @return string
     */
    public function getTypeTarif()
    {
        return $this->typeTarif;
    }

    /**
     * Set tarifReduit
     *
     * @param boolean $tarifReduit
     *
     * @return Billet
     */
    public function setTarifReduit($tarifReduit)
    {
        $this->tarifReduit = $tarifReduit;

        return $this;
    }

    /**
     * Get tarifReduit
     *
     * @return bool
     */
    public function getTarifReduit()
    {
        return $this->tarifReduit;
    }

    /**
     * Set prixTotal
     *
     * @param integer $prixTotal
     *
     * @return Billet
     */
    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    /**
     * Get prixTotal
     *
     * @return int
     */
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }
}

