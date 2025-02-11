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

/**
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class GenerationResource extends BaseResource
{
    /**
     * Generate a response for a given prompt with a provided model.
     *
     * This is a streaming endpoint, so there will be a series of responses.
     * The final response object will include statistics and additional data from the request.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#generate-a-completion
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @param  string  $model  The model name
     * @param  string  $prompt  The prompt to generate a response for
     * @param  string|null  $suffix  The text after the model response
     * @param  array|null  $images  A list of base64-encoded images (for multimodal models such as llava)
     * @param  string|null  $format  The format to return a response in. Format can be json or a JSON schema
     * @param  array|ModelParameters|null  $options  Additional model parameters such as temperature
     * @param  string|null  $system  System message to
     * @param  string|null  $template  The prompt template to use
     * @param  bool|null  $stream  If false the response will be returned as a single response object,
     * rather than a stream of objects
     * @param  bool|null  $raw  If true no formatting will be applied to the prompt. You may choose to use the raw
     * parameter if you are specifying a full templated prompt in your request to the API
     * @param  string|null  $keepAlive  Controls how long the model will stay loaded into memory following
     * the request (default: 5m)
     *
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
     * Generate the next message in a chat with a provided model.
     *
     * This is a streaming endpoint, so there will be a series of responses. Streaming can be disabled using
     * "stream": false. The final response object will include statistics and additional data from the request.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#generate-a-chat-completion
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @param  string  $model  The model name
     * @param  ChatMessages|array  $messages  The messages of the chat, this can be used to keep a chat memory
     * @param  null|array  $tools  List of tools in JSON for the model to use if supported
     * @param  null|string  $format  The format to return a response in. Format can be json or a JSON schema
     * @param  null|array|ModelParameters  $options  Additional model parameters such as temperature
     * @param  null|bool  $stream  If false the response will be returned as a single response object, rather than a stream of objects
     * @param  null|string  $keepAlive  Controls how long the model will stay loaded into memory following the request (default: 5m)
     *
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
     * Generate embeddings from a model.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#generate-embeddings
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @param  string  $model  Name of model to generate embeddings from
     * @param  string|array  $prompt  Text or list of text to generate embeddings for
     * @param  null|bool  $truncate  Truncates the end of each input to fit within context length.
     * Returns error if false and context length is exceeded. Defaults to true
     * @param  array|ModelParameters|null  $options  Additional model parameters such as temperature
     * @param  string|null  $keepAlive  Controls how long the model will stay loaded into memory following
     * the request (default: 5m)
     *
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
