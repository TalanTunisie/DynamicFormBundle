<?php
namespace Talan\Bundle\DynamicFormBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Talan\Bundle\DynamicFormBundle\Entity\Form;
use Doctrine\ORM\Query\Expr;

class ValueRepository extends EntityRepository
{
    public function findOwnersByForm($formId)
    {
        $qb = $this->createQueryBuilder('v');
        $qb->select('v.valueOwner')
            ->join('TalanDynamicFormBundle:Field', 'f', Expr\Join::WITH, 'f.form = :form and f.id = v.field')
            ->groupBy('v.valueOwner')
            ->setParameter('form', $formId);

        return $qb->getQuery()->getResult();
    }
}