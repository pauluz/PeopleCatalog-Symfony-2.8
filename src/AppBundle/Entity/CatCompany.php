<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CatCompany
 *
 * @ORM\Table(name="cat_company")
 * @ORM\Entity
 */
class CatCompany
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
     * One Company has Many Company Offices.
     * @var \ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CatCompanyOffice", mappedBy="catCompany", cascade={"persist","merge"})
     * @ORM\OrderBy({"sequence"="ASC"})
     */
    private $catCompanies;

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
        $this->catCompanies = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return CatCompany
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
     * Add catCompanies
     *
     * @param \AppBundle\Entity\CatCompanyOffice $catCompanies
     * @return CatCompany
     */
    public function addCatCompany(\AppBundle\Entity\CatCompanyOffice $catCompanies)
    {
        $this->catCompanies[] = $catCompanies;

        return $this;
    }

    /**
     * Remove catCompanies
     *
     * @param \AppBundle\Entity\CatCompanyOffice $catCompanies
     */
    public function removeCatCompany(\AppBundle\Entity\CatCompanyOffice $catCompanies)
    {
        $this->catCompanies->removeElement($catCompanies);
    }

    /**
     * Get catCompanies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCatCompanies()
    {
        return $this->catCompanies;
    }
}
