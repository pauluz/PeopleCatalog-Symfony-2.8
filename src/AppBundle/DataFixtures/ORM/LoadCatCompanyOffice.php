<?php

namespace AppBundle\DataFixtures\ORM;

class LoadCatCompanyOffice extends LoadMyAbstractClass
{
    function __construct()
    {
        $this->fixture_table = 'cat_company_office';
        $this->reference_fields = ['cat_company'];
    }

    /**
     * pZ: getOrder
     *
     * @return int
     */
    public function getOrder()
    {
        return 30;
    }
}
