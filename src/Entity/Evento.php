<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Common\Util;
use DateInterval;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\EventoRepository::class)
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
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $hora;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duracion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idioma;

    /**
     * @ORM\ManyToOne(targetEntity="Disertante", inversedBy="eventos")
     * @ORM\JoinColumn(name="disertante_id", referencedColumnName="id", nullable=true)
     */
    private $disertante;

    /**
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="evento")
     * @ORM\JoinTable(name="evento_usuario",
     *      joinColumns={@ORM\JoinColumn(name="evento_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")}
     * )
     * @var Collection<int, Usuario>
     */
    private $usuarios;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
    }

    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuario $usuario): self
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios[] = $usuario;
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario): self
    {
        $this->usuarios->removeElement($usuario);
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo($titulo): self
    {
        $this->titulo = $titulo;
        $this->setSlug(Util::slugify($this->titulo));
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(?\DateTimeInterface $hora): self
    {
        $this->hora = $hora;
        return $this;
    }

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(?int $duracion): self
    {
        $this->duracion = $duracion;
        return $this;
    }

    public function getIdioma(): ?string
    {
        return $this->idioma;
    }

    public function setIdioma(string $idioma): self
    {
        $this->idioma = $idioma;
        return $this;
    }

    public function getDisertante(): ?Disertante
    {
        return $this->disertante;
    }

    public function setDisertante(?Disertante $disertante): self
    {
        $this->disertante = $disertante;
        return $this;
    }

    //EN REPOSITORY VAN LOS DQL.
    //EN REPOSITORY VAN LOS DQL.

    public function getHoraFinalizacion()
    {
        if ($this->hora && $this->duracion) {
            $horaFinal = (clone $this->hora);
            $horaFinal->add(new \DateInterval('PT' . $this->duracion . 'M'));
            return $horaFinal;
        }
        return null;
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre;

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }
}
