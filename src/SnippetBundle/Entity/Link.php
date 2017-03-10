<?php

namespace SnippetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Link
 */
class Link
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Snippet
     */
    private $snippet;

    /**
     * @var string
     */
    private $caption;

    /**
     * @var string
     */
    private $url;


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
     * @param Snippet $snippet
     * @return Link
     */
    public function setSnippet(Snippet $snippet = null)
    {
        $this->snippet = $snippet;

        return $this;
    }

    /**
     * @return Snippet
     */
    public function getSnippet()
    {
        return $this->snippet;
    }

    /**
     * Set caption
     *
     * @param string $caption
     * @return Link
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string 
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}
