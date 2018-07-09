<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table(name="categories", uniqueConstraints={@ORM\UniqueConstraint(name="category_key", columns={"category_key"})})
 * @ORM\Entity
 */
class Categories
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
     * @ORM\Column(name="category_key", type="string", length=50, nullable=false)
     */
    private $categoryKey;

    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="string", length=100, nullable=false)
     */
    private $categoryName;


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
     * Set categoryKey
     *
     * @param string $categoryKey
     *
     * @return Categories
     */
    public function setCategoryKey($categoryKey)
    {
        $this->categoryKey = $categoryKey;

        return $this;
    }

    /**
     * Get categoryKey
     *
     * @return string
     */
    public function getCategoryKey()
    {
        return $this->categoryKey;
    }

    /**
     * Set categoryName
     *
     * @param string $categoryName
     *
     * @return Categories
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    public function exchangeArray($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = ($value !== null) ? $value : null;
            }
        }
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
