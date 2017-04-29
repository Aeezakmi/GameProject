<?php

namespace GameBundle\Entity;

use DateTime;
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
     * @ORM\OneToOne(targetEntity="GameBundle\Entity\Player", inversedBy="discotech")
     * @ORM\JoinColumn(name="playerId", referencedColumnName="id")
     */
    private $player;
    /**
     * @var int
     *
     * @ORM\Column(name="playerId", type="integer", nullable=true)
     */
    private $playerId;
    /**
     * @var int
     *
     * @ORM\Column(name="mutri", type="integer")
     */
    private $mutri;
    /**
     * @ORM\Column(name="upgrade", type="datetimetz", nullable=true)
     */
    private $upgrade;

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
        $this->mutri = 5;
        $this->player = $player;
        $this->updated = new DateTime('now');
    }

    public function getMutri(): int
    {
        return $this->mutri;
    }

    public function setMutri(int $mutri)
    {
        $this->mutri = $mutri;
    }


    public function addMutra(int $mutra){
        $this->mutri+= $mutra;
    }

    public function getUpgrade()
    {
        return $this->upgrade;
    }

    public function setUpgrade($upgrade)
    {
        $this->upgrade = $upgrade;
    }
}

