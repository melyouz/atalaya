<?php
/**
 *
 * @copyright 2019 Mohammadi El Youzghi. All rights reserved
 * @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
 *
 * @link      https://github.com/ayrad
 *
 * @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

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
