<?php

namespace Adition\AdBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Adition\AdBundle\Repository\UserRepository")
 */
class User
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, unique=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     */
    protected $password;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Banner", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $banners;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Campaign", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $campaigns;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ContentUnit", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $contentUnits;


    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->campaigns = new ArrayCollection();
        $this->banners = new ArrayCollection();
        $this->contentUnits = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = md5($password);

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return ArrayCollection
     */
    public function getBanners()
    {
        return $this->banners;
    }

    /**
     * @param Banner $banner
     * @return $this
     */
    public function addBanner(Banner $banner)
    {
        $this->banners[] = $banner;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCampaigns()
    {
        return $this->campaigns;
    }

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function addCampaign(Campaign $campaign)
    {
        $this->campaigns[] = $campaign;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getContentUnits()
    {
        return $this->contentUnits;
    }

    /**
     * @param ContentUnit $contentUnit
     * @return $this
     */
    public function addContentUnit(ContentUnit $contentUnit)
    {
        $this->contentUnits[] = $contentUnit;

        return $this;
    }
}
