<?php

namespace Packed\Bundle\ScoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Packed\Bundle\ScoreModelBundle\Entity\Eis
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Packed\Bundle\ScoreModelBundle\Entity\EisRepository")
 */
class Eis
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
     * @var string $context
     *
     * @ORM\Column(name="context", type="text", nullable=true)
     */
    private $context;

    /**
     * @var string $context_en
     *
     * @ORM\Column(name="context_en", type="text", nullable=true)
     */
    private $context_en;

    /**
     * @var string $risico
     *
     * @ORM\Column(name="risico", type="text", nullable=true)
     */
    private $risico;

    /**
     * @var string $risico_en
     *
     * @ORM\Column(name="risico_en", type="text", nullable=true)
     */
    private $risico_en;

    /**
     * @var string $voorbeeld
     *
     * @ORM\Column(name="voorbeeld", type="text", nullable=true)
     */
    private $voorbeeld;

    /**
     * @var string $voorbeeld_en
     *
     * @ORM\Column(name="voorbeeld_en", type="text", nullable=true)
     */
    private $voorbeeld_en;

    /**
     * @var string $bronnen
     *
     * @ORM\Column(name="bronnen", type="text", nullable=true)
     */
    private $bronnen;

    /**
     * @var string $bronnen_en
     *
     * @ORM\Column(name="bronnen_en", type="text", nullable=true)
     */
    private $bronnen_en;


    /**
     * @var string $risiconiveau
     *
     * @ORM\Column(name="risiconiveau", type="string", length=255, nullable=true)
     */
    private $risiconiveau;


    /**
     * @var string $actie
     *
     * @ORM\Column(name="actie", type="text", nullable=true)
     */
    private $actie;

    /**
     * @var string $actie_en
     *
     * @ORM\Column(name="actie_en", type="text", nullable=true)
     */
    private $actie_en;

    /**
     * @var string $oaisMagenta
     *
     * @ORM\Column(name="oaisMagenta", type="string", length=255, nullable=true)
     */
    private $oaisMagenta;


    /**
     * @var string $opmerkingen
     *
     * @ORM\Column(name="opmerkingen", type="text", nullable=true)
     */
    private $opmerkingen;


    /**
     * @var integer $volgorde
     *
     * @ORM\Column(name="volgorde", type="smallint")
     */
    private $volgorde;



    /**
     * @ORM\ManyToOne(targetEntity="Packed\Bundle\ScoreModelBundle\Entity\Sectie", inversedBy="eisen")
     * @ORM\JoinColumn(name="sectie_id", referencedColumnName="id")
     */
    protected $sectie;


    /**
     * Set sectie
     *
     * @param Sectie $gebruiker
     */
    public function setSectie(\Packed\Bundle\ScoreModelBundle\Entity\Sectie $sectie = null)
    {
        $this->sectie = $sectie;
    }

    /**
     * Get sectie
     *
     * @return Sectie
     */
    public function getSectie()
    {
        return $this->sectie;
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
     * @return Eis
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
     * @return Eis
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
     * Set context
     *
     * @param string $context
     * @return Eis
     */
    public function setContext($context)
    {
        $this->context = $context;
    
        return $this;
    }

    /**
     * Get context
     *
     * @return string 
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set context_en
     *
     * @param string $contextEn
     * @return Eis
     */
    public function setContextEn($contextEn)
    {
        $this->context_en = $contextEn;
    
        return $this;
    }

    /**
     * Get context_en
     *
     * @return string 
     */
    public function getContextEn()
    {
        return $this->context_en;
    }

    /**
     * Set risico
     *
     * @param string $risico
     * @return Eis
     */
    public function setRisico($risico)
    {
        $this->risico = $risico;
    
        return $this;
    }

    /**
     * Get risico
     *
     * @return string 
     */
    public function getRisico()
    {
        return $this->risico;
    }

    /**
     * Set risico_en
     *
     * @param string $risicoEn
     * @return Eis
     */
    public function setRisicoEn($risicoEn)
    {
        $this->risico_en = $risicoEn;
    
        return $this;
    }

    /**
     * Get risico_en
     *
     * @return string 
     */
    public function getRisicoEn()
    {
        return $this->risico_en;
    }

    /**
     * Set voorbeeld
     *
     * @param string $voorbeeld
     * @return Eis
     */
    public function setVoorbeeld($voorbeeld)
    {
        $this->voorbeeld = $voorbeeld;
    
        return $this;
    }

    /**
     * Get voorbeeld
     *
     * @return string 
     */
    public function getVoorbeeld()
    {
        return $this->voorbeeld;
    }

    /**
     * Set voorbeeld_en
     *
     * @param string $voorbeeldEn
     * @return Eis
     */
    public function setVoorbeeldEn($voorbeeldEn)
    {
        $this->voorbeeld_en = $voorbeeldEn;
    
        return $this;
    }

    /**
     * Get voorbeeld_en
     *
     * @return string 
     */
    public function getVoorbeeldEn()
    {
        return $this->voorbeeld_en;
    }




    /**
     * Set bronnen
     *
     * @param string $bronnen
     * @return Eis
     */
    public function setBronnen($bronnen)
    {
        $this->bronnen = $bronnen;

        return $this;
    }

    /**
     * Get bronnen
     *
     * @return string
     */
    public function getBronnen()
    {
        return $this->bronnen;
    }

    /**
     * Set bronnen_en
     *
     * @param string $bronnenEn
     * @return Eis
     */
    public function setBronnenEn($bronnenEn)
    {
        $this->bronnen_en = $bronnenEn;

        return $this;
    }

    /**
     * Get bronnen_en
     *
     * @return string
     */
    public function getBronnenEn()
    {
        return $this->bronnen_en;
    }


    /**
     * Set risiconiveau
     *
     * @param string $risiconiveau
     * @return Eis
     */
    public function setRisiconiveau($risiconiveau)
    {
        $this->risiconiveau = $risiconiveau;
    
        return $this;
    }

    /**
     * Get risiconiveau
     *
     * @return string
     */
    public function getRisiconiveau()
    {
        return $this->risiconiveau;
    }


    /**
     * Set actie
     *
     * @param string $actie
     * @return Eis
     */
    public function setActie($actie)
    {
        $this->actie = $actie;
    
        return $this;
    }

    /**
     * Get actie
     *
     * @return string 
     */
    public function getActie()
    {
        return $this->actie;
    }



    /**
     * Set opmerkingen
     *
     * @param string $opmerkingen
     * @return Eis
     */
    public function setOpmerkingen($opmerkingen)
    {
        $this->opmerkingen = $opmerkingen;

        return $this;
    }

    /**
     * Get opmerkingen
     *
     * @return string
     */
    public function getOpmerkingen()
    {
        return $this->opmerkingen;
    }



    /**
     * Set actie_en
     *
     * @param string $actieEn
     * @return Eis
     */
    public function setActieEn($actieEn)
    {
        $this->actie_en = $actieEn;
    
        return $this;
    }

    /**
     * Get actie_en
     *
     * @return string 
     */
    public function getActieEn()
    {
        return $this->actie_en;
    }

    /**
     * Set oaisMagenta
     *
     * @param string $oaisMagenta
     * @return Eis
     */
    public function setOaisMagenta($oaisMagenta)
    {
        $this->oaisMagenta = $oaisMagenta;
    
        return $this;
    }

    /**
     * Get oaisMagenta
     *
     * @return string 
     */
    public function getOaisMagenta()
    {
        return $this->oaisMagenta;
    }

    /**
     * Set volgorde
     *
     * @param integer $volgorde
     * @return Eis
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


    public function __toString(){

        return $this->getWaarde() . " / " . $this->getWaardeEn();
    }
}
