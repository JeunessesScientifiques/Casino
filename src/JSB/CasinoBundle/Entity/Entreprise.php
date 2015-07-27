<?php

namespace JSB\CasinoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprise
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JSB\CasinoBundle\Entity\EntrepriseRepository")
 */
class Entreprise
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
     * @ORM\Column(name="valeur", type="float")
     */
    private $valeur;
    
    /**
     * @ORM\OneToMany(targetEntity="Part", mappedBy="entreprise")
     */
    private $parts;

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
     * @return Entreprise
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
     * Set valeur
     *
     * @param float $valeur
     * @return Entreprise
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return float 
     */
    public function getValeur()
    {
        return $this->valeur;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add parts
     *
     * @param \JSB\CasinoBundle\Entity\Part $parts
     * @return Entreprise
     */
    public function addPart(\JSB\CasinoBundle\Entity\Part $parts)
    {
        $this->parts[] = $parts;

        return $this;
    }

    /**
     * Remove parts
     *
     * @param \JSB\CasinoBundle\Entity\Part $parts
     */
    public function removePart(\JSB\CasinoBundle\Entity\Part $parts)
    {
        $this->parts->removeElement($parts);
    }

    /**
     * Get parts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParts()
    {
        return $this->parts;
    }
    
    public function getPartRestantes(){
        return 10 - count($this->getParts());
    }   
}
