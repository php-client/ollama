<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Management;

use PhpClient\Ollama\Contracts\ChatMessages;
use PhpClient\Ollama\Contracts\ModelParameters;
use PhpClient\Ollama\Enums\QuantizationType;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Create a model from: another model, a safetensors directory or a GGUF file.
 *
 * If you are creating a model from a safetensors directory or from a GGUF file, you must create a blob for each
 * of the files and then use the file name and SHA256 digest associated with each blob in the files field.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#create-a-model
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class CreateModelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $model  Name of the model to create
     * @param  string|null  $from  Name of an existing model to create the new model from
     * @param  array|null  $files  A dictionary of file names to SHA256 digests of blobs to create the model from
     * @param  array|null  $adapters  A dictionary of file names to SHA256 digests of blobs for LORA adapters
     * @param  string|null  $template  The prompt template for the model
     * @param  string|null  $license  A string or list of strings containing the license or licenses for the model
     * @param  string|null  $system  A string containing the system prompt for the model
     * @param  string|ModelParameters|null  $parameters  A dictionary of parameters for the model
     * @param  array|ChatMessages|null  $messages  A list of message objects used to create a conversation
     * @param  bool|null  $stream  If false the response will be returned as a single response object,
     *  rather than a stream of objects
     * @param  string|QuantizationType|null  $quantize  Quantize a non-quantized (e.g. float16) model
     */
    public function __construct(
        public readonly string $model,
        public readonly null|string $from = null,
        public readonly null|array $files = null,
        public readonly null|array $adapters = null,
        public readonly null|string $template = null,
        public readonly null|string $license = null,
        public readonly null|string $system = null,
        public readonly null|string|ModelParameters $parameters = null,
        public readonly null|array|ChatMessages $messages = null,
        public readonly null|bool $stream = null,
        public readonly null|string|QuantizationType $quantize = null,

    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/create';
    }

    protected function defaultBody(): array
    {
        $chatMessages = $this->messages instanceof ChatMessages
            ? $this->messages
            : new ChatMessages(messages: $this->messages);

        return array_filter(
            array: [
                'model' => $this->model,
                'from' => $this->from,
                'files' => $this->files,
                'adapters' => $this->adapters,
                'template' => $this->template,
                'license' => $this->license,
                'system' => $this->system,
                'parameters' => $this->parameters instanceof ModelParameters
                    ? $this->parameters->toArray()
                    : $this->parameters,
                'messages' => $chatMessages->toArray(),
                'stream' => $this->stream,
                'quantize' => $this->quantize instanceof QuantizationType
                    ? $this->quantize->value
                    : $this->quantize,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}
