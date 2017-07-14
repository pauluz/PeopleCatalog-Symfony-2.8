<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CatOffice
 *
 * @ORM\Table(name="cat_office", indexes={@ORM\Index(name="cat_company_id", columns={"cat_company_id"})})
 * @ORM\Entity
 */
class CatOffice
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
     * @ORM\ManyToOne(targetEntity="CatCompany")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cat_company_id", referencedColumnName="id")
     * })
     */
    private $catCompany;



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
     * @return CatOffice
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
     * @return CatOffice
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
}
