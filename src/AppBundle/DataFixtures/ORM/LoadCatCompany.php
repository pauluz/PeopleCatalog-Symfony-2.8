<?php

namespace AppBundle\DataFixtures\ORM;

class LoadCatCompany extends LoadMyAbstractClass
{
    function __construct()
    {
        $this->fixture_table = 'cat_company';
    }

    /**
     * pZ: getOrder
     *
     * @return int
     */
    public function getOrder()
    {
        return 20;
    }
}
