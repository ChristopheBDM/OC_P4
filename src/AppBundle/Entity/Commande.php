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
}

