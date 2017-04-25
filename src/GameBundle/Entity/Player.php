<?php

namespace GameBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GameBundle\Repository\PlayerRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Player
 *
 * @ORM\Table(name="players")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\PlayerRepository")
 */
class Player implements UserInterface
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
     * @ORM\Column(name="nickname", type="string", length=255, unique=true)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @ORM\Column(name="birthdate", type="datetimetz")
     */
    private $birthdate;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="GameBundle\Entity\Role")
     * @ORM\JoinTable(name="players_roles",
     *     joinColumns={@ORM\JoinColumn(name="player_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id",referencedColumnName="id")}
     *     )
     */
    private $roles;
    /**
     * @ORM\Column(name="pos_x", type="integer")
     */
    private $posX;
    /**
     * @ORM\Column(name="pos_y", type="integer")
     */
    private $posY;
    /**
     * @var Apartment
     *
     * @ORM\OneToOne(targetEntity="GameBundle\Entity\Apartment", inversedBy="player", cascade={"persist"})
     */
    private $apartment;

    /**
     * @var Resource
     * @ORM\OneToOne(targetEntity="GameBundle\Entity\Resource", inversedBy="player", cascade={"persist"})
     */
    private $resource;

    /**
     * @var Discotech
     *
     * @ORM\OneToOne(targetEntity="GameBundle\Entity\Discotech", inversedBy="player", cascade={"persist"})
     */
    private $discotech;

    public function getRoles()
    {
        $stringRoles = [];
        foreach ($this->roles as $role) {
            /** @var $role Role */
            $stringRoles[] = is_string($role) ? $role : $role->getRole();
        }
        return $stringRoles;
    }

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function addRole(Role $role)
    {
        $this->roles[] = $role;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return in_array('ROLE_ADMIN', $this->getRoles());
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }
    public function getNickname()
    {
        return $this->nickname;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }


    public function setAge($age)
    {
        $this->age = $age;

    }

    public function getAge()
    {
        return $this->age;
    }


    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->nickname;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    function calcAge($dob)
    {
        if (!empty($dob)) {
            $birthdate = $dob;
            $today = new DateTime('today');
            $age = $birthdate->diff($today)->y;
            return $age;
        } else {
            return 0;
        }
    }

    public function getPosX()
    {
        return $this->posX;
    }

    public function setPosX($posX)
    {
        $this->posX = $posX;
    }

    public function getPosY()
    {
        return $this->posY;
    }
    public function setPosY($posY)
    {
        $this->posY = $posY;
    }

    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }
    public function setApartment(Apartment $apartment)
    {
        $this->apartment = $apartment;
    }

    public function getApartment(): Apartment
    {
        return $this->apartment;
    }


    public function getResource(): Resource
    {
        return $this->resource;
    }

    public function setResource(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function getDiscotech(): Discotech
    {
        return $this->discotech;
    }

    public function setDiscotech(Discotech $discotech)
    {
        $this->discotech = $discotech;
    }

}

