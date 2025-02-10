<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Requests\Generation;

use PhpClient\Ollama\Contracts\ChatMessages;
use PhpClient\Ollama\Contracts\ModelParameters;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

use function array_filter;

final class GenerateChatCompletionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public readonly string $model,
        public readonly ChatMessages|array $messages,
        public readonly null|array $tools = null,
        public readonly null|string $format = null,
        public readonly null|array|ModelParameters $options = null,
        public readonly null|bool $stream = null,
        public readonly null|string $keepAlive = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/chat';
    }

    protected function defaultBody(): array
    {
        $chatMessages = $this->messages instanceof ChatMessages
            ? $this->messages
            : new ChatMessages(messages: $this->messages);

        return array_filter(
            array: [
                'model' => $this->model,
                'messages' => $chatMessages->toArray(),
                'tools' => $this->tools,
                'format' => $this->format,
                'options' => $this->options instanceof ModelParameters
                    ? $this->options->toArray()
                    : $this->options,
                'stream' => $this->stream,
                'keep_alive' => $this->keepAlive,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}
