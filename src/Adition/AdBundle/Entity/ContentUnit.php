<?php

namespace Adition\AdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContentUnit
 *
 * @ORM\Table(name="content_unit")
 * @ORM\Entity(repositoryClass="Adition\AdBundle\Repository\ContentUnitRepository")
 */
class ContentUnit
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
     * @var int
     *
     * @ORM\Column(name="width", type="integer")
     */
    protected $width;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer")
     */
    protected $height;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="contentUnits")
     */
    protected $user;

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
     * Set width
     *
     * @param integer $width
     * @return ContentUnit
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return ContentUnit
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return User
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
