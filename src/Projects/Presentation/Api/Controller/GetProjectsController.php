<?php

declare(strict_types=1);

namespace App\Projects\Presentation\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetProjectsController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'message' => 'it works',
            'method' => __METHOD__,
            'file' => __FILE__,
        ]);
    }
}
