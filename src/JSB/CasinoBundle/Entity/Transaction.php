<?php

namespace JSB\CasinoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JSB\CasinoBundle\Entity\TransactionRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 */
class Transaction {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\Column(name="dateHeure", type="datetime")
     */
    private $dateHeure;

    /**
     * @ORM\ManyToOne(targetEntity="Personne", inversedBy="transactions")
     */
    private $personne;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set montant
     *
     * @param float $montant
     * @return Transaction
     */
    public function setMontant($montant) {
        $this->montant = round($montant, 2);

        return $this;
    }

    /**
     * Get montant
     *
     * @return float 
     */
    public function getMontant() {
        return round($this->montant, 2);
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Transaction
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set personne
     *
     * @param \JSB\CasinoBundle\Entity\Personne $personne
     * @return Transaction
     */
    public function setPersonne(\JSB\CasinoBundle\Entity\Personne $personne = null) {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne
     *
     * @return \JSB\CasinoBundle\Entity\Personne 
     */
    public function getPersonne() {
        return $this->personne;
    }

    /**
     * Set dateHeure
     *
     * @param \DateTime $dateHeure
     * @return Transaction
     */
    public function setDateHeure($dateHeure) {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    /**
     * Get dateHeure
     *
     * @return \DateTime 
     */
    public function getDateHeure() {
        return $this->dateHeure;
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist() {
        $this->setDateHeure(new \DateTime());
    }

}
