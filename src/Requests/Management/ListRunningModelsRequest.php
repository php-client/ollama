<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class ListRunningModelsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/ps';
    }
}
