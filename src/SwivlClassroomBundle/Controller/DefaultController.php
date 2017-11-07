<?php

namespace SwivlClassroomBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SwivlClassroomBundle\Services\ClassroomService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(service="classroom_controller.service")
 */
class DefaultController extends ClassroomService
{
    /**
     * Get all classrooms list
     *
     * @Rest\Get("/")
     */
    public function getAllAction(): Response
    {
        return parent::getAll();
    }

    /**
     * Get one classroom by id
     *
     * @Rest\Get("/{id}")
     * @param int $id
     * @return Response
     */
    public function getAction(int $id): Response
    {
        return parent::getById($id);
    }

    /**
     * Create classroom
     *
     * @Rest\Post("/")
     * @return Response
     */
    public function createAction(): Response
    {
        return parent::create();
    }

    /**
     * Update classroom
     *
     * @Rest\Put("/{id}")
     * @param int $id
     * @return Response
     */
    public function updateAction(int $id): Response
    {
        return parent::update($id);
    }

    /**
     * Delete classroom
     *
     * @Rest\Delete("/{id}")
     *
     * @param int $id
     * @return Response
     */
    public function deleteAction(int $id): Response
    {
        return parent::delete($id);
    }

    /**
     * Update isActive field
     * @Rest\Patch("/{id}")
     *
     * @param int $id
     * @return Response
     */
    public function patchAction(int $id): Response
    {
        return parent::patch($id);
    }
}
