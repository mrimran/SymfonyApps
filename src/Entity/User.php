<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints;

/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"post"},
 *     normalizationContext={
 *      "groups"={"read"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     * @Constraints\NotBlank()
     * @Constraints\Length(min=3, max=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Constraints\NotBlank()
     * @Constraints\Length(min=6, max=255)
     * @Constraints\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,}/",
     *     message="Password must be 6 characters long and contain at least one digit, one upper case letter and one lower case letter."
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     * @Constraints\NotBlank()
     * @Constraints\Length(min=3, max=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Constraints\NotBlank()
     * @Constraints\Email()
     * @Constraints\Length(min=6, max=255)
     */
    private $email;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\BlogPost", mappedBy="author")
	 * @Groups({"read"})
	 */
    private $posts;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="author")
	 * @Groups({"read"})
	 */
    private $comments;

    public function __construct() {
    	$this->posts = new ArrayCollection();
    	$this->comments = new ArrayCollection();
    }

	public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

	public function getPosts(): Collection
	{
		return $this->posts;
	}

	public function getComments(): Collection
	{
		return $this->comments;
	}

	public function getRoles() {
		return ['ROLE_USER'];
	}

	public function getSalt() {
		return null;
	}

	public function eraseCredentials() {
		// TODO: Implement eraseCredentials() method.
	}
}
