<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CatCompanyOffice
 *
 * @ORM\Table(name="cat_company_office", indexes={
 *  @ORM\Index(name="cat_company_id", columns={"cat_company_id"})
 * })
 * @ORM\Entity
 */
class CatCompanyOffice
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
     * @var \CatCompany
     *
     * @ORM\ManyToOne(targetEntity="CatCompany", inversedBy="catCompanies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cat_company_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $catCompany;

    /**
     * One Office has Many Persons.
     * @var \ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CatPerson", mappedBy="catCompanyOffice", cascade={"persist","merge"})
     * @ORM\OrderBy({"sequence"="ASC"})
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
     * @return CatCompanyOffice
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
     * Set catCompany
     *
     * @param \AppBundle\Entity\CatCompany $catCompany
     * @return CatCompanyOffice
     */
    public function setCatCompany(\AppBundle\Entity\CatCompany $catCompany = null)
    {
        $this->catCompany = $catCompany;

        return $this;
    }

    /**
     * Get catCompany
     *
     * @return \AppBundle\Entity\CatCompany
     */
    public function getCatCompany()
    {
        return $this->catCompany;
    }

    /**
     * Add catPersons
     *
     * @param \AppBundle\Entity\CatPerson $catPersons
     * @return CatCompanyOffice
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
