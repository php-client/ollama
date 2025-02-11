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

/**
 * @see https://github.com/ollama/ollama/blob/main/docs/api.md
 * @version Relevant for 2025-02-11, Ollama v0.5.1
 */
final class ManagementResource extends BaseResource
{
    /**
     * Ensures that the file blob (Binary Large Object) used with create a model exists on the server.
     *
     * This checks your Ollama server and not ollama.com.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#check-if-a-blob-exists
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @param  string  $digest  The SHA256 digest of the blob
     *
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
     * Copy a model.
     *
     * Creates a model with another name from an existing model.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#copy-a-model
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @param  string  $source  Name of existing model
     * @param  string  $destination  Name of new model
     *
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
     * Create a model from: another model, a safetensors directory or a GGUF file.
     *
     * If you are creating a model from a safetensors directory or from a GGUF file, you must create a blob for each
     * of the files and then use the file name and SHA256 digest associated with each blob in the files field.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#create-a-model
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
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
     * rather than a stream of objects
     * @param  string|QuantizationType|null  $quantize  Quantize a non-quantized (e.g. float16) model
     *
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
     * Delete a model and its data.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#delete-a-model
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @param  string  $model  Model name to delete
     *
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
     * List models that are available locally.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#list-local-models
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @throws FatalRequestException|RequestException
     */
    public function listLocalModels(): Response
    {
        return $this->connector->send(
            request: new ListLocalModelsRequest(),
        );
    }

    /**
     * List models that are currently loaded into memory.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#list-running-models
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @throws FatalRequestException|RequestException
     */
    public function listRunningModels(): Response
    {
        return $this->connector->send(
            request: new ListRunningModelsRequest(),
        );
    }

    /**
     * The model will be loaded into memory.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#load-a-model
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @param  string  $model  Name of the model
     *
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
     * Download a model from the ollama library.
     *
     * Cancelled pulls are resumed from where they left off, and multiple calls will share the same download progress.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#pull-a-model
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @param  string  $model  Name of the model to pull
     * @param  bool|null  $insecure  Allow insecure connections to the library. Only use this if you are pulling
     * from your own library during development.
     * @param  bool|null  $stream  If false the response will be returned as a single response object,
     * rather than a stream of objects
     *
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
     * Upload a model to a model library.
     *
     * Requires registering for ollama.ai and adding a public key first.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#push-a-model
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @param  string  $model  Name of the model to push in the form of <namespace>/<model>:<tag>
     * @param  bool|null  $insecure  Allow insecure connections to the library. Only use this if you are pushing
     * to your library during development.
     * @param  bool|null  $stream  If false the response will be returned as a single response object,
     * rather than a stream of objects
     *
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
     * Show information about a model
     *
     * Including: details, modelfile, template, parameters, license, system prompt.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#show-model-information
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @param  string  $model  Name of the model to show
     * @param  bool|null  $verbose  If set to true, returns full data for verbose response fields
     *
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
     * A model will be unloaded from memory.
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md#unload-a-model
     * @version Relevant for 2025-02-11, Ollama v0.5.1
     *
     * @param  string  $model  Name of the model to unload
     *
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
