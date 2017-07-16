<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CatPersonRepository extends EntityRepository
{
    public function findWithAllJoins($id)
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->select('c')
            ->addSelect('cc')
            ->addSelect('cco')
            ->addSelect('ccc')
            ->leftJoin('c.catCity', 'cc')
            ->leftJoin('c.catCompanyOffice', 'cco')
            ->leftJoin('cco.catCompany', 'ccc')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

//        echo \SqlFormatter::format($qb->getSQL());
//        die(' -CatPersonRepository.php-18');

        return $qb->getSingleResult();
    }
}
