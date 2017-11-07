<?php

namespace SwivlClassroomBundle\Services;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use SwivlClassroomBundle\Entity\Classroom;
use SwivlClassroomBundle\Utils\MessageConstantBag;
use Symfony\Component\HttpFoundation\Response;

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
        $em = $this->em;

        $result = $em
            ->getRepository(Classroom::class)
            ->getAllClasses();

        if (empty($result)) {
            return new Response(MessageConstantBag::NO_RESULT,
                Response::HTTP_NOT_FOUND
            );
        }

        return new Response(json_encode($result),
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $id): Response
    {
        $em = $this->em;

        $result = $em
            ->getRepository(Classroom::class)
            ->getClassById($id);

        if ($result === null) {
            return new Response(MessageConstantBag::NO_RESULT,
                Response::HTTP_NOT_FOUND
            );
        }
        return new Response(json_encode($result),
            Response::HTTP_CREATED
        );
    }

    /**
     * {@inheritdoc}
     */
    public function create(): Response
    {
        $em = $this->em;

        $classroom = new Classroom();

        $name = $this->getCurrentRequestParams()->get('name');
        $isActive = $this->getCurrentRequestParams()->get('is_active');

        $classroom->setName($name);
        $classroom->setIsActive($isActive);

        $em->persist($classroom);
        $em->flush();

        return new Response(MessageConstantBag::CREATED_SUCCESSFULLY,
            Response::HTTP_CREATED
        );
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id): Response
    {
        $em = $this->em;

        $name = $this->getCurrentRequestParams()->get('name');
        $isActive = $this->getCurrentRequestParams()->get('is_active');

        /** @var Classroom $classroom */
        $classroom = $em->getRepository(Classroom::class)
            ->find($id);

        if (empty($classroom)) {
            return new Response(MessageConstantBag::NO_RESULT,
                Response::HTTP_NOT_FOUND
            );
        }

        $classroom->setName($name);
        $classroom->setIsActive($isActive);

        $em->flush();

        return new Response(MessageConstantBag::UPDATED_SUCCESSFULLY,
            Response::HTTP_CREATED
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): Response
    {
        $em = $this->em;

        $classroom = $em->getRepository(Classroom::class)
            ->find($id);

        if (empty($classroom)) {
            return new Response(MessageConstantBag::NO_RESULT,
                Response::HTTP_NOT_FOUND
            );
        }

        $em->remove($classroom);
        $em->flush();

        return new Response(MessageConstantBag::DELETED_SUCCESSFULLY,
            Response::HTTP_OK
        );
    }

    /**
     * {@inheritdoc}
     */
    public function patch(int $id): Response
    {
        $em = $this->em;

        $isActive = $this->getCurrentRequestParams()->get('is_active');

        /** @var Classroom $classroom */
        $classroom = $em->getRepository(Classroom::class)
            ->find($id);

        if (empty($classroom)) {
            return new Response(MessageConstantBag::NO_RESULT,
                Response::HTTP_NOT_FOUND
            );
        }

        $classroom->setIsActive($isActive);

        $em->flush();

        return new Response(MessageConstantBag::FIELD_UPDATED_SUCCESSGULLY,
            Response::HTTP_OK
        );
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