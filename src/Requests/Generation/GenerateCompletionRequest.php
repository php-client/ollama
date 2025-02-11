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
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class GenerateCompletionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $model  The model name
     * @param  string  $prompt  The prompt to generate a response for
     * @param  string|null  $suffix  The text after the model response
     * @param  array|null  $images  A list of base64-encoded images (for multimodal models such as llava)
     * @param  string|null  $format  The format to return a response in. Format can be json or a JSON schema
     * @param  array|ModelParameters|null  $options  Additional model parameters such as temperature
     * @param  string|null  $system  System message to
     * @param  string|null  $template  The prompt template to use
     * @param  bool|null  $stream  If false the response will be returned as a single response object,
     *  rather than a stream of objects
     * @param  bool|null  $raw  If true no formatting will be applied to the prompt. You may choose to use the raw
     *  parameter if you are specifying a full templated prompt in your request to the API
     * @param  string|null  $keepAlive  Controls how long the model will stay loaded into memory following
     *  the request (default: 5m)
     */
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
