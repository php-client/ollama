<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Generation;

use PhpClient\Ollama\Contracts\ModelParameters;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

use function array_filter;

/**
 * Generate embeddings from a model.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#generate-embeddings
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class GenerateEmbeddingsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $model  Name of model to generate embeddings from
     * @param  string|array  $prompt  Text or list of text to generate embeddings for
     * @param  null|bool  $truncate  Truncates the end of each input to fit within context length.
     *  Returns error if false and context length is exceeded. Defaults to true
     * @param  array|ModelParameters|null  $options  Additional model parameters such as temperature
     * @param  string|null  $keepAlive  Controls how long the model will stay loaded into memory following
     *  the request (default: 5m)
     */
    public function __construct(
        public readonly string $model,
        public readonly string|array $prompt,
        public readonly null|bool $truncate = null,
        public readonly null|array|ModelParameters $options = null,
        public readonly null|string $keepAlive = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/embeddings';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'model' => $this->model,
                'prompt' => $this->prompt,
                'truncate' => $this->truncate,
                'options' => $this->options instanceof ModelParameters
                    ? $this->options->toArray()
                    : $this->options,
                'keep_alive' => $this->keepAlive,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}
