<?php

namespace AppBundle\DataFixtures\ORM;

class LoadCatPerson extends LoadMyAbstractClass
{
    function __construct()
    {
        $this->fixture_table = 'cat_person';
        $this->reference_fields = ['cat_city', 'cat_company_office'];
        $this->setAddReference(false);
    }

    /**
     * pZ: getOrder
     *
     * @return int
     */
    public function getOrder()
    {
        return 40;
    }
}
