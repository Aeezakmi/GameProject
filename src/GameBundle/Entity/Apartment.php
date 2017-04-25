<?php

namespace GameBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Apartment
 *
 * @ORM\Table(name="apartments")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\ApartmentRepository")
 */
class Apartment
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
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;
    /**
     * @var Player
     *
     * @ORM\OneToOne(targetEntity="GameBundle\Entity\Player", inversedBy="apartment")
     * @ORM\JoinColumn(name="playerId", referencedColumnName="id")
     */
    private $player;

    /**
     * @var int
     *
     * @ORM\Column(name="playerId", type="integer")
     */
    private $playerId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Apartment
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

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player = null)
    {
        $this->player = $player;
        return $this;
    }

    public function setPlayerId($playerId)
    {
        $this->playerId = $playerId;
        return $this;
    }

    public function getPlayerId()
    {
        return $this->playerId;
    }

    function __construct(Player $player)
    {
        $this->level = 1;
        $this->player = $player;
    }

}

