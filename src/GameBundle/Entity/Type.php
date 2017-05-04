<?php

namespace GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="building_types")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\TypeRepository")
 */
class Type
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="GameBundle\Entity\Building", mappedBy="type")
     */
    private $buildings;
    /**
     *
     * @ORM\Column(name="resource_name", type="string",length=255,unique=true)
     */
    private $resource_name;
    /**
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;
    /**
     *
     * @ORM\Column(name="price_limit", type="integer")
     */
    private $priceLimit;
    /**
     *
     * @ORM\Column(name="starting_resource", type="integer")
     */
    private $startingResource;

    /**
     * @ORM\Column(name="upgrade_time", type="integer")
     */
    private $upgradeTime;
    /**
     * @ORM\Column(name="resource_price", type="integer", nullable=true)
     */
    private $resourcePrice;

    /**
     * @ORM\Column(name="resource_limit", type="integer", nullable=true)
     */
    private $resourceLimit;



    public function getId()
    {
        return $this->id;
    }


    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getBuildings(): ArrayCollection
    {
        return $this->buildings;
    }

    public function setBuildings(ArrayCollection $buildings)
    {
        $this->buildings = $buildings;
    }

    public function getResourceName()
    {
        return $this->resource_name;
    }

    public function setResourceName($resource_name)
    {
        $this->resource_name = $resource_name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPriceLimit()
    {
        return $this->priceLimit;
    }

    public function setPriceLimit($priceLimit)
    {
        $this->priceLimit = $priceLimit;
    }

    public function getStartingResource()
    {
        return $this->startingResource;
    }

    public function setStartingResource($startingResource)
    {
        $this->startingResource = $startingResource;
    }

    public function getUpgradeTime()
    {
        return $this->upgradeTime;
    }

    public function setUpgradeTime($upgradeTime)
    {
        $this->upgradeTime = $upgradeTime;
    }

    public function getResourcePrice()
    {
        return $this->resourcePrice;
    }

    public function setResourcePrice($resourcePrice)
    {
        $this->resourcePrice = $resourcePrice;
    }

    public function getResourceLimit()
    {
        return $this->resourceLimit;
    }

    public function setResourceLimit($resourceLimit)
    {
        $this->resourceLimit = $resourceLimit;
    }


}
