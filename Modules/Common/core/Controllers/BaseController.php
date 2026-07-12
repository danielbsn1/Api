<?php

declare(strict_types=1);

namespace Modules\Common\Core\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Common\Core\Exceptions\BusinessException;
use Modules\Common\Core\Exceptions\NotFoundException;
use Throwable;

abstract class BaseController extends Controller
{
    protected function success(JsonResource|array $data, int $status = 200): JsonResponse
    {
        $payload = $data instanceof JsonResource ? $data->resolve() : $data;

        return response()->json(['data' => $payload], $status);
    }

    protected function created(JsonResource|array $data): JsonResponse
    {
        return $this->success($data, 201);
    }

    protected function paginated(ResourceCollection $data): JsonResponse
    {
        return response()->json($data->resource);
    }

    protected function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }

    protected function error(string $message, int $status = 400): JsonResponse
    {
        return response()->json(['message' => $message], $status);
    }

    protected function execute(callable $action): JsonResponse
    {
        try {
            return $action();
        } catch (NotFoundException $e) {
            return $this->error($e->getMessage(), 404);
        } catch (BusinessException $e) {
            return $this->error($e->getMessage(), $e->getCode());
        } catch (Throwable $e) {
            return $this->error('Erro interno do servidor.', 500);
        }
    }
}
