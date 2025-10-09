<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UsuarioRepository::class)
 * @UniqueEntity(fields={"email"}, message="Este email ya está registrado.")
 */
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=32)
   * @Assert\Length(min=3, max=32)
   */
  private $nombre;

  /**
   * @ORM\Column(type="string", length=32)
   * @Assert\NotBlank()
   * @Assert\Length(min=3, max=32)
   */
  private $apellidos;

  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
  private $dni;

  /**
   * @ORM\Column(type="string")
   */
  private $direccion;

  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
  private $telefono;

  /**
   * @ORM\Column(type="string", unique=true)
   * @Assert\NotBlank()
   * @Assert\Email()
   */
  private $email;

  /**
   * @ORM\Column(type="string", length=32)
   * @Assert\Length(min=3, max=32)
   */
  private $password;

  /**
   * @ORM\ManyToMany(targetEntity="App\Entity\Evento", mappedBy="usuarios")
   */
  private $eventos;

  public function __construct()
  {
    $this->eventos = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getNombre(): ?string
  {
    return $this->nombre;
  }

  public function setNombre(string $nombre): self
  {
    $this->nombre = $nombre;
    return $this;
  }

  public function getApellidos(): ?string
  {
    return $this->apellidos;
  }

  public function setApellidos(string $apellidos): self
  {
    $this->apellidos = $apellidos;
    return $this;
  }

  public function getDni(): ?string
  {
    return $this->dni;
  }

  public function setDni(string $dni): self
  {
    $this->dni = $dni;
    return $this;
  }

  public function getRoles(): array
  {
    return ['ROLE_USER'];
  }

  public function getDireccion(): ?string
  {
    return $this->direccion;
  }

  public function setDireccion(string $direccion): self
  {
    $this->direccion = $direccion;
    return $this;
  }

  public function getTelefono(): ?string
  {
    return $this->telefono;
  }

  public function setTelefono(string $telefono): self
  {
    $this->telefono = $telefono;
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

  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function setPassword(string $password): self
  {
    $this->password = $password;
    return $this;
  }

  public function getUserIdentifier(): string
  {
    return $this->email;
  }

  public function eraseCredentials(): void
  {
    // Si tenés datos sensibles temporales, los limpiás acá
  }

  public function getEventos(): Collection
  {
    return $this->eventos;
  }

  public function addEvento(Evento $evento): self
  {
    if (!$this->eventos->contains($evento)) {
      $this->eventos[] = $evento;
      $evento->addUsuario($this);
    }
    return $this;
  }

  public function removeEvento(Evento $evento): self
  {
    if ($this->eventos->removeElement($evento)) {
      $evento->removeUsuario($this);
    }
    return $this;
  }

  public function getUsername(): string
  {
    return $this->email;
  }

  public function getSalt(): ?string
  {
    // Si usás bcrypt o sodium, no necesitás salt
    return null;
  }
}
