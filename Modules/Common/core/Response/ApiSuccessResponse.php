<?php

declare(strict_types=1);

namespace Modules\Common\Core\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use JsonSerializable;

readonly class ApiSuccessResponse implements Responsable
{
    public function __construct(
        private mixed $data = null,
        private string $message = 'Operation completed successfully.',
        private int $status = Response::HTTP_OK,
        private array $meta = [],
        private array $headers = [],
    ) {}

    public function toResponse($request): JsonResponse
    {
        $payload = [
            'success' => true,
            'message' => $this->message,
            'data' => $this->transformData(),
            'meta' => empty($this->meta) ? null : $this->meta,
            'timestamp' => now()->toISOString(),
        ];

        return response()->json(
            $payload,
            $this->status,
            $this->headers
        );
    }

    private function transformData(): mixed
    {
        if ($this->data instanceof JsonResource) {
            return $this->data->resolve();
        }

        if ($this->data instanceof JsonSerializable) {
            return $this->data->jsonSerialize();
        }

        return $this->data;
    }
}