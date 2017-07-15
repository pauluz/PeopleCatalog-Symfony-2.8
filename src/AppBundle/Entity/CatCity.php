<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CatCity
 *
 * @ORM\Table(name="cat_city")
 * @ORM\Entity
 */
class CatCity
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
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * One City has Many Persons.
     * @var \ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CatPerson", mappedBy="catCity", cascade={"persist","merge"})
     * @ORM\OrderBy({"lastname"="ASC"})
     */
    private $catPersons;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /* AUTOMAT */

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->catPersons = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return CatCity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add catPersons
     *
     * @param \AppBundle\Entity\CatPerson $catPersons
     * @return CatCity
     */
    public function addCatPerson(\AppBundle\Entity\CatPerson $catPersons)
    {
        $this->catPersons[] = $catPersons;

        return $this;
    }

    /**
     * Remove catPersons
     *
     * @param \AppBundle\Entity\CatPerson $catPersons
     */
    public function removeCatPerson(\AppBundle\Entity\CatPerson $catPersons)
    {
        $this->catPersons->removeElement($catPersons);
    }

    /**
     * Get catPersons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCatPersons()
    {
        return $this->catPersons;
    }
}
