<?php

namespace AppBundle\DataFixtures\ORM;

class LoadCatCity extends LoadMyAbstractClass
{
    function __construct()
    {
        $this->fixture_table = 'cat_city';
    }

    /**
     * pZ: getOrder
     *
     * @return int
     */
    public function getOrder()
    {
        return 10;
    }
}
