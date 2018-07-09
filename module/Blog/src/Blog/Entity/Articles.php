<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles", indexes={@ORM\Index(name="FK_articles_categories", columns={"category_id"})})
 * @ORM\Entity
 */
class Articles
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="article", type="text", length=65535, nullable=true)
     */
    private $article;

    /**
     * @var string
     *
     * @ORM\Column(name="short_article", type="text", length=65535, nullable=true)
     */
    private $shortArticle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_public", type="boolean", nullable=false)
     */
    private $isPublic = '0';

    /**
     * @var \Blog\Entity\Categories
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;



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
     * Set title
     *
     * @param string $title
     *
     * @return Articles
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
     * Set article
     *
     * @param string $article
     *
     * @return Articles
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set shortArticle
     *
     * @param string $shortArticle
     *
     * @return Articles
     */
    public function setShortArticle($shortArticle)
    {
        $this->shortArticle = $shortArticle;

        return $this;
    }

    /**
     * Get shortArticle
     *
     * @return string
     */
    public function getShortArticle()
    {
        return $this->shortArticle;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     *
     * @return Articles
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set category
     *
     * @param \Blog\Entity\Categories $category
     *
     * @return Articles
     */
    public function setCategory(\Blog\Entity\Categories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Blog\Entity\Categories
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function getArticleForTable(){
        $article = strip_tags($this->getArticle());
        return mb_substr($article, 0, 15, 'UTF-8'). '...';
    }

    public function getShortArticleForTable(){
        $article = strip_tags($this->getShortArticle());
        return mb_substr($article, 0, 20, 'UTF-8'). '...';
    }

    public function getShortArticleForBlog(){
        $article = $this->getShortArticle();
        if(empty($article)){
            $article = $this->getArticle();
        }
        return $article;
    }

    public function getFullArticle(){
        return $this->getShortArticle() . $this->getArticle();
    }

}
