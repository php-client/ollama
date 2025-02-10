<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class CheckBlobExistsRequest extends Request
{
    protected Method $method = Method::HEAD;

    public function __construct(
        public readonly string $digest,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/api/blobs/$this->digest";
    }
}
