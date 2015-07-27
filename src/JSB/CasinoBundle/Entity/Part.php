<?php

namespace JSB\CasinoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Part
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JSB\CasinoBundle\Entity\PartRepository")
 */
class Part
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
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="parts")
     */
    private $entreprise;
    
    /**
     * @ORM\ManyToOne(targetEntity="Personne", inversedBy="parts")
     */
    private $proprietaire;


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
     * Set entreprise
     *
     * @param \JSB\CasinoBundle\Entity\Entreprise $entreprise
     * @return Part
     */
    public function setEntreprise(\JSB\CasinoBundle\Entity\Entreprise $entreprise = null)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return \JSB\CasinoBundle\Entity\Entreprise 
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * Set proprietaire
     *
     * @param \JSB\CasinoBundle\Entity\Personne $proprietaire
     * @return Part
     */
    public function setProprietaire(\JSB\CasinoBundle\Entity\Personne $proprietaire = null)
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    /**
     * Get proprietaire
     *
     * @return \JSB\CasinoBundle\Entity\Personne 
     */
    public function getProprietaire()
    {
        return $this->proprietaire;
    }
}
