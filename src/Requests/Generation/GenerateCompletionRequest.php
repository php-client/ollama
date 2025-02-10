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
 * Generate a response for a given prompt with a provided model.
 *
 * This is a streaming endpoint, so there will be a series of responses.
 * The final response object will include statistics and additional data from the request.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#generate-a-completion
 */
final class GenerateCompletionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public readonly string $model,
        public readonly string $prompt,
        public readonly null|string $suffix = null,
        public readonly null|array $images = null,
        public readonly null|string $format = null,
        public readonly null|array|ModelParameters $options = null,
        public readonly null|string $system = null,
        public readonly null|string $template = null,
        public readonly null|bool $stream = null,
        public readonly null|bool $raw = null,
        public readonly null|string $keepAlive = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/generate';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'model' => $this->model,
                'prompt' => $this->prompt,
                'suffix' => $this->suffix,
                'images' => $this->images,
                'format' => $this->format,
                'options' => $this->options instanceof ModelParameters
                    ? $this->options->toArray()
                    : $this->options,
                'system' => $this->system,
                'template' => $this->template,
                'stream' => $this->stream,
                'raw' => $this->raw,
                'keep_alive' => $this->keepAlive,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}
