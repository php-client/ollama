<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Api;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Retrieve the Ollama version.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#version
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class GetApiVersionRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/version";
    }
}
