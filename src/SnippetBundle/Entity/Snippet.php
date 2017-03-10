<?php

namespace SnippetBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Snippet
 */
class Snippet
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Technology
     */
    private $technology;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $code;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var ArrayCollection|Link[]
     */
    private $links;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->links = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Technology $technology
     * @return Snippet
     */
    public function setTechnology(Technology $technology)
    {
        $this->technology = $technology;

        return $this;
    }

    /**
     * @return Technology
     */
    public function getTechnology()
    {
        return $this->technology;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Snippet
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Snippet
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Snippet
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param \DateTime $createdAt
     * @return Snippet
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Adds link.
     *
     * @param Link $link
     *
     * @return Snippet
     */
    public function addLink(Link $link)
    {
        if (!$this->links->contains($link)) {
            $this->links->add($link);
            $link->setSnippet($this);
        }

        return $this;
    }

    /**
     * Removes link.
     *
     * @param Link $link
     *
     * @return Snippet
     */
    public function removeLink(Link $link)
    {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
            $link->setSnippet(null);
        }

        return $this;
    }

    /**
     * @return ArrayCollection|Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }
}
