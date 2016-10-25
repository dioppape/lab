<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, unique=true)
     */
    protected $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="leadings", type="string", length=255, unique=true)
     */
    protected $leadings;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    protected $body;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="createdBy", type="string", length=255)
     */
    protected $createdBy;


    public function getId()
    {
        return $this->id;
    }

    
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setLeadings($leadings)
    {
        $this->leadings = $leadings;

        return $this;
    }

    public function getLeadings()
    {
        return $this->leadings;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Article
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }
    
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }


    public function getSlug()
    {
        return $this->slug;
    }

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
