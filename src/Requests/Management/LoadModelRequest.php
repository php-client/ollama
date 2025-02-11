<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * The model will be loaded into memory.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#load-a-model
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class LoadModelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $model  Name of the model
     */
    public function __construct(
        public readonly string $model
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/generate';
    }

    protected function defaultBody(): array
    {
        return [
            'model' => $this->model
        ];
    }
}
