<?php

namespace Packed\Bundle\ScoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Packed\Bundle\ScoreModelBundle\Entity\Rapport
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Packed\Bundle\ScoreModelBundle\Entity\RapportRepository")
 */
class Rapport
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
     * @ORM\Column(name="naam", type="string", length=255, nullable=true)
     */
    private $naam;

    /**
     * @var string $score
     *
     * @ORM\Column(name="score", type="text", nullable=true)
     */
    private $score;

    /**
     * @var string $grafiek
     *
     * @ORM\Column(name="grafiek", type="string", length=255, nullable=true)
     */
    private $grafiek;

    /**
     * @var \DateTime $datumGeneratie
     *
     * @ORM\Column(name="datumGeneratie", type="datetime")
     */
    private $datumGeneratie;


    /**
     * @ORM\ManyToOne(targetEntity="Packed\Bundle\UserBundle\Entity\User", inversedBy="rapporten")
     * @ORM\JoinColumn(name="gebruiker_id", referencedColumnName="id")
     */
    protected $gebruiker;


    /**
     * Set gebruiker
     *
     * @param User $gebruiker
     */
    public function setGebruiker(\Packed\Bundle\UserBundle\Entity\User $gebruiker)
    {
        $this->gebruiker = $gebruiker;
    }

    /**
     * Get gebruiker
     *
     * @return User
     */
    public function getGebruiker()
    {
        return $this->gebruiker;
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
     * Set naam
     *
     * @param string $naam
     * @return Rapport
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
     * Set score
     *
     * @param string $score
     * @return Rapport
     */
    public function setScore($score)
    {
        $this->score = $score;
    
        return $this;
    }

    /**
     * Get score
     *
     * @return string 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set grafiek
     *
     * @param string $grafiek
     * @return Rapport
     */
    public function setGrafiek($grafiek)
    {
        $this->grafiek = $grafiek;
    
        return $this;
    }

    /**
     * Get grafiek
     *
     * @return string 
     */
    public function getGrafiek()
    {
        return $this->grafiek;
    }

    /**
     * Set datumGeneratie
     *
     * @param \DateTime $datumGeneratie
     *
     */
    public function setDatumGeneratie($datumGeneratie)
    {
        $this->datumGeneratie = $datumGeneratie;

    }

    /**
     * Get datumGeneratie
     *
     * @return \DateTime 
     */
    public function getDatumGeneratie()
    {
        return $this->datumGeneratie;
    }
}
