<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

use function array_filter;

/**
 * Download a model from the ollama library.
 *
 * Cancelled pulls are resumed from where they left off, and multiple calls will share the same download progress.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#pull-a-model
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class PullModelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $model  Name of the model to pull
     * @param  bool|null  $insecure  Allow insecure connections to the library. Only use this if you are pulling
     *  from your own library during development.
     * @param  bool|null  $stream  If false the response will be returned as a single response object,
     *  rather than a stream of objects
     */
    public function __construct(
        public readonly string $model,
        public readonly null|bool $insecure = null,
        public readonly null|bool $stream = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/pull';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'model' => $this->model,
                'insecure' => $this->insecure,
                'stream' => $this->stream,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}
