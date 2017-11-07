<?php

namespace SwivlClassroomBundle\Services;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use SwivlClassroomBundle\Entity\Classroom;
use SwivlClassroomBundle\Utils\MessageConstantBag;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ClassroomService
 *
 * @package SwivlClassroomBundle\Services
 */
class ClassroomService extends FOSRestController implements ClassroomInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(): Response
    {
        $result = $this->em
            ->getRepository(Classroom::class)
            ->getAllClasses();

        if (empty($result)) {
            return new Response(MessageConstantBag::NO_RESULT, Response::HTTP_NOT_FOUND);
        }

        return new Response(json_encode($result), Response::HTTP_NOT_FOUND);
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $id): Response
    {
        $result = $this->em
            ->getRepository(Classroom::class)
            ->getClassById($id);

        if ($result === null) {
            return new Response(MessageConstantBag::NO_RESULT, Response::HTTP_NOT_FOUND
            );
        }

        return new Response(json_encode($result), Response::HTTP_CREATED);
    }

    /**
     * {@inheritdoc}
     */
    public function create(): Response
    {
        $name = $this->getCurrentRequestParams()->get('name');
        $isActive = $this->getCurrentRequestParams()->get('is_active');

        $classroom = (new Classroom())
            ->setName($name)
            ->setIsActive($isActive);

        $this->em->persist($classroom);
        $this->em->flush();

        return new Response(MessageConstantBag::CREATED_SUCCESSFULLY, Response::HTTP_CREATED);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id): Response
    {
        $name = $this->getCurrentRequestParams()->get('name');
        $isActive = $this->getCurrentRequestParams()->get('is_active');

        /** @var Classroom $classroom */
        $classroom = $this->em->getRepository(Classroom::class)->find($id);

        if ($classroom === null) {
            return new Response(MessageConstantBag::NO_RESULT, Response::HTTP_NOT_FOUND);
        }

        $classroom->setName($name)
            ->setIsActive($isActive);

        $this->em->flush();

        return new Response(MessageConstantBag::UPDATED_SUCCESSFULLY, Response::HTTP_CREATED);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): Response
    {
        $classroom = $this->em->getRepository(Classroom::class)->find($id);

        if (empty($classroom)) {
            return new Response(MessageConstantBag::NO_RESULT, Response::HTTP_NOT_FOUND);
        }

        $this->em->remove($classroom);
        $this->em->flush();

        return new Response(MessageConstantBag::DELETED_SUCCESSFULLY, Response::HTTP_OK);
    }

    /**
     * {@inheritdoc}
     */
    public function patch(int $id): Response
    {
        $isActive = $this->getCurrentRequestParams()->get('is_active');

        /** @var Classroom $classroom */
        $classroom = $this->em->getRepository(Classroom::class)->find($id);

        if (empty($classroom)) {
            return new Response(MessageConstantBag::NO_RESULT, Response::HTTP_NOT_FOUND);
        }

        $classroom->setIsActive($isActive);

        $this->em->flush();

        return new Response(MessageConstantBag::FIELD_UPDATED_SUCCESSFULLY, Response::HTTP_OK);
    }

    /**
     * Receive current request
     *
     * @return null|\Symfony\Component\HttpFoundation\Request
     */
    protected function getCurrentRequest()
    {
        return $this->get('request_stack')->getCurrentRequest();
    }

    /**
     * Receive current request params
     *
     * @return \Symfony\Component\HttpFoundation\ParameterBag
     */
    private function getCurrentRequestParams()
    {
        return $this->getCurrentRequest()->request;
    }
}