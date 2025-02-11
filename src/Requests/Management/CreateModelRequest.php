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

final class CreateModelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

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
                'messages' => !$this->messages instanceof ChatMessages
                    ? (new ChatMessages(messages: $this->messages))->toArray()
                    : $this->messages,
                'stream' => $this->stream,
                'quantize' => $this->quantize instanceof QuantizationType
                    ? $this->quantize->value
                    : $this->quantize,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}
