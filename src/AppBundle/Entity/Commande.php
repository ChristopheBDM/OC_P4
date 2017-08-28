<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reza", type="date")
     */
    private $datereza;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="random", type="string", length=255)
     */
    private $random;

    /**
     * @var boolean
     *
     * @ORM\Column(name="payed", type="boolean")
     */
    private $payed;

    /**
     * @ORM\OneToMany(targetEntity="Billet", mappedBy="commande", cascade={"persist"})
     */
    private $billets;

    public function __construct()
    {
        $this->billets = new ArrayCollection();
        $this->date = new \DateTime();
    }

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
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return \DateTime
     */
    public function getDatereza()
    {
        return $this->datereza;
    }

    /**
     * @param \DateTime $datereza
     */
    public function setDatereza($datereza)
    {
        $this->datereza = $datereza;
    }

    /**
     * @return Billet[]
     */
    public function getBillets()
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet)
    {
        $billet->setCommande($this);
        $this->billets->add($billet);
    }

    public function removeBillet(Billet $billet)
    {
        $this->billets->removeElement($billet);
    }

    public function getPrixTotal()
    {
        $montantTotal = 0;

        foreach ( $this->getBillets() as $billet)
        {
            $montantTotal += $billet->getPrixBillet();
        }
        return $montantTotal;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getRandom()
    {
        return $this->random;
    }

    /**
     * @param mixed $random
     */
    public function setRandom($random)
    {
        $this->random = $random;
    }

    /**
     * @return bool
     */
    public function isPayed()
    {
        return $this->payed;
    }

    /**
     * @param bool $payed
     */
    public function setPayed($payed)
    {
        $this->payed = $payed;
    }
}

