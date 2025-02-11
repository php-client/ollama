<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Resources;

use PhpClient\Ollama\Contracts\ChatMessages;
use PhpClient\Ollama\Contracts\ModelParameters;
use PhpClient\Ollama\Requests\Generation\GenerateChatCompletionRequest;
use PhpClient\Ollama\Requests\Generation\GenerateCompletionRequest;
use PhpClient\Ollama\Requests\Generation\GenerateEmbeddingsRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

final class GenerationResource extends BaseResource
{
    /**
     * @throws FatalRequestException|RequestException
     */
    public function generateCompletion(
        string $model,
        string $prompt,
        null|string $suffix = null,
        null|array $images = null,
        null|string $format = null,
        null|array|ModelParameters $options = null,
        null|string $system = null,
        null|string $template = null,
        null|bool $stream = null,
        null|bool $raw = null,
        null|string $keepAlive = null,
    ): Response {
        return $this->connector->send(
            request: new GenerateCompletionRequest(
                model: $model,
                prompt: $prompt,
                suffix: $suffix,
                images: $images,
                format: $format,
                options: $options,
                system: $system,
                template: $template,
                stream: $stream,
                raw: $raw,
                keepAlive: $keepAlive,
            ),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function generateChatCompletion(
        string $model,
        ChatMessages|array $messages,
        null|array $tools = null,
        null|string $format = null,
        null|array|ModelParameters $options = null,
        null|bool $stream = null,
        null|string $keepAlive = null,
    ): Response {
        return $this->connector->send(
            request: new GenerateChatCompletionRequest(
                model: $model,
                messages: $messages,
                tools: $tools,
                format: $format,
                options: $options,
                stream: $stream,
                keepAlive: $keepAlive,
            ),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function generateEmbeddings(
        string $model,
        string|array $prompt,
        null|bool $truncate = null,
        null|array|ModelParameters $options = null,
        null|string $keepAlive = null,
    ): Response {
        return $this->connector->send(
            request: new GenerateEmbeddingsRequest(
                model: $model,
                prompt: $prompt,
                truncate: $truncate,
                options: $options,
                keepAlive: $keepAlive,
            ),
        );
    }
}
