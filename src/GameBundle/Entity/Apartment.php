<?php

namespace GameBundle\Entity;


use DateTime;
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
     * @ORM\Column(name="playerId", type="integer", nullable=true)
     */
    private $playerId;
    /**
     * @var int
     *
     * @ORM\Column(name="kinti", type="integer")
     */
    private $kinti;
    /**
     * @var DateTime
     * @ORM\Column(name="updated_on", type="datetimetz")
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
        $this->kinti = 150;
        $this->player = $player;
        $this->updated = new DateTime('now');
    }

    public function getKinti(): int
    {
        return $this->kinti;
    }

    public function setKinti(int $kinti)
    {
        $this->kinti = $kinti;
    }

    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    public function setUpdated(DateTime $updated)
    {
        $this->updated = $updated;
    }

    public function addKinti($kinti){
        $this->kinti+= $kinti;
    }

}

