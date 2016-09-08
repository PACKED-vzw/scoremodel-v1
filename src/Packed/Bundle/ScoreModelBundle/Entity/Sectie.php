<?php

namespace Packed\Bundle\ScoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Packed\Bundle\ScoreModelBundle\Entity\Sectie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Packed\Bundle\ScoreModelBundle\Entity\SectieRepository")
 */
class Sectie
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
     * @var string $waarde
     *
     * @ORM\Column(name="waarde", type="text", nullable=true)
     */
    private $waarde;

    /**
     * @var string $waarde_en
     *
     * @ORM\Column(name="waarde_en", type="text", nullable=true)
     */
    private $waarde_en;

    /**
     * @var string $intro
     *
     * @ORM\Column(name="intro", type="text", nullable=true)
     */
    private $intro;

    /**
     * @var string $intro_en
     *
     * @ORM\Column(name="intro_en", type="text", nullable=true)
     */
    private $intro_en;

    /**
     * @var integer $volgorde
     *
     * @ORM\Column(name="volgorde", type="smallint", nullable=true)
     */
    private $volgorde;


    /**
     * @ORM\OneToMany(targetEntity="Packed\Bundle\ScoreModelBundle\Entity\Eis", mappedBy="sectie")
     */
    protected $eisen;


    /**
     * Add Eis
     *
     * @param Packed\Bundle\ScoreModelBundle\Entity\Eis $eisen
     */
    public function addEis(Eis $eisen)
    {
        $this->eisen[] = $eisen;
    }

    /**
     * Get eis
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getEisen()
    {
        return $this->eisen;
    }


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
     * Set waarde
     *
     * @param string $waarde
     * @return Sectie
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
     * @return Sectie
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

    /**
     * Set intro
     *
     * @param string $intro
     * @return Sectie
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;
    
        return $this;
    }

    /**
     * Get intro
     *
     * @return string 
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Set intro_en
     *
     * @param string $introEn
     * @return Sectie
     */
    public function setIntroEn($introEn)
    {
        $this->intro_en = $introEn;
    
        return $this;
    }

    /**
     * Get intro_en
     *
     * @return string 
     */
    public function getIntroEn()
    {
        return $this->intro_en;
    }

    /**
     * Set volgorde
     *
     * @param integer $volgorde
     * @return Sectie
     */
    public function setVolgorde($volgorde)
    {
        $this->volgorde = $volgorde;
    
        return $this;
    }

    /**
     * Get volgorde
     *
     * @return integer 
     */
    public function getVolgorde()
    {
        return $this->volgorde;
    }


    public function __construct()
    {
        $this->eisen = new ArrayCollection();
    }

    public function __toString(){

        return $this->getWaarde() . " / " . $this->getWaardeEn();
    }
}
