<?php

namespace SwivlClassroomBundle\Services;

use Symfony\Component\HttpFoundation\Response;

interface ClassroomInterface
{
    /**
     * @return Response
     */
    public function getAll(): Response;

    /**
     * @param $id
     * @return Response
     */
    public function getById(int $id): Response;

    /**
     * @return Response
     */
    public function create(): Response;

    /**
     * @param int $id
     * @return Response
     */
    public function update(int $id): Response;

    /**
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response;

    /**
     * @param int $id
     * @return Response
     */
    public function patch(int $id): Response;

}