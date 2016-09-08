<?php
// src/Acme/UserBundle/Entity/User.php

namespace Packed\Bundle\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $organisatie
     *
     * @ORM\Column(name="organisatie", type="string", length=255, nullable=true)
     */
    private $organisatie;

    /**
     * @var datetime $datumIngevoerd
     *
     * @ORM\Column(name="datumIngevoerd", type="datetime", nullable=true)
     */
    private $datumIngevoerd;

    /**
     * @var string $typeOrganisatie
     *
     * @ORM\Column(name="typeOrganisatie", type="string", length=255, nullable=true)
     */
    private $typeOrganisatie;

    /**
     * @var string $grootteOrganisatie
     *
     * @ORM\Column(name="grootteOrganisatie", type="string", length=255, nullable=true)
     */
    private $grootteOrganisatie;

    /**
     * @var string $taal
     *
     * @ORM\Column(name="taal", type="string", length=255, nullable=true)
     */
    private $taal;

    /**
     * @var string $wachtwoordVergetenToken
     *
     * @ORM\Column(name="wachtwoordVergetenToken", type="string", length=255, nullable=true)
     */
    private $wachtwoordVergetenToken;



    /**
     * @ORM\OneToMany(targetEntity="Packed\Bundle\ScoreModelBundle\Entity\Rapport", mappedBy="gebruiker")
     */
    protected $rapporten;


    /**
     * Add rapporten
     *
     * @param Packed\Bundle\ScoreModelBundle\Entity\Rapport $rapporten
     */
    public function addRapport($rapporten)
    {
        $this->rapporten[] = $rapporten;
    }

    /**
     * Get rapporten
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getRapporten()
    {
        return $this->rapporten;
    }



    /**
     * Set $datumIngevoerd
     *
     * @param datetime $datumIngevoerd
     */
    public function setDatumIngevoerd($datumIngevoerd)
    {
        $this->datumIngevoerd = $datumIngevoerd;
    }

    /**
     * Get $datumIngevoerd
     *
     * @return datetime
     */
    public function getDatumIngevoerd()
    {
        return $this->datumIngevoerd;
    }

    /**
     * Set grootteOrganisatie
     *
     * @param string $grootteOrganisatie
     */
    public function setGrootteOrganisatie($grootteOrganisatie)
    {
        $this->grootteOrganisatie = $grootteOrganisatie;
    }

    /**
     * Get grootteOrganisatie
     *
     * @return string
     */
    public function getGrootteOrganisatie()
    {
        return $this->grootteOrganisatie;
    }


    /**
     * Set typeOrganisatie
     *
     * @param string $typeOrganisatie
     */
    public function setTypeOrganisatie($typeOrganisatie)
    {
        $this->typeOrganisatie = $typeOrganisatie;
    }

    /**
     * Get typeOrganisatie
     *
     * @return string
     */
    public function getTypeOrganisatie()
    {
        return $this->typeOrganisatie;
    }


    /**
     * Set organisatie
     *
     * @param string $organisatie
     */
    public function setOrganisatie($organisatie)
    {
        $this->organisatie = $organisatie;
    }

    /**
     * Get organisatie
     *
     * @return string
     */
    public function getOrganisatie()
    {
        return $this->organisatie;
    }

    /**
     * Set taal
     *
     * @param string $taal
     */
    public function setTaal($taal)
    {
        $this->taal = $taal;
    }

    /**
     * Get taal
     *
     * @return string
     */
    public function getTaal()
    {
        return $this->taal;
    }

    /*
     * Set wachtwoordVergetenToken
     *
     * @param string $token
     */
    public function setWachtwoordVergetenToken($token)
    {
        $this->wachtwoordVergetenToken = $token;
    }


    /*
     * Get wachtwoordVergetenToken
     *
     * @return string
     */
    public function getWachtwoordVergetenToken()
    {
        return $this->wachtwoordVergetenToken;
    }




    public function __construct()
    {
        parent::__construct();
        $this->rapporten = new ArrayCollection();
        $this->datumIngevoerd = new \DateTime();
    }
}