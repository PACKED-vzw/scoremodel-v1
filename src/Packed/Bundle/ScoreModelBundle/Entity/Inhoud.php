<?php

namespace Packed\Bundle\ScoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Packed\Bundle\ScoreModelBundle\Entity\Inhoud
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Packed\Bundle\ScoreModelBundle\Entity\InhoudRepository")
 */
class Inhoud
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $naam
     *
     * @ORM\Column(name="naam", type="string", length=255)
     */
    private $naam;


    /**
     * @var string $waarde
     *
     * @ORM\Column(name="waarde", type="text")
     */
    private $waarde;

    /**
     * @var string $waarde_en
     *
     * @ORM\Column(name="waarde_en", type="text")
     */
    private $waarde_en;


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
     * Set naam
     *
     * @param string $naam
     * @return Inhoud
     */
    public function setNaam($naam)
    {
        $this->naam = $naam;
    
        return $this;
    }

    /**
     * Get naam
     *
     * @return string 
     */
    public function getNaam()
    {
        return $this->naam;
    }




    /**
     * Set waarde
     *
     * @param string $waarde
     * @return Inhoud
     */
    public function setWaarde($waarde)
    {
        $this->waarde = $waarde;
    
        return $this;
    }

    /**
     * Get waarde
     *
     * @return string 
     */
    public function getWaarde()
    {
        return $this->waarde;
    }

    /**
     * Set waarde_en
     *
     * @param string $waardeEn
     * @return Inhoud
     */
    public function setWaardeEn($waardeEn)
    {
        $this->waarde_en = $waardeEn;
    
        return $this;
    }

    /**
     * Get waarde_en
     *
     * @return string 
     */
    public function getWaardeEn()
    {
        return $this->waarde_en;
    }
}
