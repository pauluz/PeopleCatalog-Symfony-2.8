<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CatPerson
 *
 * @ORM\Table(name="cat_person", indexes={
 *  @ORM\Index(name="cat_city_id", columns={"cat_city_id"}),
 *  @ORM\Index(name="cat_company_office_id", columns={"cat_company_office_id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CatPersonRepository")
 */
class CatPerson
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
     * @ORM\Column(name="firstname", type="string", length=100, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=100, nullable=false)
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth", type="date", nullable=false)
     */
    private $birth;

    /**
     * @var \CatCity
     *
     * @ORM\ManyToOne(targetEntity="CatCity", inversedBy="catPersons", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cat_city_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $catCity;

    /**
     * @var \CatCompanyOffice
     *
     * @ORM\ManyToOne(targetEntity="CatCompanyOffice", inversedBy="catPersons", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cat_company_office_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $catCompanyOffice;

    /* AUTOMAT */

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
     * Set firstname
     *
     * @param string $firstname
     * @return CatPerson
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return CatPerson
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birth
     *
     * @param \DateTime $birth
     * @return CatPerson
     */
    public function setBirth($birth)
    {
        $this->birth = $birth;

        return $this;
    }

    /**
     * Get birth
     *
     * @return \DateTime
     */
    public function getBirth()
    {
        return $this->birth;
    }

    /**
     * Set catCity
     *
     * @param \AppBundle\Entity\CatCity $catCity
     * @return CatPerson
     */
    public function setCatCity(\AppBundle\Entity\CatCity $catCity = null)
    {
        $this->catCity = $catCity;

        return $this;
    }

    /**
     * Get catCity
     *
     * @return \AppBundle\Entity\CatCity
     */
    public function getCatCity()
    {
        return $this->catCity;
    }

    /**
     * Set catCompanyOffice
     *
     * @param \AppBundle\Entity\CatCompanyOffice $catCompanyOffice
     * @return CatPerson
     */
    public function setCatCompanyOffice(\AppBundle\Entity\CatCompanyOffice $catCompanyOffice = null)
    {
        $this->catCompanyOffice = $catCompanyOffice;

        return $this;
    }

    /**
     * Get catCompanyOffice
     *
     * @return \AppBundle\Entity\CatCompanyOffice
     */
    public function getCatCompanyOffice()
    {
        return $this->catCompanyOffice;
    }
}
