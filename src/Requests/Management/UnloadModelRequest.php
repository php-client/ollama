<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * A model will be unloaded from memory.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#unload-a-model
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class UnloadModelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $model  Name of the model to unload
     */
    public function __construct(
        public readonly string $model,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/generate';
    }

    protected function defaultBody(): array
    {
        return [
            'model' => $this->model,
            'keep_alive' => 0,
        ];
    }
}
