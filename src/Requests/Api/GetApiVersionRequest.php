<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Api;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class GetApiVersionRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/version";
    }
}
