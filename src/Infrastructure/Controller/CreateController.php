<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Create\CreateUseCase;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateController extends AbstractController
{
    public function __construct(private readonly CreateUseCase $useCase) {}

    public function __invoke(): JsonResponse
    {
        $request = file_get_contents('../request.json');

        $data = json_decode($request, true);

        if (!isset($data) || !is_array($data)) {
            return $this->json(['error' => 'Invalid input'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->useCase->__invoke($data);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Throwable $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(Response::HTTP_CREATED);
    }
}