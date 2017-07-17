<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CatCompanyOfficeRepository extends EntityRepository
{
    public function qbByCatCompany($id = null)
    {
        if (is_null($id)) {
            $qb = $this->createQueryBuilder('c');
        } else {
            $qb = $this
                ->createQueryBuilder('c')
                ->where('c.catCompany= :id')
                ->setParameter('id', $id);
        }

        return $qb;
    }
}
