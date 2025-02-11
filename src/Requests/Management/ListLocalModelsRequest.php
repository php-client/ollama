<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List models that are available locally.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#list-local-models
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class ListLocalModelsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/tags';
    }
}
