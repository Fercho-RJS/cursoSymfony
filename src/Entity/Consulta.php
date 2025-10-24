<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="consulta")
 */
class Consulta
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=150)
   * @Assert\NotBlank(message="El nombre es obligatorio")
   * @Assert\Length(min=3, max=150, minMessage="El nombre debe tener al menos {{ limit }} caracteres")
   */
  private $nombre;

  /**
   * @ORM\Column(type="string", length=180)
   * @Assert\NotBlank(message="El email es obligatorio")
   * @Assert\Email(message="Dirección de email inválida")
   */
  private $email;

  /**
   * @ORM\Column(type="text")
   * @Assert\NotBlank(message="La consulta no puede estar vacía")
   */
  private $consulta;

  /**
   * @ORM\Column(type="datetime")
   */
  private $fecha;

  public function __construct()
  {
    $this->fecha = new \DateTime();
  }

  public function getId()
  {
    return $this->id;
  }

  public function getNombre()
  {
    return $this->nombre;
  }

  public function setNombre($nombre)
  {
    $this->nombre = $nombre;
    return $this;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail($email)
  {
    $this->email = $email;
    return $this;
  }

  public function getConsulta()
  {
    return $this->consulta;
  }

  public function setConsulta($consulta)
  {
    $this->consulta = $consulta;
    return $this;
  }

  public function getFecha()
  {
    return $this->fecha;
  }

  public function setFecha($fecha)
  {
    $this->fecha = $fecha;
    return $this;
  }
}
