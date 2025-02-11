<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Resources;

use PhpClient\Ollama\Contracts\ChatMessages;
use PhpClient\Ollama\Contracts\ModelParameters;
use PhpClient\Ollama\Enums\QuantizationType;
use PhpClient\Ollama\Requests\Management\CheckBlobExistsRequest;
use PhpClient\Ollama\Requests\Management\CopyModelRequest;
use PhpClient\Ollama\Requests\Management\CreateModelRequest;
use PhpClient\Ollama\Requests\Management\DeleteModelRequest;
use PhpClient\Ollama\Requests\Management\ListLocalModelsRequest;
use PhpClient\Ollama\Requests\Management\ListRunningModelsRequest;
use PhpClient\Ollama\Requests\Management\LoadModelRequest;
use PhpClient\Ollama\Requests\Management\PullModelRequest;
use PhpClient\Ollama\Requests\Management\PushModelRequest;
use PhpClient\Ollama\Requests\Management\ShowModelInformationRequest;
use PhpClient\Ollama\Requests\Management\UnloadModelRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

final class ManagementResource extends BaseResource
{
    /**
     * @throws FatalRequestException|RequestException
     */
    public function checkBlobExists(string $digest): Response
    {
        return $this->connector->send(
            request: new CheckBlobExistsRequest(
                digest: $digest,
            ),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function copyModel(string $source, string $destination): Response
    {
        return $this->connector->send(
            request: new CopyModelRequest(
                source: $source,
                destination: $destination,
            ),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function createModel(
        string $model,
        null|string $from = null,
        null|array $files = null,
        null|array $adapters = null,
        null|string $template = null,
        null|string $license = null,
        null|string $system = null,
        null|string|ModelParameters $parameters = null,
        null|array|ChatMessages $messages = null,
        null|bool $stream = null,
        null|string|QuantizationType $quantize = null,
    ): Response {
        return $this->connector->send(
            request: new CreateModelRequest(
                model: $model,
                from: $from,
                files: $files,
                adapters: $adapters,
                template: $template,
                license: $license,
                system: $system,
                parameters: $parameters,
                messages: $messages,
                stream: $stream,
                quantize: $quantize,
            ),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function deleteModel(string $model): Response
    {
        return $this->connector->send(
            request: new DeleteModelRequest(
                model: $model,
            ),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function listLocalModels(): Response
    {
        return $this->connector->send(
            request: new ListLocalModelsRequest(),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function listRunningModels(): Response
    {
        return $this->connector->send(
            request: new ListRunningModelsRequest(),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function loadModel(string $model): Response
    {
        return $this->connector->send(
            request: new LoadModelRequest(
                model: $model,
            ),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function pullModel(string $model, null|bool $insecure = null, null|bool $stream = null): Response
    {
        return $this->connector->send(
            request: new PullModelRequest(
                model: $model,
                insecure: $insecure,
                stream: $stream,
            ),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function pushModel(string $model, null|bool $insecure = null, null|bool $stream = null): Response
    {
        return $this->connector->send(
            request: new PushModelRequest(
                model: $model,
                insecure: $insecure,
                stream: $stream,
            ),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function showModelInformation(string $model, null|bool $verbose = null): Response
    {
        return $this->connector->send(
            request: new ShowModelInformationRequest(
                model: $model,
                verbose: $verbose,
            ),
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function unloadModel(string $model): Response
    {
        return $this->connector->send(
            request: new UnloadModelRequest(
                model: $model,
            ),
        );
    }
}
