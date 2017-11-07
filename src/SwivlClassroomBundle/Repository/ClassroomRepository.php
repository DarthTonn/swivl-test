<?php

namespace SwivlClassroomBundle\Repository;

/**
 * ClassroomRepository
 *
 */
class ClassroomRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return array
     */
    public function getAllClasses(): array
    {
        $qb = $this->createQueryBuilder('cs')
            ->select('cs.id', 'cs.name', 'cs.isActive', 'cs.createdDate');

        return $qb->getQuery()
            ->getResult();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getClassById(int $id): array
    {
        $qb = $this->createQueryBuilder('cs')
            ->select('cs.id', 'cs.name', 'cs.isActive', 'cs.createdDate')
            ->where('cs.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()
            ->getOneOrNullResult();
    }
}
