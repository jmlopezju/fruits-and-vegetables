<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Search\SearchUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class SearchController extends AbstractController
{
    public function __construct(private readonly SearchUseCase $useCase) {}

    public function __invoke(Request $request): JsonResponse
    {
        $unit = $request->query->getString('unit', 'g');

        $filters = [];
        $filters['type'] = $request->query->getString('type', '');

        if ($minWeight = $request->query->getInt('minWeight')) {
            $filters['minWeight'] = $minWeight;
        }

        try {
            $response = $this->useCase->__invoke($unit, $filters);

            return new JsonResponse($response);
        } catch (Throwable $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
