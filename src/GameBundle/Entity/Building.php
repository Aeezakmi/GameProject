<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Building
 *
 * @ORM\Table(name="buildings")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\BuildingRepository")
 */
class Building
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
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\Player", inversedBy="buildings")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    private $player;

    /**
     * @var int
     * @ORM\Column(name="player_id", type="integer")
     */
    private $playerid;

    /**
     * @var Type
     *
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\Type", inversedBy="buildings")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;
    /**
     * @var int
     * @ORM\Column(name="type_id", type="integer")
     */
    private $typeid;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="resource", type="integer")
     */
    private $resource = 150;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="upgraded_on", type="datetimetz", nullable=true)
     */
    private $upgraded;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_on", type="datetimetz", nullable=true)
     */
    private $updated;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setType(Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Building
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    public function setUpgraded($upgraded)
    {
        $this->upgraded = $upgraded;

        return $this;
    }
    public function getUpgraded()
    {
        return $this->upgraded;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player)
    {
        $this->player = $player;
    }

    public function getResource(): int
    {
        return $this->resource;
    }

    public function setResource(int $resource)
    {
        $this->resource = $resource;
    }

    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return int
     */
    public function getPlayerid(): int
    {
        return $this->playerid;
    }

    /**
     * @param int $playerid
     */
    public function setPlayerid(int $playerid)
    {
        $this->playerid = $playerid;
    }

    /**
     * @return int
     */
    public function getTypeid(): int
    {
        return $this->typeid;
    }

    /**
     * @param int $typeid
     */
    public function setTypeid(int $typeid)
    {
        $this->typeid = $typeid;
    }
}

