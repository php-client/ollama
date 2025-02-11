<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Copy a model.
 *
 * Creates a model with another name from an existing model.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#copy-a-model
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class CopyModelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $source  Name of existing model
     * @param  string  $destination  Name of new model
     */
    public function __construct(
        public readonly string $source,
        public readonly string $destination,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/copy';
    }

    protected function defaultBody(): array
    {
        return [
            'source' => $this->source,
            'destination' => $this->destination,
        ];
    }
}
