<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resource
 *
 * @ORM\Table(name="resources")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\ResourceRepository")
 */
class Resource
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
     * @ORM\Column(name="kinti", type="integer")
     */
    private $kinti = 150;

    /**
     * @var int
     *
     * @ORM\Column(name="mutri", type="integer")
     */
    private $mutri = 2;

    /**
     * @var Player
     *
     * @ORM\OneToOne(targetEntity="GameBundle\Entity\Player", inversedBy="resource")
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

    public function setKinti($kinti)
    {
        $this->kinti = $kinti;

        return $this;
    }

    public function getKinti()
    {
        return $this->kinti;
    }

    public function setMutri($mutri)
    {
        $this->mutri = $mutri;

        return $this;
    }

    public function getMutri()
    {
        return $this->mutri;
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

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer(Player $player = null)
    {
        $this->player = $player;
    }

    function __construct(Player $player)
    {
        $this->player = $player;
    }
}

