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

/**
 * Generate the next message in a chat with a provided model.
 *
 * This is a streaming endpoint, so there will be a series of responses. Streaming can be disabled using
 * "stream": false. The final response object will include statistics and additional data from the request.
 *
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md#generate-a-chat-completion
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class GenerateChatCompletionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $model  The model name
     * @param  ChatMessages|array  $messages  The messages of the chat, this can be used to keep a chat memory
     * @param  null|array  $tools  List of tools in JSON for the model to use if supported
     * @param  null|string  $format  The format to return a response in. Format can be json or a JSON schema
     * @param  null|array|ModelParameters  $options  Additional model parameters such as temperature
     * @param  null|bool  $stream  If false the response will be returned as a single response object, rather than a stream of objects
     * @param  null|string  $keepAlive  Controls how long the model will stay loaded into memory following the request (default: 5m)
     */
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
