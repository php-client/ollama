<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Delete a model and its data.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#delete-a-model
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class DeleteModelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    /**
     * @param  string  $model  Model name to delete
     */
    public function __construct(
        public readonly string $model,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/delete';
    }

    protected function defaultBody(): array
    {
        return [
            'model' => $this->model,
        ];
    }
}
