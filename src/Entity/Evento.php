<?php

namespace App\Entity;

use App\Common\Util;
use App\Repository\EventoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
* CursoSymfony\EventoBundle\Entity
*
* @ORM\Table(name="evento")
* @ORM\Entity
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
     * @ORM\ManyToOne(targetEntity="Disertante", inversedBy="evento")
     * @ORM\JoinColumn(name="disertante_id", referencedColumnName="id")
     */
    private $disertante;
    /**
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="evento")
     * @ORM\JoinTable(name="evento_usuario",
     * joinColumns={@ORM\JoinColumn(name="evento_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")}
     * )
     */
    private $usuarios;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo($titulo)
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

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
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
}
