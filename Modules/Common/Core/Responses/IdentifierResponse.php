<?php

declare(strict_types=1);

namespace Modules\Common\Core\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

readonly class IdentifierResponse implements Responsable
{
    public function __construct(
        private string|int $identifier,
        private int $code = Response::HTTP_OK,
        private array $headers = []
    ) {}

    public function toResponse($request): JsonResponse
    {
        return response()->json(
            ['id' => $this->identifier],
            $this->code,
            $this->headers
        );
    }
}
