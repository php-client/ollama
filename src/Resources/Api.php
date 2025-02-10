<?php

declare(strict_types=1);

namespace PhpClient\Ollama\Resources;

use PhpClient\Ollama\Requests\Api\GetApiVersionRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

final class Api extends BaseResource
{
    public function completions(): GenerationResource
    {
        return new GenerationResource(
            connector: $this->connector,
        );
    }

    public function management(): ManagementResource
    {
        return new ManagementResource(
            connector: $this->connector,
        );
    }

    /**
     * @throws FatalRequestException|RequestException
     */
    public function version(): Response
    {
        return $this->connector->send(
            request: new GetApiVersionRequest(),
        );
    }
}
