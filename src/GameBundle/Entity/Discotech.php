<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Discotech
 *
 * @ORM\Table(name="discotechs")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\DiscotechRepository")
 */
class Discotech
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
     * @ORM\OneToOne(targetEntity="GameBundle\Entity\Player", inversedBy="discotec")
     * @ORM\JoinColumn(name="playerId", referencedColumnName="id")
     */
    private $player;

    /**
     * @var int
     *
     * @ORM\Column(name="playerId", type="integer")
     */
    private $playerId;



    public function getId()
    {
        return $this->id;
    }

    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }
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

