<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attack
 *
 * @ORM\Table(name="attack")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\AttackRepository")
 */
class Attack
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
     * @ORM\Column(name="attacker_id", type="integer")
     */
    private $attackerId;

    /**
     * @var int
     *
     * @ORM\Column(name="target_id", type="integer")
     */
    private $targetId;

    /**
     * @var int
     *
     * @ORM\Column(name="time", type="integer")
     */
    private $time;
    /**
     * @var int
     *
     * @ORM\Column(name="winner", type="integer",nullable=true)
     */
    private $winner;
    /**
     * @var int
     *
     * @ORM\Column(name="resource", type="integer", nullable=true)
     */
    private $resource;

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
     * Set attackerId
     *
     * @param integer $attackerId
     *
     * @return Attack
     */
    public function setAttackerId($attackerId)
    {
        $this->attackerId = $attackerId;

        return $this;
    }

    /**
     * Get attackerId
     *
     * @return int
     */
    public function getAttackerId()
    {
        return $this->attackerId;
    }

    /**
     * Set targetId
     *
     * @param integer $targetId
     *
     * @return Attack
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;

        return $this;
    }

    /**
     * Get targetId
     *
     * @return int
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * Set time
     *
     * @param integer $time
     *
     * @return Attack
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function setWinner($winner)
    {
        $this->winner = $winner;
    }

    public function getResource()
    {
        return $this->resource;
    }


    public function setResource($resource)
    {
        $this->resource = $resource;
    }
}

