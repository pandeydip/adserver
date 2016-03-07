<?php

namespace Adition\AdBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Campaign
 *
 * @ORM\Table(name="campaign")
 * @ORM\Entity(repositoryClass="Adition\AdBundle\Repository\CampaignRepository")
 */
class Campaign
{

    const ACTIVE = 1;

    const INACTIVE = 0;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="state", type="boolean")
     */
    protected $state = self::ACTIVE;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    protected $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    protected $endDate;

    /**
     * @var int
     *
     * @ORM\Column(name="banner_count", type="integer")
     */
    protected $bannerCount = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="request_limit", type="integer")
     */
    protected $requestLimit = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="request_count", type="integer")
     */
    protected $requestCount = 0;

    /**
     * @ORM\OneToMany(targetEntity="Banner", mappedBy="campaign", cascade={"persist", "remove"})
     */
    protected $banners;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="campaigns")
     */
    protected $user;


    /**
     * Campaign constructor.
     */
    public function __construct()
    {
        $this->banners = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Campaign
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set state
     *
     * @param boolean $state
     * @return Campaign
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return boolean
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Campaign
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Campaign
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set requestLimit
     *
     * @param integer $requestLimit
     * @return Campaign
     */
    public function setRequestLimit($requestLimit)
    {
        $this->requestLimit = $requestLimit;

        return $this;
    }

    /**
     * Get requestLimit
     *
     * @return integer
     */
    public function getRequestLimit()
    {
        return $this->requestLimit;
    }

    /**
     * Set requestCount
     *
     * @param integer $requestCount
     * @return Campaign
     */
    public function incrementRequestCount($requestCount)
    {
        $this->requestCount = $requestCount + 1;

        return $this;
    }

    /**
     * Get requestCount
     *
     * @return integer
     */
    public function getRequestCount()
    {
        return $this->requestCount;
    }

    /**
     * @return int
     */
    public function getBannerCount()
    {
        return $this->bannerCount;
    }

    /**
     * @param int $bannerCount
     */
    public function setBannerCount($bannerCount)
    {
        $this->bannerCount = $bannerCount;
    }

    /**
     * @return mixed
     */
    public function getBanners()
    {
        return $this->banners;
    }

    /**
     * @param Banner $banner
     * @return $this$
     */
    public function addBanner(Banner $banner)
    {
        $banner->setCampaign($this);
        $this->banners[] = $banner;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}
