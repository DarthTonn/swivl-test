<?php

namespace SwivlClassroomBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\{AbstractFixture, OrderedFixtureInterface};
use Doctrine\Common\Persistence\ObjectManager;
use SwivlClassroomBundle\Entity\Classroom;

class LoadClassroomsEntityData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $date = new \DateTime('now');

        $type1 = (new Classroom())
            ->setName('math class')
            ->setCreatedDate($date)
            ->setIsActive(random_int(0, 1));

        $type2 = (new Classroom())
            ->setName('language class')
            ->setCreatedDate($date)
            ->setIsActive(random_int(0, 1));

        $type3 = (new Classroom())
            ->setName('code class')
            ->setCreatedDate($date)
            ->setIsActive(random_int(0, 1));


        $manager->persist($type1);
        $manager->persist($type2);
        $manager->persist($type3);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder(): int
    {
        return 0;
    }
}