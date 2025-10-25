<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Common\Util;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Form\EventoType;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoRepository")
 */
class Evento
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\NotBlank()
   * @Assert\Length(max=255)
   */
  private $titulo;

  /**
   * @ORM\Column(type="string", length=255, unique=true)
   */
  private $slug;

  /**
   * @ORM\Column(type="text")
   * @Assert\NotBlank()
   * @Assert\Length(min=5)
   */
  private $descripcion;

  /**
   * @ORM\Column(type="date", nullable=true)
   */
  private $fecha;

  /**
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $hora;

  /**
   * @ORM\Column(type="integer", nullable=true)
   * @Assert\Range(min=0, max=300)
   */
  private $duracion;

  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\Choice(choices={"es", "en"})
   */
  private $idioma;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\Disertante", inversedBy="eventos")
   * @ORM\JoinColumn(name="disertante_id", referencedColumnName="id", nullable=true)
   */
  private $disertante;

  /**
   * @ORM\ManyToMany(targetEntity=Usuario::class, inversedBy="eventos")
   * @ORM\JoinTable(name="evento_usuario", joinColumns={@ORM\JoinColumn(name="evento_id", referencedColumnName="id", onDelete="CASCADE")}, inverseJoinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")}
   * )
   */
  private $usuarios;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $nombre;

  public function __construct()
  {
    $this->usuarios = new ArrayCollection();
  }

  public function getId()
  {
    return $this->id;
  }

  public function getTitulo()
  {
    return $this->titulo;
  }

  public function setTitulo($titulo)
  {
    $this->titulo = $titulo;
    $this->setSlug(Util::slugify($titulo));
    return $this;
  }

  public function getSlug()
  {
    return $this->slug;
  }

  public function setSlug($slug)
  {
    $this->slug = $slug;
    return $this;
  }

  public function getDescripcion()
  {
    return $this->descripcion;
  }

  public function setDescripcion($descripcion)
  {
    $this->descripcion = $descripcion;
    return $this;
  }

  public function getFecha()
  {
    return $this->fecha;
  }

  public function setFecha(\DateTimeInterface $fecha)
  {
    $this->fecha = $fecha;
    return $this;
  }

  public function getHora(): ?\DateTimeInterface
  {
    return $this->hora;
  }

  public function setHora(\DateTimeInterface $hora)
  {
    $this->hora = $hora;
    return $this;
  }

  public function getDuracion()
  {
    return $this->duracion;
  }

  public function setDuracion($duracion)
  {
    $this->duracion = $duracion;
    return $this;
  }

  public function getIdioma()
  {
    return $this->idioma;
  }

  public function setIdioma($idioma)
  {
    $this->idioma = $idioma;
    return $this;
  }

  public function getDisertante()
  {
    return $this->disertante;
  }

  public function setDisertante($disertante)
  {
    $this->disertante = $disertante;
    return $this;
  }

  public function getUsuarios()
  {
    return $this->usuarios;
  }

  public function addUsuario($usuario)
  {
    if (!$this->usuarios->contains($usuario)) {
      $this->usuarios[] = $usuario;
    }
    return $this;
  }

  public function removeUsuario($usuario)
  {
    $this->usuarios->removeElement($usuario);
    return $this;
  }

  public function getHoraFinalizacion()
  {
    if ($this->hora && $this->duracion) {
      /** @var \DateTime $horaFinal */
      $horaFinal = (clone $this->hora);
      $horaFinal->add(new \DateInterval('PT' . $this->duracion . 'M'));
      return $horaFinal;
    }
    return null;
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
}
