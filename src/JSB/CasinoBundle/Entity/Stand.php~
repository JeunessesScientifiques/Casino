<?php

namespace JSB\CasinoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stand
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JSB\CasinoBundle\Entity\StandRepository")
 */
class Stand
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="prixAchat", type="float")
     */
    private $prixAchat;

    /**
     * @var float
     *
     * @ORM\Column(name="prixLocation", type="float")
     */
    private $prixLocation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Stand
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prixAchat
     *
     * @param float $prixAchat
     * @return Stand
     */
    public function setPrixAchat($prixAchat)
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    /**
     * Get prixAchat
     *
     * @return float 
     */
    public function getPrixAchat()
    {
        return $this->prixAchat;
    }

    /**
     * Set prixLocation
     *
     * @param float $prixLocation
     * @return Stand
     */
    public function setPrixLocation($prixLocation)
    {
        $this->prixLocation = $prixLocation;

        return $this;
    }

    /**
     * Get prixLocation
     *
     * @return float 
     */
    public function getPrixLocation()
    {
        return $this->prixLocation;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Stand
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
